<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\EquipmentTypeJson;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EquipmentTypeController extends ApiController
{

    /**
     * Display all equipment types.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return EquipmentTypeJson::collection(EquipmentType::all())->toResponse($request);
    }


}
