/* 
* Design and develop by SURAJ WASNIK ( suraj.wasnik0126@gmail.com ) at FUDUGO SOLUTIONS PVT. LTD. 
* Licence Authorize by fudugosolutions@2017
*/

/* Open chat box */
function openChatBox(e,userName,partenerUserId,currentUserId,chatThreadId = null) {    
    var targetUser = ($(e).html());
    var userNameId = userName.replace(/ /g, '-'); 
    var userNameId = userNameId.replace(',', '-'); 
     var userNameId = userNameId.replace('.', '-'); 
    var chatBoxId = 'chat-box-'+userNameId +'-'+partenerUserId; 
    var chatHistory = 'Lets start chat';      
    if (chatThreadId != null) {
        var userChatbox = chatBox(chatBoxId,userName,chatThreadId); // Pop up chat box
        if ($("#"+chatBoxId).length == 0) {            
            $('#chat').append(userChatbox);        
        };
    	getInitialChatHistory(chatThreadId,chatBoxId);    
        if ($('div.chat-box-div').length > 3) {
            $('#chat div.chat-box-div:first-child').remove();
        }; 
    }else{
        createNewThread(partenerUserId,currentUserId,chatBoxId,userName); // Create thread
    }    
}

/*Chat box*/
function chatBox(chatBoxId,userName,chatThreadId) {   
    var chatBox = '<div class="user open chat-box-div" id="'+chatBoxId +'"><header><div class="status" id="chat-box-user-is-active"></div><div class="header-text">' + userName + '</div><div class="close setting-thread delete-thread" onclick="deleteThread('+"'"+chatThreadId+"','"+chatBoxId+"'"+')" title="Delete conversesion"><i class="fa fa-trash-o" aria-hidden="true"></i></div><div class="close minimize-thread" onclick="minimizeThread('+"'"+chatBoxId+"'"+')" title="Minimize conversesion"><i class="fa fa-minus" aria-hidden="true"></i> </div><div class="close" onclick="closeChatBox('+"'"+chatBoxId+"'"+')"><i class="fa fa-times" aria-hidden="true"></i></div></header><div class="message-area" id="message-area-'+chatBoxId+'" onscroll="scrollingOnThis(this)"><div class="loader"></div></div><div class="input-area"><input type="text" id="'+chatThreadId+'" placeholder="Type a message..." onkeydown="if(event.keyCode==13) chatThreadReply(this);" onclick="chatTextFieldEvent(this)"/></div></div>';

    return chatBox;
}

/* Close chat Box */
function closeChatBox(id){
	var chatBoxId = '#'+id;
	$(chatBoxId).remove();
}

/* Get chat history */
function getInitialChatHistory(chatThreadId,chatBoxId){    
    $.ajax({
        'url'   :'/messages/'+chatThreadId,
        'type'  :'GET',
        'data'  :{'id':chatThreadId},
        'success':function(result){
            if(result){
                $('#'+chatBoxId+' .message-area').html(result);
                scrollToBottom('chat-div-'+chatThreadId);
            }
        }
    });
}

function getChatHistory(chatThreadId,chatBoxId){
	$.ajax({
        'url'   :'/messages/'+chatThreadId,
        'type'  :'GET',
        'data'  :{'id':chatThreadId},
        'success':function(result){
        	if(result){
        		$('#'+chatBoxId+' .message-area').html(result);
        		//scrollToBottom('chat-div-'+chatThreadId);
        	}
        }
    });
}


function chatThreadReply(s) {    
	var message = s.value;
	var threadId = s.id;    
    $.ajax({
        'url'   :'/messages/update/'+threadId,
        'type'  :'get',
        'data'  :{'id':threadId,'message':message},
        'headers': {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	},
        'success':function(result){
        	if(result){   
                $('#chat-div-'+threadId+' p.no-chat-msg').remove();     		
        		$('#chat-div-'+threadId+' .msg_container_base').append(result);	 
        		scrollToBottom('chat-div-'+threadId);
        	}
        }
    });    
    $('div#chat input#'+threadId).val('');
    event.preventDefault();
}

/* Create Thread */
function createNewThread(partenerUserId,currentUserId,chatBoxId,userName){    
    var subject = '';
    var message = '';
    var threadId = '';
    var recipients = partenerUserId;
    $.ajax({
        'url'   :'/messages/create-thread',
        'type'  :'POST',
        'data'  :{'subject':subject,'message':message,'recipients':recipients},
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'success':function(result){
            if(result){                
                var threadId = result;
                if (threadId != '') {                    
                    var userChatbox = chatBox(chatBoxId,userName,threadId); // Pop up chat box                    
                    if ($("#"+chatBoxId).length == 0) {
                        $('#chat').append(userChatbox);        
                    };                    
                    $('#'+chatBoxId+' .message-area').html('<div class="chat-box-inner" id="chat-div-'+threadId+'"><p class="no-chat-msg">Lets start chat..</p><div class="panel-body msg_container_base"></div></div>'); 
                }; 
            }
        }
    });      
}

function scrollToBottom(elementId){
	var element = document.getElementById(elementId);
    var chatMsgDiv = $('#'+elementId).parent().attr('id');
    $('#chat .message-area#'+chatMsgDiv).scrollTop( element.scrollHeight );	
}


/* Auto ajax Refresh fns */
function autoRefreshChatMainDiv()
{
    $.ajax({
        'url'   :'/messages',
        'type'  :'GET',
        'data'  :{'ajaxChatReload':1},
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'success':function(result){            
            $("#chat-user-list").html(result);
            //console.log('Reload Run ');            
        }
    });
    
}

function autoRefreshChatBoxDiv()
{
    if ($('.chat-box-inner').length > 0) {
        $('.chat-box-inner').each( function () {
            var chatBoxId = $(this).parent().parent().attr('id');
            var chatBoxInnerId = $(this).attr('id');
            var threadId = chatBoxInnerId.replace('chat-div-','').trim();        
            getChatHistory(threadId,chatBoxId);
            //checkOnlineUserOfThread(threadId);
            //console.log('Chat box reload');
        });
    };    
}
/* Minimize conversation */
function minimizeThread(chatBoxId) {    
    $('#'+chatBoxId+' .chat-setting-dropdown ul#chat-box-menu-div').hide();
    $('#'+chatBoxId+' .close.minimize-thread i').toggleClass('fa-minus');
    $('#'+chatBoxId+' .close.minimize-thread i').toggleClass('fa-plus');
    $('#'+chatBoxId+' .message-area').toggle();
    $('#'+chatBoxId+' .input-area').toggle();
}


/* Setting conversation */
function chatBoxMenuToggle(chatBoxId) {
    $('#'+chatBoxId+' .chat-setting-dropdown ul#chat-box-menu-div').toggle();
}

/* Delete conversation */
function deleteThread(chatThreadId,chatBoxId){ 
    $('#'+chatBoxId+' .chat-setting-dropdown ul#chat-box-menu-div').hide();   
    var pieces = chatBoxId.split(/[\s-]+/);
    var userId = pieces[pieces.length-1];    
    //$('#delete-thread-confirm-dialog').modal('show'); 
    //alert('I am here');   
    if(confirm("Once you delete your copy of this conversation, it cannot be undone.")){
        $.ajax({
            'url'   :'/messages/delete',
            'type'  :'GET',
            'data'  :{'threadId':chatThreadId,'userId':userId},
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'success':function(result){            
                $("#"+chatBoxId+" div.message-area").html('No more message.');
                $("#chat #"+chatBoxId).remove();
                alert(result);
                //console.log('Conversastion delete '+result);
            }
        });
    };
}



/* On chat text field change */
function chatTextFieldEvent(s){
    var threadId = s.id;
    $.ajax({
        'url'   :'/messages/read',
        'type'  :'GET',
        'data'  :{'threadId':threadId},
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'success':function(result){    
            //console.log('Conversastion read '+result);
        }
    });
}

//Check user idle or online
$( document ).ready(function() {
    var IDLE_TIMEOUT = 120; //seconds
    var _idleSecondsCounter = 0;
    document.onclick = function() {
        _idleSecondsCounter = 0;
    };
    document.onmousemove = function() {
        _idleSecondsCounter = 0;
    };
    document.onkeypress = function() {
        _idleSecondsCounter = 0;
    };
    window.setInterval(CheckIdleTime, 2000);
    function CheckIdleTime() {
        _idleSecondsCounter = _idleSecondsCounter + 1;
        if (_idleSecondsCounter >= IDLE_TIMEOUT) {            
            $.ajax({
                'url'   :'/messages/set-online-status',
                'type'  :'GET',
                'data'  :{'setOnline':0},
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'success':function(result){    
                    //console.log('Check Online '+result);
                    $('body').removeClass('this-user-active');
                }
            });
        }else{
            $.ajax({
                'url'   :'/messages/set-online-status',
                'type'  :'GET',
                'data'  :{'setOnline':1},
                'headers': {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'success':function(result){    
                    //console.log('Check Online '+result);
                    $('body').addClass('this-user-active');
                }
            });
        }
    }
});

/* Check if thread user is online */
function autoRefreshOnlineUserCheck() {
    if ($('.chat-box-inner').length > 0) {
        $('.chat-box-inner').each( function () {
            var chatBoxId = $(this).parent().parent().attr('id');
            var chatBoxInnerId = $(this).attr('id');
            var threadId = chatBoxInnerId.replace('chat-div-','').trim();  
            checkOnlineUserOfThread(threadId);
            console.log('Chat box reload');
        });
    };  
}
function checkOnlineUserOfThread(threadId){  
    
    var chatBoxId = $('div#chat-div-'+threadId).parent().parent().attr('id');  
    $.ajax({
        'url'   :'/messages/check-online-users',
        'type'  :'GET',
        'data'  :{'checkOnlineUser':1,'threadId':threadId},
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'success':function(result){    
            //console.log('Yes online=== '+result);
            if (result==1) {
                $('div#'+chatBoxId+' header div#chat-box-user-is-active').html('<i class="fa fa-circle" aria-hidden="true"></i>');
            }else{
                $('div#'+chatBoxId+' header div#chat-box-user-is-active').html('');
            }
        }
    });
}

/* Load more message */
var page = 1; //track user scroll as page number, right now page number is 1
if (page == 1) {
    loadMoreMsg(page);//initial content load
};
function scrollingOnThis(chatBox) {
    var chatBoxHeight = $(chatBox).scrollTop();
    var chatBoxId = '#'+chatBox.id;
    if (chatBoxHeight <= 50 && chatBoxHeight >= 49 ) {
        $(chatBoxId+' .msg_container_base').prepend('<div class="row msg_container base_receive"><div class="col-md-2 col-xs-2 avatar pad-0"><img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive "></div><div class="col-md-10 col-xs-10 pad-0"><div class="messages msg_sent"><p>New Msg</p><time datetime="59 minutes ago">59 minutes ago</time></div></div></div>');
        $(chatBoxId+' .msg_container_base').prepend('<div class="row msg_container msg_sent"><div class="col-md-2 col-xs-2 avatar pad-0"><img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive "></div><div class="col-md-10 col-xs-10 pad-0"><div class="messages msg_sent"><p>New Msg</p><time datetime="59 minutes ago">59 minutes ago</time></div></div></div>');
        $(chatBoxId+' .msg_container_base').prepend('<div class="row msg_container base_receive"><div class="col-md-2 col-xs-2 avatar pad-0"><img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive "></div><div class="col-md-10 col-xs-10 pad-0"><div class="messages msg_sent"><p>New Msg</p><time datetime="59 minutes ago">59 minutes ago</time></div></div></div>');
        $(chatBoxId+' .msg_container_base').prepend('<div class="row msg_container base_receive"><div class="col-md-2 col-xs-2 avatar pad-0"><img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive "></div><div class="col-md-10 col-xs-10 pad-0"><div class="messages msg_sent"><p>New Msg</p><time datetime="59 minutes ago">59 minutes ago</time></div></div></div>');
        $(chatBoxId+' .msg_container_base').prepend('<div class="row msg_container base_receive"><div class="col-md-2 col-xs-2 avatar pad-0"><img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive "></div><div class="col-md-10 col-xs-10 pad-0"><div class="messages msg_sent"><p>New Msg</p><time datetime="59 minutes ago">59 minutes ago</time></div></div></div>');
        console.log('Load more'+$(this).scrollTop()); 

    };
}
/*$(window).scroll(function() { //detect page scroll
    alert($(window).scrollTop());
    if($(window).scrollTop() + $(window).height() >= $(document).height()) { //if user scrolled from top to bottom of the page
        page++; //page number increment
        loadMoreMsg(page); //load content   
    }
});*/     
function loadMoreMsg(pageNo){

    $.ajax(
        {
            /*url: '/'+urlname+'?page=' + page,
            type: "get",
            datatype: "html",
            beforeSend: function()
            {
                $('.ajax-loading').show();
            }*/
        })

}



// Refresh after every 1 sec 
setInterval(function() {
    autoRefreshChatBoxDiv();
}, 500);
setInterval(function() {
    autoRefreshChatMainDiv();
}, 1500);
setInterval(function() {
    autoRefreshOnlineUserCheck();
}, 2000);

