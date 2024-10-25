@extends('future::layouts.app')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{ __('File manager') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card card-filemanager position-relative"  style="overflow: hidden;  overflow-y: auto;">
                <livewire:future::admin.file-manager />
            </div>
        </div>
    </div>

@endsection
