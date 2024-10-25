<div>
    <form wire:submit.prevent="updateRole" class="form">
        <div class="modal-body scroll-y">
        <!--begin::Form-->
            <!--begin::Scroll-->
            <div class="d-flex flex-column scroll-y" >
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="fw-bold form-label mb-2">
                        <span class="required">Role name</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input wire:model="roleName" type="text" class="form-control form-control-rounded @error('roleName') is-invalid @enderror" id="roleName" placeholder="Enter role name">
                    @error('roleName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Permissions-->
                <div class="fv-row">
                    <!--begin::Label-->
                    <label class="fw-bold form-label mb-2 mt-5">Role Permissions</label>
                    <!--end::Label-->
                    <!--begin::Table wrapper-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed gy-5">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 ">
                            @foreach($permissionsGroupedByModule as $moduleName => $permissions)
                                <!--begin::Table row-->
                                <tr>
                                    <!--begin::Label-->
                                    <td class="text-gray-600 " style="width: 25%;margin-bottom: .5rem">{{$moduleName}} :</td>
                                    <!--end::Label-->
                                    <!--begin::Options-->
                                    <td>
                                        <!--begin::Wrapper-->
                                        <div class="d-flex">
                                            @if($permissions)
                                                @foreach($permissions as $permission)
                                                    <!--begin::Checkbox-->
                                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-17">
                                                        <input wire:model="selectedPermissions" class="form-check-input @error('selectedPermissions') is-invalid @enderror" type="checkbox" value="{{ $permission->name }}" id="permission-{{ $permission->id }}">
                                                        <span class="form-check-label">{{$permission->name }}</span>
                                                    </label>
                                                    <!--end::Checkbox-->
                                                @endforeach
                                            @endif
                                                @error('selectedPermissions')
                                                <div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <!--end::Wrapper-->
                                    </td>
                                    <!--end::Options-->
                                </tr>
                                <!--end::Table row-->
                            @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table wrapper-->
                </div>
                <!--end::Permissions-->
            </div>
            <!--end::Scroll-->


        <!--end::Form-->
    </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">
                <span class="indicator-label" wire:loading.remove>Submit</span>
                <span class="indicator-progress" wire:loading>Please wait...	                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
    </form>
</div>
