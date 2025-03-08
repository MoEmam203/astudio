<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Projects\AttachProjectsRequest;
use App\Http\Requests\Api\Projects\DetachProjectsRequest;
use App\Http\Requests\Api\Projects\StoreProjectRequest;
use App\Http\Requests\Api\Projects\UpdateProjectRequest;
use App\Services\Api\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectApiController extends Controller
{
    public function __construct(public readonly ProjectService $projectService) {}

    public function index(): JsonResponse
    {
        return $this->projectService->getProjects(perPage: request('per_page'));
    }

    public function show(int $projectId): JsonResponse
    {
        return $this->projectService->getProject(projectId: $projectId);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        return $this->projectService->store(validatedData: $request->validated());
    }

    public function update(UpdateProjectRequest $request, int $projectId): JsonResponse
    {
        return $this->projectService->update(validatedData: $request->validated(), projectId: $projectId);
    }

    public function destroy(int $projectId): JsonResponse
    {
        return $this->projectService->destroy(projectId: $projectId);
    }

    public function getUserProjects()
    {
        $user = auth()->user();

        return $this->projectService->getUserProjects(user: $user, perPage: request('per_page'));
    }

    public function attachProjects(AttachProjectsRequest $request): JsonResponse
    {
        $user = auth()->user();

        return $this->projectService->attachProjects(user: $user, validatedData: $request->validated());
    }

    public function detachProjects(DetachProjectsRequest $request): JsonResponse
    {
        $user = auth()->user();

        return $this->projectService->detachProjects(user: $user, validatedData: $request->validated());
    }
}
