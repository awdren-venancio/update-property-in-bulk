<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Automation\PropertyController;
use App\Http\Controllers\Automation\AutomationController;

Route::get('start-automation', [AutomationController::class, 'startAutomation']);
Route::get('property/list', [PropertyController::class, 'listProperty']);
Route::put('property/update/{id}', [PropertyController::class, 'updateProperty']);


// Codigo provisório até ser criado um relatório de logs *********************************
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
Route::get('/logs/35a10dfa8d4ce345c8dad22fb2568b7e', function () {
    $path = storage_path('logs/laravel.log');

    if (File::exists($path)) {
        $log = File::get($path);

        if (strlen($log) > 500000) {
            $log = substr($log, -500000);
        }

        return Response::make(nl2br($log), 200, [
            'Content-Type' => 'text/html',
        ]);
    }

    return response()->json(['message' => 'Log file not found.'], 404);
});
// ******************************************************************************************