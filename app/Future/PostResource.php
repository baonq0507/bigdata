<?php
namespace App\Future;
use App\Future\PostResource\Form;
use App\Future\PostResource\Table;
use Adminftr\Core\Http\Resource\BaseResource;


class PostResource extends BaseResource
{
    public function __construct()
    {
        parent::__construct(
            new Table(),
            new Form()
        );
    }
}
