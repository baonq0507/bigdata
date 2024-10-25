<div class="card-header">
    <div>
        <div class="row align-items-center">
            <div class="col-auto">
                @if($user->avatar)
                    <span class="avatar" style="background-image: url({{asset($user->avatar)}})"></span>
                @else
                    <span class="avatar">
                                    {{ $user->name[0] }}
                                </span>
                @endif
            </div>
            <div class="col">
                <div class="card-title">{{$user->name}}</div>
                <div class="card-subtitle">{{$user->type}}</div>
            </div>
        </div>
    </div>
    <div class="card-actions">
        <a href="#" class="btn">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                 stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path
                    d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0
                                 1 -15 -15a2 2 0 0 1 2 -2"></path>
            </svg>
            Phone
        </a>
        @include('messages::components.profile',['user' => $user])
    </div>
</div>
