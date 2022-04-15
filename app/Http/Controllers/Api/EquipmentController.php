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

class EquipmentController extends ApiController
{
    /**
     * Get all equipments.
     *
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
    public function store(StoreEquipment $request)
    {
        $equipments = new Collection();
        DB::transaction(function () use ($equipments, $request) {
            foreach ($request->all() as $e) {
                $equipment = Equipment::create($e);
                $equipments->push($equipment);
            }
        });

        return EquipmentJson::collection($equipments)->toResponse($request);
    }

    /**
     * Display equipment.
     *
     * @param Equipment $equipment
     * @return JsonResponse
     */
    public function show(Equipment $equipment)
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
    public function update(UpdateEquipment $request, Equipment $equipment)
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
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return response()->json(null, 204);
    }
}
