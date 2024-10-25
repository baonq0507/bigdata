<?php
namespace App\Future;
use Adminftr\Core\Http\Resource\BaseResource;
use App\Future\ContractResource\Form;
use App\Future\ContractResource\Table;
use App\Future\ContractResource\View;
use App\Models\Contract;

class ContractResource extends BaseResource
{
    public function __construct()
    {
        parent::__construct(
            new Table(),
        );
    }

    public function view($id)
    {
        $contract = Contract::find($id)->with(['partyAInfo' => function($query) {
            $query->with('user');
        }, 'partyBInfo' => function($query) {
            $query->with('user');
        }, 'products'])->first();
        return view('contract.showContract', ['contract' => $contract]);
    }
}
