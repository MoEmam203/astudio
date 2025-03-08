<?php

namespace App\Services\Api;

use App\Http\Resources\AttributeValueResource;
use App\Models\AttributeValue;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AttributeValueApiService
{
    public function getAttributeValues(User $user, ?int $perPage): JsonResponse
    {
        $projectsIds = $user->projects()->pluck('id')->toArray();
        $attributeValues = AttributeValue::with(['attribute', 'project'])
            ->whereIn('entity_id', $projectsIds)
            ->paginate($perPage ?? 10);

        return successResponse(
            data: [
                'attribute_values' => AttributeValueResource::collection($attributeValues),
                'pagination' => [
                    'total' => $attributeValues->total(),
                    'per_page' => $attributeValues->perPage(),
                    'current_page' => $attributeValues->currentPage(),
                    'last_page' => $attributeValues->lastPage(),
                    'from' => $attributeValues->firstItem(),
                    'to' => $attributeValues->lastItem(),
                ],
            ],
            message: 'Attribute values fetched successfully',
        );
    }

    public function getAttributeValue(User $user, int $attributeValueId): JsonResponse
    {
        $projectsIds = $user->projects()->pluck('id')->toArray();
        $attributeValue = AttributeValue::with(['attribute', 'project'])
            ->whereIn('entity_id', $projectsIds)
            ->find($attributeValueId);

        if (! $attributeValue) {
            return failureResponse(
                message: 'Attribute value not found',
                code: 404
            );
        }

        return successResponse(
            data: [
                'attribute_value' => new AttributeValueResource($attributeValue),
            ],
            message: 'Attribute value fetched successfully',
        );
    }

    public function store(User $user, array $validatedData): JsonResponse
    {
        if ($user->projects()->where('id', $validatedData['entity_id'])->doesntExist()) {
            return failureResponse(
                message: 'project not found',
                code: 404
            );
        }

        $isAttributeValueExists = AttributeValue::where('entity_id', $validatedData['entity_id'])
            ->where('attribute_id', $validatedData['attribute_id'])
            ->exists();

        if ($isAttributeValueExists) {
            return failureResponse(
                message: 'Attribute value already exists',
                code: 422
            );
        }
        $attributeValue = AttributeValue::create($validatedData);
        $attributeValue->load(['attribute', 'project']);

        return successResponse(
            data: [
                'attribute_value' => new AttributeValueResource($attributeValue),
            ],
            message: 'Attribute value created successfully',
        );
    }

    public function update(User $user, int $attributeValueId, array $validatedData): JsonResponse
    {
        if ($user->projects()->where('id', $validatedData['entity_id'])->doesntExist()) {
            return failureResponse(
                message: 'project not found',
                code: 404
            );
        }

        $attributeValue = AttributeValue::find($attributeValueId);

        if (! $attributeValue) {
            return failureResponse(
                message: 'Attribute value not found',
                code: 404
            );
        }

        $attributeValue->update($validatedData);

        return successResponse(
            data: [
                'attribute_value' => new AttributeValueResource($attributeValue),
            ],
            message: 'Attribute value updated successfully',
        );
    }

    public function destroy(User $user, int $attributeValueId): JsonResponse
    {
        $attributeValue = AttributeValue::find($attributeValueId);

        if (! $attributeValue) {
            return failureResponse(
                message: 'Attribute value not found',
                code: 404
            );
        }

        if ($user->projects()->where('id', $attributeValue->entity_id)->doesntExist()) {
            return failureResponse(
                message: 'project not found',
                code: 404
            );
        }

        $attributeValue->delete();

        return successResponse(
            message: 'Attribute value deleted successfully',
        );
    }
}
