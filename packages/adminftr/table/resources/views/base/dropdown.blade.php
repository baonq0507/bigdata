<div class='dropdown action-dropdown'>
    <button class="btn align-text-top border-0 text-box" data-bs-toggle='dropdown' data-bs-auto-close="outside">
        <i class="fa-solid fa-ellipsis-vertical" style="font-size:20px;"></i>
    </button>
    <ul class='dropdown-menu dropdown-menu-end'>
        @foreach($actions as $action)
            <li>
                {{$action->render()}}
            </li>
        @endforeach
    </ul>
</div>
