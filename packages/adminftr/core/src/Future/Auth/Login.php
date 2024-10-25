<?php

namespace Adminftr\Core\Future\Auth;

use Livewire\Component;

class Login extends Component
{
    public $email;

    public $password;

    public function render()
    {
        return view('future::future.auth.login');
    }

    public function login()
    {
        $this->validate();
        if (auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->intended(route('admin.dashboard.index'));
        }
        $this->addError('email', 'Email or password is incorrect');
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }
}
