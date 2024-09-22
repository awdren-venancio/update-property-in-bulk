<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use App\Services\PropertyService;

class AutomationController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    public function startAutomation()
    {
        $resultado = $this->propertyService->startAutomation();

        return response()->json(['message' => $resultado]);
    }
}
