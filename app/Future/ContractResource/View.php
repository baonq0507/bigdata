<?php

namespace App\Future\ContractResource;

use Livewire\Component;
use App\Models\Contract;


class View extends Component
{
    public $contract;
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('contract.showContract', [
            'contract' => $this->contract
        ]);
    }

    public function mount($id){
        $this->contract = Contract::find($id);
    }

    public function getContract(){
        return $this->contract;
    }
}

