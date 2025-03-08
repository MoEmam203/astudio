<?php

namespace App\Services\Api;

use App\Http\Resources\TimeSheetResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TimeSheetApiService
{
    public function getTimeSheets(User $user, ?int $perPage): JsonResponse
    {
        $timeSheets = $user->timeSheets()->with('project')->paginate($perPage ?? 10);

        return successResponse(
            data: [
                'timeSheets' => TimeSheetResource::collection($timeSheets),
                'pagination' => [
                    'total' => $timeSheets->total(),
                    'per_page' => $timeSheets->perPage(),
                    'current_page' => $timeSheets->currentPage(),
                    'last_page' => $timeSheets->lastPage(),
                    'from' => $timeSheets->firstItem(),
                    'to' => $timeSheets->lastItem(),
                ],
            ],
            message: 'timeSheets fetched successfully'
        );
    }

    public function getTimeSheet(User $user, int $timeSheetId): JsonResponse
    {
        $timeSheet = $user->timeSheets()->with('project')->find($timeSheetId);

        if (! $timeSheet) {
            return failureResponse(
                message: 'timeSheet not found',
                code: 404
            );
        }

        return successResponse(
            data: [
                'timeSheet' => new TimeSheetResource($timeSheet),
            ],
            message: 'timeSheet fetched successfully'
        );
    }

    public function store(User $user, array $validatedData): JsonResponse
    {
        if ($user->projects()->where('id', $validatedData['project_id'])->doesntExist()) {
            return failureResponse(
                message: 'project not found',
                code: 404
            );
        }

        $timeSheet = $user->timeSheets()->create($validatedData);

        return successResponse(
            data: [
                'timeSheet' => new TimeSheetResource($timeSheet),
            ],
            message: 'timeSheet created successfully'
        );
    }

    public function update(User $user, array $validatedData, int $timeSheetId): JsonResponse
    {
        $timeSheet = $user->timeSheets()->find($timeSheetId);

        if (! $timeSheet) {
            return failureResponse(
                message: 'timeSheet not found',
                code: 404
            );
        }

        if ($user->projects()->where('id', $validatedData['project_id'])->doesntExist()) {
            return failureResponse(
                message: 'project not found',
                code: 404
            );
        }

        $timeSheet->update($validatedData);

        return successResponse(
            data: [
                'timeSheet' => new TimeSheetResource($timeSheet),
            ],
            message: 'timeSheet updated successfully'
        );
    }

    public function destroy(User $user, int $timeSheetId): JsonResponse
    {
        $timeSheet = $user->timeSheets()->find($timeSheetId);

        if (! $timeSheet) {
            return failureResponse(
                message: 'timeSheet not found',
                code: 404
            );
        }

        $timeSheet->delete();

        return successResponse(
            message: 'timeSheet deleted successfully'
        );
    }
}
