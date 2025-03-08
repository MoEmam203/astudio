<?php

namespace App\Services\Api;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProjectService
{
    public function getProjects(?int $perPage, ?array $filters = []): JsonResponse
    {
        $projects = Project::with('attributeValues.attribute')
            ->filter($filters)->paginate($perPage ?? 10);

        return successResponse(
            data: [
                'projects' => ProjectResource::collection($projects),
                'pagination' => [
                    'total' => $projects->total(),
                    'per_page' => $projects->perPage(),
                    'current_page' => $projects->currentPage(),
                    'last_page' => $projects->lastPage(),
                    'from' => $projects->firstItem(),
                    'to' => $projects->lastItem(),
                ],
            ],
            message: 'Projects fetched successfully'
        );
    }

    public function getProject(int $projectId): JsonResponse
    {
        $project = Project::with('attributeValues.attribute')->find($projectId);
        if (! $project) {
            return failureResponse(
                message: 'Project not found',
                code: 404
            );
        }

        return successResponse(
            data: [
                'project' => new ProjectResource($project),
            ],
            message: 'Project fetched successfully'
        );
    }

    public function store(array $validatedData): JsonResponse
    {
        $project = Project::create($validatedData);

        if (isset($validatedData['attributes']) && count($validatedData['attributes']) > 0) {
            foreach ($validatedData['attributes'] as $attribute) {
                $project->attributeValues()->create([
                    'attribute_id' => $attribute['attribute_id'],
                    'value' => $attribute['value'],
                ]);
            }

            $project->load('attributeValues.attribute');
        }

        return successResponse(
            data: [
                'project' => new ProjectResource($project),
            ],
            message: 'Project created successfully'
        );
    }

    public function update(array $validatedData, int $projectId): JsonResponse
    {
        $project = Project::find($projectId);
        if (! $project) {
            return failureResponse(
                message: 'Project not found',
                code: 404
            );
        }

        $project->update($validatedData);

        if (isset($validatedData['attributes']) && count($validatedData['attributes']) > 0) {
            $project->attributeValues()->delete();
            foreach ($validatedData['attributes'] as $attribute) {
                $project->attributeValues()->create([
                    'attribute_id' => $attribute['attribute_id'],
                    'value' => $attribute['value'],
                ]);
            }

            $project->load('attributeValues.attribute');
        }

        return successResponse(
            data: [
                'project' => new ProjectResource($project),
            ],
            message: 'Project updated successfully'
        );
    }

    public function destroy(int $projectId): JsonResponse
    {
        $project = Project::find($projectId);
        if (! $project) {
            return failureResponse(
                message: 'Project not found',
                code: 404
            );
        }

        $project->delete();

        return successResponse(
            message: 'Project deleted successfully'
        );
    }

    public function getUserProjects(User $user, ?int $perPage)
    {
        $projects = $user->projects()->with('attributeValues.attribute')->paginate($perPage ?? 10);

        return successResponse(
            data: [
                'projects' => ProjectResource::collection($projects),
                'pagination' => [
                    'total' => $projects->total(),
                    'per_page' => $projects->perPage(),
                    'current_page' => $projects->currentPage(),
                    'last_page' => $projects->lastPage(),
                    'from' => $projects->firstItem(),
                    'to' => $projects->lastItem(),
                ],
            ],
            message: 'Projects fetched successfully'
        );

    }

    public function attachProjects(User $user, array $validatedData): JsonResponse
    {
        $user->projects()->syncWithoutDetaching($validatedData['projects']);

        return successResponse(
            message: 'Projects attached successfully',
        );
    }

    public function detachProjects(User $user, array $validatedData): JsonResponse
    {
        $user->projects()->detach($validatedData['projects']);

        return successResponse(
            message: 'Projects detached successfully',
        );
    }
}
