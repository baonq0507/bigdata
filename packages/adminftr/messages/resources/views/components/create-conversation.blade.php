<a href="#" class="pt-2 ps-2" data-bs-toggle="modal" data-bs-target="#createConversation">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24"
         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
         stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
        <path d="M16 19h6"/>
        <path d="M19 16v6"/>
        <path d="M6 21v-2a4 4 0 0 1 4 -4h4"/>
    </svg>
</a>
<div class="modal fade" id="createConversation" tabindex="-1"
     aria-labelledby="createConversationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createConversationLabel">Create Conversation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body " x-data="users">
                <div class="mb-3">
                    <label for="searchUser" class="form-label">Search User</label>
                    <input type="text" wire:model.live.debounce.300ms="searchUser"
                           class="form-control" id="searchUser" placeholder="Search User">
                </div>
                <div class="list-group list-group-flush scrollable scroll-y" style="height: 200px">
                    <template x-for="(user, index) in users.data" :key="index">
                        <a href="#" class="list-group-item list-group-item-action"
                           @click.prevent="createConversation(user.id)">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <template x-if="user.avatar">
                                                    <span class="avatar"
                                                          :style="'background-image: url(' + avatarUrl(user.avatar) + ')'"></span>
                                    </template>
                                    <template x-else>
                                        <span class="avatar" x-text="user.name[0]"></span>
                                    </template>
                                </div>
                                <div class="col text-truncate">
                                    <div x-text="user.name"></div>
                                    <div class="text-secondary text-truncate w-100" x-text="user.email">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </template>
                    <template x-if="users.total > 10 && users.current_page < users.last_page">
                        <div x-data="{}" x-intersect="$wire.loadMoreUsers()"
                             class="list-group-item list-group-item-action">
                            <ul class="list-group list-group-flush placeholder-glow">
                                <li class="list-group item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar avatar-rounded placeholder"></div>
                                        </div>
                                        <div class="col-7">
                                            <div class="placeholder placeholder-xs col-9"></div>
                                            <div class="placeholder placeholder-xs col-7"></div>
                                        </div>
                                        <div class="col-2 ms-auto text-end">
                                            <div class="placeholder placeholder-xs col-8"></div>
                                            <div class="placeholder placeholder-xs col-10"></div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@script
<script>
    Alpine.data('users', () => ({
        search: @entangle('searchUser'),
        users: [],
        userId: @entangle('user'),
        open: false,
        avatarUrl: function (url) {
            if (url.startsWith('https')) {
                return url;
            } else {
                return '{{ asset('') }}' + url;
            }
        },
        init() {
            if (this.users.length === 0) {
                this.users = $wire.get('users');
            }
            this.$watch('$wire.users', (value, old) => {
                if (this.search) {
                    this.users = value;
                } else {
                    this.users.data = this.users.data.concat(value.data);
                    let {data, ...rest} = value; // exclude data from value
                    Object.assign(this.users, rest); // copy the rest properties to this.users
                }
            });
        },
        createConversation(id) {
            this.userId = id;
            $wire.call('createConversation').then(() => {
                var modal = bootstrap.Modal.getInstance(document.getElementById('createConversation'));
                modal.hide();
            });
        },
    }));
</script>
@endscript
