<div class="alert-container">
    <div x-data="alerts()" :class="`alert alert-important alert-${type} alert-dismissible`" x-show="show" role="alert">
        <div class="d-flex">
            <div x-html="icon"></div>
            <div>
                <div class="title" x-text="title"></div>
                <div class="description" x-text="message"></div>
            </div>
        </div>
        <button type="button" class="btn-close" @click="close()" aria-label="Close"></button>
    </div>
</div>


<script>
    function alerts() {
        return {
            show: false,
            title: 'Chào mọi người',
            message: '',
            type: 'success',
            icon: '',
            fadeTimeout: null,
            autoHideTimeout: null,

            init() {
                window.Livewire.on('alert', (title, message, type) => {
                    this.showAlert(title, message, type);
                });
                window.Livewire.on('alert-success', (title, message) => {
                    this.showSuccess(title, message);
                });
                window.Livewire.on('alert-error', (title, message) => {
                    this.showError(title, message);
                });
                window.Livewire.on('alert-info', (title, message) => {
                    this.showInfo(title, message);
                });
                window.Livewire.on('alert-warning', (title, message) => {
                    this.showWarning(title, message);
                });
                this.$watch('show', (newVal) => {
                    if (newVal) {
                        this.$el.addEventListener('mouseenter', this.startFade);
                        this.$el.addEventListener('mouseleave', this.stopFade);
                    } else {
                        this.$el.removeEventListener('mouseenter', this.startFade);
                        this.$el.removeEventListener('mouseleave', this.stopFade);
                    }
                });
            },

            startFade() {
                this.fadeTimeout = setTimeout(() => {
                    this.$el.classList.add('fade-out');
                }, 1000);
            },

            stopFade() {
                clearTimeout(this.fadeTimeout);
                this.$el.classList.remove('fade-out');
            },

            showAlert(title, message, type) {
                this.title = title;
                this.message = message;
                this.type = type;
                this.icon = this.getIcon(type);
                this.show = true;

                clearTimeout(this.autoHideTimeout);
                this.autoHideTimeout = setTimeout(() => {
                    this.show = false;
                }, 2000);
            },

            showSuccess(title, message) {
                this.showAlert(title, message, 'success');
            },

            showError(title, message) {
                this.showAlert(title, message, 'danger');
            },

            showInfo(title, message) {
                this.showAlert(title, message, 'info');
            },

            showWarning(title, message) {
                this.showAlert(title, message, 'warning');
            },

            close() {
                this.show = false;
            },

            getIcon(type) {
                switch (type) {
                    case 'success':
                        return `
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>`;
                    case 'danger':
                        return `
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9v2m0 4v.01"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>`;
                    case 'warning':
                        return `
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9v2m0 4v.01"></path>`;
                    case 'info':
                        return `
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 9v2m0 4v.01"></path>`;
                    default:
                        return '';
                }
            }
        };
    }
</script>
