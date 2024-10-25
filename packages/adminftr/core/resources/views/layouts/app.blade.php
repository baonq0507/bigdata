<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" value="{{ csrf_token() }}" content="{{ csrf_token() }}">
    <title>FUTURE</title>
    <!-- CSS files -->
    @futureStyles
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
          rel="stylesheet">
    <link
        href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css"
        rel="stylesheet"
    />
    @yield('style')
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
    @livewireStyles
    @vite([
        'packages/adminftr/core/resources/assets/sass/app.scss'
    ])


    <script >
        !function(){try{var d=document.documentElement,n='data-theme',s='setAttribute';var e=localStorage.getItem('theme');if('system'===e||(!e&&true)){var t='(prefers-color-scheme: dark)',m=window.matchMedia(t);if(m.media!==t||m.matches){d.style.colorScheme = 'dark';d[s](n,'dark')}else{d.style.colorScheme = 'light';d[s](n,'light')}}else if(e){d[s](n,e|| '')}if(e==='light'||e==='dark')d.style.colorScheme=e}catch(e){}}()
    </script>
    <script src="{{ asset('vendor/future/dist/js/demo-theme.js') }}"></script>
</head>
<body class="position-relative">
<div class="page" id="page">
    @include('future::app.header')
    @include('future::app.sidebar')
    <div
        class="page-wrapper {{ request()->cookie('sidebarState') === 'collapsed' ? 'state-collapsed' : '' }}"
        id="page-wrapper">
        <div class="page-body">
            <div class="container-fluid" id="content">
                @yield('content')
            </div>
            @include('future::loading')
        </div>
        @include('future::app.footer')

    </div>

</div>
<livewire:future::notifications/>
@include('notifications::swal')
@include('notifications::toast')
@include('notifications::alerts')
@include('notifications::modal')
@include('future::modal.file-manager')
@vite(['resources/js/app.js'])
@vite(['packages/adminftr/core/resources/assets/js/app.js'])
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery/lightgallery.min.js"></script>
<script src="{{ asset('vendor/future/dist/js/tabler.min.js') }}"></script>
<script src="{{ asset('vendor/future/dist/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('vendor/future/dist/libs/nouislider/dist/nouislider.min.js') }}"></script>
<script src="{{ asset('vendor/future/dist/libs/litepicker/dist/litepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.3.0/tinymce.min.js" integrity="sha512-RUZ2d69UiTI+LdjfDCxqJh5HfjmOcouct56utQNVRjr90Ea8uHQa+gCxvxDTC9fFvIGP+t4TDDJWNTRV48tBpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('vendor/future/dist/libs/star-rating.js/dist/star-rating.min.js') }}"></script>
<script src="{{ asset('vendor/future/dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginImageCrop,
        FilePondPluginImageEdit
    );
</script>

@yield('script')
@livewireScriptConfig
</body>
</html>
