<div class="modal fade" wire:ignore id="userSelectModal" tabindex="-1" aria-labelledby="userSelectModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userSelectModalLabel">Select User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="relative" x-data="{ open: false }">
                        <input type="text" id="user-search"
                               class="form-control form-control-rounded" wire:model="selectedUserName"
                               placeholder="Search Users" @click="open = true">
                        <div class="absolute z-10 w-full mt-1 rounded-md shadow-lg" x-show="open"
                             @click.away="open = false">
                            @foreach($users as $user)
                                <div class="cursor-pointer px-4 py-2"
                                     wire:click="selectUser({{ $user->id }},
                                      '{{ $user->name }}'); open = false">
                                    {{ $user->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" wire:click="saveUser">Save changes</button>
            </div>
        </div>
    </div>
</div>
