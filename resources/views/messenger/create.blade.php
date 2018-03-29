@extends('layouts.app')

@section('content')
    <h1>Create a new message</h1>
    <form action="{{ route('messages.store') }}" method="post">
        {{ csrf_field() }}
        <div class="col-md-6">
            <!-- Subject Form Input -->
            <div class="form-group" style="display:none">
                <label class="control-label">Subject</label>
                <input type="text" class="form-control" name="subject" placeholder="Subject"
                       value="{{ old('subject') }}">
            </div>

            <!-- Message Form Input -->
            <div class="form-group">
                <label class="control-label">Message</label>
                <textarea name="message" class="form-control">{{ old('message') }}</textarea>
            </div>
            <div style="display:none">
                @if($users->count() > 0)
                    <div class="checkbox">
                        <ul id="all-user-list">
                            @foreach($users as $user)
                                <li>
                                    <label title="{{ $user->name }}">
                                        <input type="checkbox" name="recipients[]" value="{{ $user->id }}" <?php  if(isset($_GET['u']) && $_GET['u'] == $user->id) { echo 'checked'; } ?>>{!!$user->name!!}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif    
            </div>        
    
            <!-- Submit Form Input -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary form-control">Submit</button>
            </div>
        </div>
    </form>
@stop
