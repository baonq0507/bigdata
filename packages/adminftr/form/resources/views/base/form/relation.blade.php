@php
    $path = explode('.', $name);
@endphp

<div x-data="relation{{ $path[0] }}">
    <div class="card mt-3">
        <div class="card-header d-flex align-items-center">
            <h3 class="card-title">
                {{ $title }}
            </h3>
            <a x-show="items.length > 0" href="#" class="btn btn-primary ms-auto" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd{{ $name }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                </svg> Add new
            </a>
        </div>

        <div class="list-group list-group-flush" x-show="items.length > 0">
            <template x-for="(item, index) in items" :key="index">
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-auto" x-show="item.avatar">
                            <span class="avatar" :style="'background-image: url(' + item.avatar + ')'"></span>
                        </div>
                        <div class="col text-truncate">
                            <p  class="text-reset d-block" x-text="item.name"></p>
                            <div class="d-block text-secondary text-truncate mt-n1" x-text="item.description"></div>
                        </div>
                        <div class="col-auto">
                            <p class="text-secondary" x-text="item.sub_title"></p>
                            <a @click="deleteItemRelation(item)"  class="btn btn-sm btn-danger">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="empty" x-show="items.length === 0">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56"
                     viewBox="0 0 24 24" fill="currentColor" class="icon">
                    <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2z"></path>
                    <path d="M12 8v4"></path>
                    <circle cx="12" cy="16" r="1"></circle>
                </svg>
            </div>
            <p class="empty-title">No results found</p>
            <p class="empty-subtitle text-secondary">
                Try adjusting your search or filter to find what you're looking for.
            </p>
            <div class="empty-action">
                <a href="#" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd{{ $name }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                        <path d="M12 5v14"></path>
                        <path d="M5 12h14"></path>
                    </svg> Add New
                </a>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end offcanvas-relation" tabindex="-1" id="offcanvasEnd{{ $name }}" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasEndLabel">{{ $title }}</h5>
            <a class="btn btn-primary" @click="addItems()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                </svg> Add items
            </a>
        </div>
        <div class="offcanvas-body">
            <form class="d-flex" role="search">
                <div class="input-icon mb-3 w-100">
                    <input type="text" x-model="search" class="form-control" placeholder="Search…">

                    <span class="input-icon-addon" >
                            <template x-if="loading">
                            <!-- Loading icon -->
                          <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                        </template>
                          <template x-if="!loading">
                            <!-- Search icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                                <circle cx="10" cy="10" r="7"></circle>
                                <line x1="21" y1="21" x2="15" y2="15"></line>
                            </svg>
                        </template>

                    </span>
                </div>
            </form>

            <div class="list-group list-group-flush">
                <template x-for="(item, index) in listItems" :key="index">
                    <div class="list-group-item" >
                        <div class="row align-items-center" style="cursor: pointer;"
                        x-on:click="item.active = !item.active"
                        >
                            <div class="col-auto">
                                <input type="checkbox" class="form-check-input" x-model="item.active">
                            </div>
                            <div class="col-auto" x-show="item.avatar" >
                                <span class="avatar" :style="'background-image: url(' + item.avatar + ')'"></span>
                            </div>
                            <div class="col text-truncate">
                                <p class="text-reset d-block d-flex justify-content-between">
                                    <span x-text="item.name"></span>
                                    <span x-text="item.sub_title"></span>
                                </p>
                                <div class="d-block text-secondary text-truncate mt-n1" x-text="item.description">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="empty" x-show="loading">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56"
                         viewBox="0 0 24 24" fill="currentColor" class="icon animate-spin">
                        <circle cx="12" cy="12" r="10" stroke-opacity=".4"></circle>
                        <path d="M14 2a10 10 0 0 0-9.2 6" class="loading-path"></path>
                    </svg>
                </div>
                <p class="empty-title">Searching...</p>
                <p class="empty-subtitle text-secondary">
                    Please wait while we search for results.
                </p>
            </div>
            <div class="empty" x-show="!loading && listItems.length === 0">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56"
                         viewBox="0 0 24 24" fill="currentColor" class="icon">
                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2z"></path>
                        <path d="M12 8v4"></path>
                        <circle cx="12" cy="16" r="1"></circle>
                    </svg>
                </div>
                <p class="empty-title">No results found</p>
                <p class="empty-subtitle text-secondary">
                    Try adjusting your search or filter to find what you're looking for.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Alpine.data('relation{{ $path[0] }}', () => ({
            search: '',
            loading: false,
            bsOffcanvas: new bootstrap.Offcanvas(document.getElementById('offcanvasEnd{{ $name }}')),
            listItems: [],
            items: [],
            debounceTimeout: null,
            init() {
                this.$watch('search', () => {
                    this.search = this.search.replace(/^\s+/, '');
                    this.loading = true;
                    if (this.debounceTimeout) {
                        clearTimeout(this.debounceTimeout);
                    }
                    this.debounceTimeout = setTimeout(() => {
                        this.filteredItems().then(() => {
                            this.loading = false;
                        });
                    }, 500);
                });
            },
            addItems() {
                this.items = [...this.items, ...this.listItems.filter(item => item.active)];
                this.items = this.items.reduce((acc, current) => {
                    const x = acc.find(item => item.id === current.id);
                    if (!x) {
                        acc.push(current);
                    }
                    return acc;
                }, []);
                this.listItems = [];
                this.search = '';
                this.bsOffcanvas.hide();
            },
            deleteItemRelation(item) {
                this.items = this.items.filter(i => i.id !== item.id);
            },
            async filteredItems() {

               if (this.search.length > 0) {
                   try {
                       this.loading = true;
                       const response = await @this.call('getItemsRelation', '{{ $path[0] }}', this.search);
                       this.listItems = response;
                   } catch (error) {
                       console.error('Error fetching filtered items:', error);
                   } finally {
                       this.loading = false;
                   }
                } else {
                    this.listItems = [];
                }
            }
        }));
    });
</script>
