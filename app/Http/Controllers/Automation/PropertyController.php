<?php

namespace App\Http\Controllers\Automation;

use App\Http\Controllers\Controller;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    public function listProperty(Request $request)
    {
        $imoveis = $this->propertyService->listProperty($request->all());

        return response()->json($imoveis);
    }

    public function updateProperty(Request $request, $id)
    {
        $data = $request->all();
        $response = $this->propertyService->updateProperty($id, $data);

        return response()->json($response);
    }
}
