@if(session()->has('message'))
    @if(is_array(session('message')))
        @foreach(session('message') as $message)
            <div class="alert alert-{{  session()->has('message_type') ? 'error' :'success' }}">
                {{ $message }}
            </div>
        @endforeach
    @else
        <div class="alert alert-{{  session()->has('message_type') ? 'error' :'success' }}">
            {{ session('message') }}
        </div>
    @endif
@endif

@if (count($errors)>0)
    <div class="alert alert-danger-cs">
        <ul>
            @foreach($errors->all()  as $error)
                <li style="color: black !important;"> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
