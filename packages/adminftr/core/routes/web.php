<?php

use Adminftr\Core\Http\Controllers\AuthController;
use Adminftr\Core\Http\Controllers\DashboardController;
use Adminftr\Core\Http\Controllers\StorageController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

if (!function_exists('getResourceFilesFuture')) {
    function getResourceFilesFuture($directory)
    {
        $files = File::allFiles($directory);
        return collect($files)->filter(function ($file) {
            return Str::endsWith($file->getFilename(), 'Resource.php');
        });
    }
}

if (!function_exists('registerResourceRoutesFuture')) {
    function registerResourceRoutesFuture($file)
    {
        $classBasename = str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathName());
        $name = str_replace('Resource', '', $classBasename);
        $name = Str::lower($name) . 's';
        $className = 'App\\Future\\' . $classBasename;
        $resource = new $className();
        $routeName = $resource->getRouteName() ?? $name;
        $only = [];
        if ($resource->form) {
            $only[] = 'create';
            $only[] = 'edit';
        }
        if ($resource->table) {
            $only[] = 'index';
        }
        Route::resource($routeName, $className)->only($only)->names($name);
        registerAdditionalRoutesFuture($className, $routeName);
    }
}

if (!function_exists('registerAdditionalRoutesFuture')) {
    function registerAdditionalRoutesFuture($className, $routeName)
    {
        $methods = get_class_methods($className);
        $remove = ['__construct', 'getRouteName', 'index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'callAction', 'middleware', 'validate', 'validateWith', 'authorize', 'getMiddleware', '__call', 'authorizeForUser', 'authorizeResource', 'validateWithBag'];
        $methods = array_diff($methods, $remove);
        foreach ($methods as $method) {
            if ((new ReflectionMethod($className, $method))->isPublic() && !Str::startsWith($method, '__')) {
                $name = $routeName . '.' . $method;
                $route = $routeName . '/' . $method;
                if ((new ReflectionMethod($className, $method))->getNumberOfParameters() > 0) {
                    $route .= '/{id}';
                }
                Route::get($route, $className . '@' . $method)->name($name);
            }
        }
    }
}

Route::group(['middleware' => ['web']], function () {
    Route::get('admin/login', [AuthController::class, 'login'])->name('login');
    Route::get('admin/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('admin/forgot', [AuthController::class, 'forgotPassword'])->name('forgot-password');
});

Route::get('/storage/avatars/{filename}', [StorageController::class, 'getFile']);

Route::group(config('future.future.route'), function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('notifications', [AuthController::class, 'notifications'])->name('notifications');
    Route::get('menu', [\Adminftr\Core\Http\Controllers\MenuController::class, 'index'])->name('menu');
    Route::get('file-manager', [\Adminftr\Core\Http\Controllers\FileManagerController::class, 'index'])->name('file-manager');

    $resourceFiles = getResourceFilesFuture(app_path('Future'));

    foreach ($resourceFiles as $file) {
        registerResourceRoutesFuture($file);
    }
});
