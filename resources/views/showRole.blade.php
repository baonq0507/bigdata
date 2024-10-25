@extends('future::layouts.app')

@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content">
        <!--begin::Layout-->
        <div class="row">
            <!--begin::Sidebar-->
            <div class="col-lg-4 col-xl-3 mb-10">
                <!--begin::Card-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="mb-0">{{$role->name}}</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Permissions-->
                        <div class="text-gray-600">
                            @php $displayedPermissions = $role->permissions->take(5); @endphp
                            @foreach($displayedPermissions as $permission)
                                <div class="py-2">
                                    <span class="bullet bg-primary me-3"></span>{{$permission->name}}</div>
                            @endforeach
                            @if($role->permissions->count() > 5)
                                <div class='py-2'>
                                    <span class='bullet bg-primary me-3'></span>
                                    <em>and {{ $role->permissions->count() - 5 }} more...</em>
                                </div>
                            @endif
                        </div>
                        <!--end::Permissions-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Card footer-->
                    <div class="card-footer">
                        <button type="button" class="btn btn-active-primary" onclick="showUpdateModalByLive({{$role->id}})">Edit Role</button>
                    </div>
                    <!--end::Card footer-->
                </div>
                <!--end::Card-->
                <!--begin::Modal-->
                <!--begin::Modal - Update role-->
                <div class="modal fade" id="modal_update_role" tabindex="-1" aria-hidden="true">
                    <!--begin::Modal dialog-->
                    <div class="modal-dialog modal-dialog-centered " style="max-width: 750px">
                        <!--begin::Modal content-->
                        <div class="modal-content">
                            <!--begin::Modal header-->
                            <div class="modal-header">
                                <!--begin::Modal title-->
                                <h2 class="fw-bold">Update Role</h2>
                                <!--end::Modal title-->
                                <!--begin::Close-->
                                <div class="btn btn-icon btn-sm btn-active-icon-primary" onclick="hiddenUpdateModal()">
                                    <i class="ki-duotone ki-cross fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                                <!--end::Close-->
                            </div>
                            <!--end::Modal header-->
                            <!--begin::Modal body-->
                           @livewire('PermissionResource.Roles.Edit')
                            <!--end::Modal body-->
                        </div>
                        <!--end::Modal content-->
                    </div>
                    <!--end::Modal dialog-->
                </div>
                <!--end::Modal - Update role-->
                <!--end::Modal-->
            </div>
            <!--end::Sidebar-->
            <!--begin::Content-->
            <div class="col-lg-8 col-xl-9">
              @livewire('PermissionResource.Roles.View.Users', ['role' => $role])
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>
    <!--end::Content-->
@endsection
@section('script')
    <script>

        var modal_update_role = new bootstrap.Modal(document.getElementById('modal_update_role'), {
            keyboard: true
        });
        function hiddenUpdateModal() {
            modal_update_role.hide();
        }

        function showUpdateModal() {
            modal_update_role.show();
        }

        function showUpdateModalByLive(id) {
         Livewire.dispatch('editRole', { id: id })
        }

        window.addEventListener('show-update-role-modal', event => {
            showUpdateModal();
        });

        window.addEventListener('hide-update-role-modal', event => {
            hiddenUpdateModal();
        });
    </script>
@endsection
