<?php

namespace App\Future\PaymentManagementResource\Modal;

use Adminftr\Form\Future\BaseModal;
use Adminftr\Form\Future\ModalForm;
use App\Models\Contract;
use Livewire\Attributes\On;
use Adminftr\Form\Future\Components\Fields\TextInput;
use Adminftr\Form\Future\Components\Layouts\Row;
use Adminftr\Form\Future\Components\Form;

class AccpectPayment extends ModalForm
{
    public $model = Contract::class;

    public $contract;

    #[On('setModel')]
    public function setData($id)
    {
        $this->contract = Contract::with(['partyAInfo' => function ($query) {
            $query->with('user');
        }])->find($id);
    }

    public function form(Form $form)
    {
    }

    public function render()
    {
        return view('payment.modal-accpect');
    }

    public function getRules(): array
    {
        return [];
    }

    public function acceptPayment()
    {
        $this->contract->update(['status' => 'accepted']);
        $this->dispatch('closeModal');
    }

    public function rejectPayment()
    {
        $this->contract->update(['status' => 'returned']);
        $this->dispatch('closeModal');
    }
}
