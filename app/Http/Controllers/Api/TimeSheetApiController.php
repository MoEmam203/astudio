<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TimeSheets\StoreTimeSheetRequest;
use App\Http\Requests\Api\TimeSheets\UpdateTimeSheetRequest;
use App\Services\Api\TimeSheetApiService;
use Illuminate\Http\JsonResponse;

class TimeSheetApiController extends Controller
{
    public function __construct(public readonly TimeSheetApiService $timeSheetApiService) {}

    public function index(): JsonResponse
    {
        return $this->timeSheetApiService->getTimeSheets(user: auth()->user(), perPage: request('per_page'));
    }

    public function show($timeSheetId): JsonResponse
    {
        return $this->timeSheetApiService->getTimeSheet(user: auth()->user(), timeSheetId: $timeSheetId);
    }

    public function store(StoreTimeSheetRequest $request): JsonResponse
    {
        return $this->timeSheetApiService->store(user: auth()->user(), validatedData: $request->validated());
    }

    public function update(UpdateTimeSheetRequest $request, $timeSheetId): JsonResponse
    {
        return $this->timeSheetApiService->update(user: auth()->user(), validatedData: $request->validated(), timeSheetId: $timeSheetId);
    }

    public function destroy($timeSheetId): JsonResponse
    {
        return $this->timeSheetApiService->destroy(user: auth()->user(), timeSheetId: $timeSheetId);
    }
}
