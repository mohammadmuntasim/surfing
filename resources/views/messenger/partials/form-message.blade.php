<br/>
<form action="{{ route('messages.update', $thread->id) }}" method="post" id="chat-thread-{{$thread->id}}">
    {{ method_field('put') }}
    {{ csrf_field() }}
   

    <div style="display:none">
        @if($users->count() > 0)
            <div class="checkbox">
                <ul id="all-user-list">
                    @foreach($users as $user)
                        <li>
                            <label title="{{ $user->name }}">
                                <input type="checkbox" name="recipients[]" value="{{ $user->id }}">{!!$user->name!!}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Submit Form Input -->
    
    <div class="chat-box-- bg-white" id="">
        <div class="input-group">
            <input type="hidden" id="current-chat-thread" value="{{$thread->id}}">
            <input type="hidden" id="current-user-login" value="{{Auth::user()->id}}">
            <input class="form-control border no-shadow no-rounded" placeholder="Type your message here" name="message">
            <span class="input-group-btn">
                <button class="btn btn-success no-rounded" type="submit">Send</button>
            </span>
        </div>
    </div>   
</form>

