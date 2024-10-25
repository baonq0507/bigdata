<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
route::get('/', function () {

//    $deviceToken = 'cL_hFXdLRo2zrLnmQWTD2T:APA91bEH4rcCC-AmWqJS2hqtfA-ClfedzAKmmQ7jdeJOhGxP_HNNvf_ISCQAIJORYWrPBvEa67342qHLJ5LnxvkSRC9lyg5bszP-2PNYyCtGJs8c-Wrcr7gyKq-0OnRFluweqn0z7WAh';
//    $title = 'Hello World';
//    $body = 'This is a test notification';
//    $data = ['key1' => 'value1', 'key2' => 'value2'];
//
//    $result = sendFirebaseNotification($deviceToken, $title, $body, $data);
//    dd($result);
    return view('welcome');
});
