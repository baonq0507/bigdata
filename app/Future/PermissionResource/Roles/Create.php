<?php

namespace App\Future\PermissionResource\Roles;

use DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public $roleName; // Holds the name of the new role
    public $selectedPermissions = []; // Holds the selected permissions


    public function render()
    {
        $permissions = Permission::all()->sortBy(function ($permission) {
            list($moduleName) = explode('.', $permission->name, 2);
            return $moduleName;
        });

        $permissionsGroupedByModule = $permissions->groupBy(function ($permission) {
            list($moduleName) = explode('.', $permission->name, 2);
            return $moduleName;
        });

        return view('livewire.roles.create', [
            'permissionsGroupedByModule' => $permissionsGroupedByModule
        ]);
    }

    public function submit()
    {
        $this->validate([
            'roleName' => 'required|unique:roles,name',
            'selectedPermissions' => 'array',
        ]);

        DB::beginTransaction();

        try {
            $role = Role::create(['name' => $this->roleName]);
            $role->givePermissionTo($this->selectedPermissions);

            DB::commit();

            $this->dispatch('showToast', [
                'title' => 'thành công',
                'message' => 'Tạo role thành công.'
            ]);
            $this->reset();
        } catch (\Exception $e) {
            DB::rollBack();
           $this->dispatch('showToast', [
                'title' => 'lỗi',
                'message' => 'Something went wrong.'
            ]);
        }
        $this->dispatch('roleUpdated');
        $this->dispatch('hide-create-role-modal');
    }
}
