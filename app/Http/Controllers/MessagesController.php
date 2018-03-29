<?php
namespace App\Http\Controllers;
use App\User;
use App\OnlineUser;
use App\DeleteMessage;
use DB;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\UserMetum;
use App\TimelineSharePost;
use App\TimelinePostLike;
use App\UserMedia;
use App\UserFollow;
use App\Notification;
use Redirect;
use App\ConnectionTimelinePost;
use App\UserComment;
use App\UserConnection;
class MessagesController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {

        $header=new HeaderController();
        $data=$header->headerAfterLogin($request='');
        $data['userMetaObj'] = new UserMetum(); 
        $roleController = new RoleController(); 
        $userController = new UserController(); 
        $timelinePostController = new TimelinePostController();
        $data['myphotos'] = new UserMedia();
        $data['otherUserTimelinePosted']=new ConnectionTimelinePost();
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();

        // All threads, ignore deleted/archived participants
        $threads = Thread::getAllLatest()->get();
        if (Auth::user()->id) {
            $userId = Auth::user()->id;
        }else{
            return redirect('/login');
        }
        $users = UserConnection::where('user_id', '=',Auth::id())->orwhere('connect_user_id', '=',Auth::id())->whereNotIn('id', Participant::select('user_id')->whereIn('thread_id',Thread::select('id')->whereIn('id', Participant::select('thread_id')->where('user_id','=',Auth::id())->get())->latest('updated_at')->get())->get())->get();
        // All threads that user is participating in
        $threads = Thread::whereIn('id', Participant::select('thread_id')->where('user_id','=',Auth::id())->get())->latest('updated_at')->get();
        
        //User online status
        $userOnlineStatus = $this->getOnlineUsers();
        $input = Input::all();
        $messageController = new MessagesController();
        if (!empty($input) && $input['ajaxChatReload'] == 1) {            
            return view('messenger.ajaxload.index', compact('data','threads','users','userOnlineStatus','messageController'));
        }
        //$this->getAllThreadOfCurrentUser($uid=Auth::user()->id);
        return view('messenger.index', compact('data','threads','searchdropdown','users','userOnlineStatus','messageController'));
    }
    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            $data['thread'] = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();
        // don't show the current user in list
        $userId = Auth::user()->id;
        /*$users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();
        $participants = User::whereIn('id', $thread->participantsUserIds($userId))->get();  */      
        $data['thread']->markAsRead($userId);
        $data['thread']->latest('id')->paginate(2);
        $data['messageController'] = new MessagesController();
        $input = Input::all();
        $page = 1;
        if (isset($input['page'])) {
            $page = $input['page'];
        }        
        return view('messenger.show', compact('data','page'));
    }
    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messenger.create', compact('users'));
    }
    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store()
    {
        $input = Input::all();
        $thread = Thread::create(
            [
                'subject' => $input['subject'],
            ]
        );
        // Message
        if ($input['message'] != '') {
            Message::create(
                [
                    'thread_id' => $thread->id,
                    'user_id'   => Auth::user()->id,
                    'body'      => $input['message'],
                ]
            );
        }
        
        // Sender
        Participant::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'last_read' => new Carbon,
            ]
        );
        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant($input['recipients']);
        }
        return redirect('messages');
    }




    /* Ajax create new message thread */
    public function createNewThread()
    {
        $input = Input::all(); 
        $thread = Thread::create(
            [
                'subject' => $input['subject'],
            ]
        );
        // Message        
        Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'body'      => $input['message'],
            ]
        );
        
        // Sender
        Participant::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'last_read' => new Carbon,
            ]
        );
        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant($input['recipients']);
        }
        return $thread->id;
    }


    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {        
         $header=new HeaderController();
        $data=$header->headerAfterLogin($request='');
        $data['userMetaObj'] = new UserMetum(); 
        $roleController = new RoleController(); 
        $userController = new UserController(); 
        $timelinePostController = new TimelinePostController();
        $data['myphotos'] = new UserMedia();
        $data['otherUserTimelinePosted']=new ConnectionTimelinePost();
        $searchdropdown=$data['userdatabyid']->getSearchDropdownList();
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect('messages');
        }
        $thread->activateAllParticipants();
        // Message
        $message = Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::id(),
                'body'      => Input::get('message'),
            ]
        );
        // Add replier as a participant
        $participant = Participant::firstOrCreate(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
            ]
        );
        $participant->last_read = new Carbon;
        $participant->save();
        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant(Input::get('recipients'));
        } 
        if ($thread->status == 1) {
            Thread::where(['id' => $id])->update(['status' => 0]);
        }
        echo view('messenger.partials.ajax-messages', compact('data','message'));       
        //return redirect('messages/' . $id);
    }

    /* Delete Conversation */
    public function deleteConversation()
    {
        $input = Input::all(); 
        $threadId = Input::get('threadId');
        $userId = Input::get('userId');
        $threadObj = Thread::select()->where(['id' => $threadId, 'status'=>1])->whereNotIn('id', DeleteMessage::select('thread_id')->where(['user_id'=> Auth::user()->id])->get())->pluck('status');
        if ($threadObj->count() > 0) {            
            DB::table('messenger_threads')->where('id','=',$threadId)->delete();
            DB::table('delete_threads')->where(['thread_id' => $threadId])->delete();
            DB::table('messenger_participants')->where(['thread_id' => $threadId])->delete();
            DB::table('messenger_messages')->where(['thread_id' => $threadId])->delete();
            echo "Delete done";
        }else{
            Thread::where('id',$threadId)->update(['status' => 1]);        
            DB::table('delete_threads')->insert(['thread_id' => $threadId, 'user_id' => Auth::user()->id]);
            Message::where(['thread_id' => $threadId])->update(['is_delete'=>1]);
        }
        echo 'Done';
    }

    /* Read Message */
    public function readMessage()
    {
        $input = Input::all(); 
        $threadId = Input::get('threadId');
        $participant = Participant::select('user_id')->where('user_id','!=',Auth::id())->where('thread_id', '=', $threadId)->pluck('user_id');
        $participantUserId = $participant[0];
        Message::where(['thread_id'=>$threadId,'user_id'=>$participantUserId])->update(['is_read'=>1]);
        //print_r($participant[0]);
        echo "Done";
    }

    /*Check if user are online */

    public function checkUserOnline()
    {
        $input = Input::all();
        /* Check for thread user */
        if (isset($input['checkOnlineUser']) && isset($input['threadId'])) {
            $threadId = $input['threadId'];
            $participant = Participant::where('thread_id', '=', $threadId)->where('user_id', '!=', Auth::user()->id)->pluck('user_id');
            $isUserOnline = OnlineUser::select('user_id')->where(['user_id'=>$participant[0],'status'=>1])->get();
            if ($isUserOnline->count()>0) {
                echo 1;
            }else{
                echo 0;
            }
            
        }
        
    }


    /* Set online status */
    public function setUserOnline()
    {
        $input = Input::all();
        // $onlineUsers = $this->getOnlineUsers();
        /* Check for non thread but connected users */
        if (isset($input['setOnline']) && $input['setOnline'] >= 0) {
            $this->setUserOnlineStatus($input['setOnline']);
            return $input['setOnline'];
        }
    }
    public function setUserOnlineStatus($status=0)
    {        
        OnlineUser::where(['user_id'=>Auth::user()->id])->update(['status'=>$status]);
    }

    /* get online Users */
    public function getOnlineUsers($uid = null)
    {        
        return OnlineUser::select('user_id')->where(['status'=>1])->get();
    }
    /*Is message delete */
    public function isMessageDelete($messageId,$threadId)
    {
        $isMessageDelete = Message::select('id')->where(['id'=>$messageId,'is_delete' => 1])->whereIn('thread_id', DeleteMessage::select('thread_id')->where(['thread_id'=>$threadId,'user_id'=>Auth::user()->id])->get())->count();

        return $isMessageDelete;
    }
    /*Is message delete */
    public function getAvatarAttribute($threadId)
    {
         $thread2='';
       
         $threads1 = Participant::where([['thread_id','=', $threadId],['user_id','<>', Auth::user()->id]])->get();
         foreach ($threads1 as $threads1) {
         /* $thread2= $threads1->user_id;*/
           $thread2= User::where('id','=', $threads1->user_id)->pluck('avatar');
         }
        
        return $thread2[0];
    }

}