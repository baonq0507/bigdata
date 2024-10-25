<?php
namespace App\Future;
use Adminftr\Core\Http\Resource\BaseResource;
use App\Future\BillOfLadingResource\Form;
use App\Future\BillOfLadingResource\Table;


class BillOfLadingResource extends BaseResource
{
    public function __construct()
    {
        parent::__construct(
            new Table(),
            new Form()
        );
    }
}
