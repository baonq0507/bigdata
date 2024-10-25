<?php
namespace App\Future;


use App\Future\PermissionResource\Form;
use App\Future\PermissionResource\Table;
use Adminftr\Core\Http\Resource\BaseResource;
use Spatie\Permission\Models\Role;


class PermissionResource extends BaseResource
{
    public function __construct()
    {
        parent::__construct(
            new Table(),
            new Form()
        );
    }

    public function roles()
    {

        return view('role');
    }

    public function showRole($id)
    {
        try {
            $role = Role::with('permissions')->findOrFail($id);

            return view('showRole', compact('role'));
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard.index')->with('error', 'Role not found');
        }
    }
}
