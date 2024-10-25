<div x-data="modalAlerts">
    <div class="modal" id="alterModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div :class="`modal-status bg-${type}`"></div>
                <div class="modal-body text-center py-4">
                    <div x-html="iconData"></div>
                    <h3 x-text="title"></h3>
                    <div class="text-secondary" x-text="message"></div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col"><a class="btn w-100" @click="onNo" x-text="labelNo"></a></div>
                            <div class="col"><a :class="`btn w-100 btn-${type}`" @click="onYes" x-text="labelYes"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function modalAlerts() {
        return {
            title: 'Are you sure?',
            message: 'Do you really want to remove 84 files? What you\'ve done cannot be undone.',
            modal: new bootstrap.Modal(document.getElementById('alterModal')),
            type: 'danger',
            name: '',
            nameMethod: '',
            params: [],
            labelYes: 'Yes',
            labelNo: 'No',
            iconData: '',
            init() {
                this.iconData = this.getIconData(this.type);
                this.watchEvent();
            },
            getIconData(type) {
                const icons = {
                    danger: `
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 9v2m0 4v.01"/>
                            <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"/>
                        </svg>
                    `,
                    warning: `
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-warning icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 8v5m0 4v.01"/>
                            <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"/>
                        </svg>
                    `,
                    info: `
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-info icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 8v.01"/>
                            <path d="M12 12v6"/>
                            <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z"/>
                        </svg>
                    `,
                    success: `
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-success icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M9 12l2 2l4 -4"/>
                        </svg>
                    `,
                    primary: `
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-primary icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 12l5 5L20 7"/>
                            <path d="M2 12l5 5m5-5l5-5"/>
                        </svg>
                    `
                };
                return icons[type] || icons['success'];
            },
            close() {
                this.modal.hide();
            },
            show() {
                this.modal.show();
            },
            watchEvent() {
                window.Livewire.on('modalAlert', (event) => {
                    this.title = event.title;
                    this.name = event.name;
                    this.message = event.message;
                    this.type = event.type;
                    this.nameMethod = event.nameMethod;
                    this.params = event.params;
                    this.labelYes = event.labelYes || 'Yes';
                    this.labelNo = event.labelNo || 'No';
                    this.iconData = this.getIconData(this.type);
                    this.show();
                });
            },
            onYes() {
                this.close();
                window.Livewire.dispatch(this.nameMethod, {
                    data: this.params,
                    name: this.name
                });
            },
            onNo() {
                this.close();
            }
        };
    }
</script>
