<?php

namespace Adminftr\Core;

use Adminftr\Form\FormServiceProvider;
use Adminftr\Form\Future\BaseForm;
use Adminftr\Messages\MessagesServiceProvider;
use Adminftr\Notifications\NotificationsServiceProvider;
use Adminftr\Table\Future\BaseTable;
use Adminftr\Table\TableServiceProvider;
use Adminftr\Widgets\WidgetsServiceProvider;
use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;
use Livewire\Livewire;

class FutureServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->autoRegisterLivewireComponents(app_path('Future'));
        Blade::directive('futureStyles', function () {
            return <<<'HTML'
        <link href="{{ asset('vendor/future/dist/css/tabler.css') }}?v={{ time() }}" rel="stylesheet"/>
        <link href="{{ asset('vendor/future/dist/css/tabler-flags.min.css') }}?v={{ time() }}" rel="stylesheet"/>
        <link href="{{ asset('vendor/future/dist/css/tabler-payments.min.css') }}?v={{ time() }}" rel="stylesheet"/>
        <link href="{{ asset('vendor/future/dist/css/tabler-vendors.min.css') }}?v={{ time() }}" rel="stylesheet"/>
        <link href="{{ asset('vendor/future/dist/css/tabler-vendors.rtl.min.css') }}?v={{ time() }}" rel="stylesheet"/>
        <link href="{{ asset('vendor/future/css/app.css') }}?v={{ time() }}" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
        <link href="{{ asset('vendor/future/dist/libs/star-rating.js/dist/star-rating.min.css') }}?v={{ time() }}" rel="stylesheet"/>
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css?v={{ time() }}"
              integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
              crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link href="{{ asset('vendor/future/dist/css/demo.min.css') }}?v={{ time() }}" rel="stylesheet"/>
        <link href="{{ asset('vendor/future/dist/css/app.css') }}?v={{ time() }}" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/lightgallery/css/lightgallery.min.css" rel="stylesheet">
        HTML;
        });
    }

    protected function autoRegisterLivewireComponents($directory)
    {
        $namespace = 'App\Future';
        try {
            $files = File::allFiles($directory);
            foreach ($files as $file) {
                $componentPath = $file->getRelativePathName();
                $classBasename = str_replace(['/', '.php'], ['\\', ''], $componentPath);
                $className = $namespace . '\\' . $classBasename;
                if (is_subclass_of($className, BaseForm::class) || is_subclass_of($className, BaseTable::class) || is_subclass_of($className, Component::class)) {
                    $alias = str_replace('\\', '.', $classBasename);
                    Livewire::component($alias, $className);
                }
            }
        } catch (Exception $e) {
            // do nothing
        }
    }

    public function register(): void
    {
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(NotificationsServiceProvider::class);
        $this->app->register(FormServiceProvider::class);
        $this->app->register(TableServiceProvider::class);
        $this->app->register(MessagesServiceProvider::class);
        $this->app->register(WidgetsServiceProvider::class);
    }
}
