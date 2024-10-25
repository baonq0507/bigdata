<?php

namespace App\Future\PermissionResource\Roles;

use DB;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    // Add the listeners array
    protected $listeners = ['roleUpdated' => 'reloadRoles', 'deleteRole' => 'deleteRole'];

    public function deleteRole($roleId)
    {
        $role = Role::findById($roleId);

        if ($role) {
            DB::transaction(function () use ($role) {
                // Detach all permissions before deleting
                $role->permissions()->detach();
                $role->delete();
            });

            $this->dispatch('alert-success', 'Role deleted successfully.', 'Success');
        } else {
            $this->dispatch('alert-error', 'Role not found.', 'Error');
        }
    }

    public function render()
    {
        $roles = Role::with(['permissions', 'users'])->paginate();

        return view('livewire.roles.index', compact('roles'));
    }
}
