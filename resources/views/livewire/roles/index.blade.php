<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
    <!--begin::Col-->
    @foreach($roles as $role)
        <div class="col-md-4">
            <div class="card card-flush h-100">
                <div class="card-header">
                    <div class="card-title">
                        <h2>{{ $role->name }}</h2>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="fw-bold text-gray-600 mb-2 ">Total users with this role: {{ $role->users()->count() }}</div>
                    <div class="d-flex flex-column text-gray-600">
                        @php $displayedPermissions = $role->permissions->take(5); @endphp
                        @foreach($displayedPermissions as $permission)
                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>{{ $permission->name }}
                            </div>
                        @endforeach
                        @if($role->permissions->count() > 5)
                            <div class='d-flex align-items-center py-2'>
                                <span class='bullet bg-primary me-3'></span>
                                <em>and {{ $role->permissions->count() - 5 }} more...</em>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer flex-wrap">
                    <a href="{{route('admin.permissions.showRole',$role->id)}}" class="btn btn-primary me-2">View Role</a>
                    <button type="button" class="btn btn-ghost-facebook me-2"  @click="$dispatch('editRole', { id: {{$role->id}} })">Edit Role</button>
                    <button type="button" class="btn  btn-danger" onclick="confimDetele({{$role->id}})">Deleted Role</button>
                </div>
            </div>
        </div>
    @endforeach
    <!--end::Col-->
    <!--begin::Add new card-->
    <div class="ol-md-4">
        <!--begin::Card-->
        <div class="card h-md-100">
            <!--begin::Card body-->
            <div class="card-body d-flex flex-center">
                <!--begin::Button-->
                <button type="button" class="btn btn-clear d-flex flex-column flex-center" onclick="showModal()">
                    <!--begin::Illustration-->
                    <img src="{{asset('dist/img/add-role.png')}}" alt="" class="mw-100 mh-150px mb-7" />
                    <!--end::Illustration-->
                    <!--begin::Label-->
                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                    <!--end::Label-->
                </button>
                <!--begin::Button-->
            </div>
            <!--begin::Card body-->
        </div>
        <!--begin::Card-->
    </div>
    <!--begin::Add new card-->
</div>
