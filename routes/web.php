<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShippingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',
    [
        ShippingController::class,
        'MainPage'
    ]
)->name('home');


Route::post(
    'login',
    [
        ShippingController::class,
        'login'
    ]
)->name('login');

Route::post(
    'shipment_list',
    [
        ShippingController::class,
        'getShipmentList'
    ]
)->name('shipment_list');

Route::post(
    'shipment_create',
    [
        ShippingController::class,
        'createShipment'
    ]
)->name('shipment_create');

Route::post(
    'shipment_update',
    [
        ShippingController::class,
        'updateShipment'
    ]
)->name('shipment_update');
Route::post(
    'shipment_delete',
    [
        ShippingController::class,
        'deleteShipment'
    ]
)->name('shipment_delete');
Route::post(
    'item_create',
    [
        ShippingController::class,
        'createItem'
    ]
)->name('item_create');
Route::post(
    'item_update',
    [
        ShippingController::class,
        'updateItem'
    ]
)->name('item_update');
Route::post(
    'item_delete',
    [
        ShippingController::class,
        'deleteItem'
    ]
)->name('item_delete');
