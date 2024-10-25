<div class="card-body" x-data="loginForm">
    <h2 class="h2 text-center mb-4">{{ __('future::auth.login_to_your_account') }}</h2>
    <form x-on:submit.prevent="submit">
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('future::auth.email_address') }}</label>
            <input id="email" type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror"
                   placeholder="{{ __('future::auth.your_email_address') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-2">
            <label class="form-label" for="password">
                {{ __('future::auth.password') }}
                <span class="form-label-description">
                    <a href="{{ route('forgot-password') }}">{{ __('future::auth.i_forgot_password') }}</a>
                </span>
            </label>
            <div class="mb-3">
                <input id="password" type="password" wire:model="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="{{ __('future::auth.your_password') }}">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-2">
            <label class="form-check" for="remember-me">
                <input id="remember-me" type="checkbox" class="form-check-input"/>
                <span class="form-check-label">{{ __('future::auth.remember_me_on_this_device') }}</span>
            </label>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn rounded rounded-5 btn-primary w-100" :disabled="loading">
                <span x-text="loading ? '{{ __('future::auth.loading') }}' : '{{ __('future::auth.sign_in') }}'"></span>
            </button>
        </div>
    </form>
</div>

@script
<script>
    Alpine.data('loginForm', () => ({
        email: '',
        password: '',
        loading: false,
        submit() {
            this.loading = true;
            this.$wire.login().then(() => {
                this.loading = false;
            }).catch(error => {
                this.loading = false;
                console.log(error);
            });
        }
    }));
</script>
@endscript
