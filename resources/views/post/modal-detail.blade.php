<div class="modal modal-blur fade" wire:ignore.self id="{{$name}}" tabindex="-1" aria-labelledby="{{$name}}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @isset($post->status)
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            @if($post->status == 'published')
                            <span class="badge bg-success text-white">{{__('Hoạt động')}}</span>
                            @elseif($post->status == 'waiting')
                            <span class="badge bg-warning text-white">{{__('Khoá')}}</span>
                            @else
                            <span class="badge bg-danger text-white">{{__('Nháp')}}</span>
                            @endif
                        </div>
                    </div>
                @endisset
                @isset($post->user)
                <div class="row align-items-center">
                    <img src="{{$post->user->avatar}}" alt="{{$post->user->name}}" class="rounded-circle" width="50" height="50">
                    <p>{{$post->user->name}}</p>
                </div>
                @endisset

                @isset($post->images)
                <div class="row">
                    @foreach ($post->images as $image)
                    <img src="{{$image->image}}" alt="" class="rounded">
                    @endforeach
                </div>
                @endisset

                @isset($post->title)
                <p>{{$post->title}}</p>
                @endisset

                @isset($post->content)
                <p>{{$post->content}}</p>
                @endisset

                @isset($post->field)
                <p>{{$post->field}}</p>
                @endisset
            </div>
        </div>
    </div>
</div>
