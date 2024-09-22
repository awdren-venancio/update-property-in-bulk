<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Automation\PropertyController;
use App\Http\Controllers\Automation\AutomationController;

Route::get('start-automation', [AutomationController::class, 'startAutomation']);
Route::get('property/list', [PropertyController::class, 'listProperty']);
Route::put('property/update/{id}', [PropertyController::class, 'updateProperty']);