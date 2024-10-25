<?php

namespace App\Future\PaymentManagementResource\Modal;

use Adminftr\Form\Future\BaseModal;

class Base extends BaseModal
{
    public function form(\Adminftr\Form\Future\Components\Form $form)
    {
        return $form->schema([
        ]);
    }

    public function render()
    {
        $name = $this->getName();
        return view('payment.modal-accpect', compact('name'));
    }
}
