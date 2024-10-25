<?php

Route::group(config('future.future.route'), function () {
    Route::get('messages', [\Adminftr\Messages\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
});
