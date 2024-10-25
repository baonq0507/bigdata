<div class="mb-3">
    <label class="form-label" for="{{ $name }}">{{$label}}</label>
    <input type="text" class="form-control" id="{{$name}}" name="{{$name}}"
           wire:model.defer="filters.{{$name}}"
           placeholder="{{$placeholder}}">
</div>
