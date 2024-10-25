<?php

namespace Adminftr\Core\Http\Resource;

use Adminftr\Form\Future\BaseForm;
use Adminftr\Table\Future\BaseTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

abstract class BaseResource extends Controller
{
    public ?BaseTable $table = null;

    public ?BaseForm $form = null;

    protected $routeName = null;

    public function __construct(
        ?BaseTable $table = null,
        ?BaseForm $form = null
    ) {
        $this->table = $table;
        $this->form = $form;
    }

    protected function getClassName()
    {
        return get_class($this);
    }

    public function getRouteName()
    {
        return $this->routeName;
    }

    public function index(Request $request)
    {
        $table = $this->table;
        return view('future::resource.index', compact('table'));
    }

    public function create()
    {
        $form = $this->form;

        return view('future::resource.create', compact('form'));
    }

    public function edit($id)
    {
        $form = $this->form;

        return view('future::resource.edit', compact('form', 'id'));
    }
}
