<?php
namespace App\Future;
use App\Future\UserResource\Form;
use App\Future\UserResource\Table;
use Adminftr\Core\Http\Resource\BaseResource;


class UserResource extends BaseResource
{
    public function __construct()
    {
        parent::__construct(
            new Table(),
            new Form()
        );
    }
}
