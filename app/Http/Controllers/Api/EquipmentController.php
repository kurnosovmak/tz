<?php

namespace App\Http\Controllers\Api;

use App\Http\Filters\EquipmentFilter;
use App\Http\Requests\EquipmentController\StoreEquipment;
use App\Http\Requests\EquipmentController\UpdateEquipment;
use App\Http\Resources\EquipmentJson;
use App\Models\Equipment;
use App\Http\Controllers\ApiController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EquipmentController extends ApiController
{
    /**
     * Get all equipments.
     *
     * @param EquipmentFilter $filter
     * @return JsonResponse
     */
    public function index(EquipmentFilter $filter): JsonResponse
    {
        $equipments = Equipment::filter($filter)->with('equipmentType')->simplePaginate();

        return EquipmentJson::collection($equipments)->toResponse(null);
    }


    /**
     * Add new equipment.
     *
     * @param StoreEquipment $request
     * @return JsonResponse
     */
    public function store(StoreEquipment $request): JsonResponse
    {
        $equipments = Equipment::createMany(collect($request->all()));

        return EquipmentJson::collection($equipments)->toResponse($request);
    }

    /**
     * Display equipment.
     *
     * @param Equipment $equipment
     * @return JsonResponse
     */
    public function show(Equipment $equipment): JsonResponse
    {
        return (new EquipmentJson($equipment))->toResponse(null);
    }


    /**
     * Update equipment.
     *
     * @param UpdateEquipment $request
     * @param Equipment $equipment
     * @return JsonResponse
     */
    public function update(UpdateEquipment $request, Equipment $equipment): JsonResponse
    {
        $equipment->fill($request->all())->save();

        return (new EquipmentJson($equipment))->toResponse($request);
    }

    /**
     * Delete equipment.
     *
     * @param Equipment $equipment
     * @return JsonResponse
     */
    public function destroy(Equipment $equipment): JsonResponse
    {
        $equipment->delete();
        return response()->json(null, 204);
    }
}
