<?php

namespace App\Services\Api;

use App\Http\Resources\AttributeResource;
use App\Models\Attribute;
use Illuminate\Http\JsonResponse;

class AttributeApiService
{
    public function getAttributes(?int $perPage): JsonResponse
    {
        $attributes = Attribute::paginate($perPage ?? 10);

        return successResponse(
            data: [
                'attributes' => AttributeResource::collection($attributes),
                'pagination' => [
                    'total' => $attributes->total(),
                    'per_page' => $attributes->perPage(),
                    'current_page' => $attributes->currentPage(),
                    'last_page' => $attributes->lastPage(),
                    'from' => $attributes->firstItem(),
                    'to' => $attributes->lastItem(),
                ],
            ],
            message: 'Attributes fetched successfully'
        );
    }

    public function getAttribute(int $attributeId): JsonResponse
    {
        $attribute = Attribute::find($attributeId);
        if (! $attribute) {
            return failureResponse(
                message: 'Attribute not found',
                code: 404
            );
        }

        return successResponse(
            data: [
                'attribute' => new AttributeResource($attribute),
            ],
            message: 'Attribute fetched successfully'
        );
    }

    public function store(array $validatedData): JsonResponse
    {
        $attribute = Attribute::create($validatedData);

        return successResponse(
            data: [
                'attribute' => new AttributeResource($attribute),
            ],
            message: 'Attribute created successfully'
        );
    }

    public function update(array $validatedData, int $attributeId): JsonResponse
    {
        $attribute = Attribute::find($attributeId);
        if (! $attribute) {
            return failureResponse(
                message: 'Attribute not found',
                code: 404
            );
        }

        $attribute->update($validatedData);

        return successResponse(
            data: [
                'attribute' => new AttributeResource($attribute),
            ],
            message: 'Attribute updated successfully'
        );
    }

    public function destroy(int $attributeId): JsonResponse
    {
        $attribute = Attribute::find($attributeId);
        if (! $attribute) {
            return failureResponse(
                message: 'Attribute not found',
                code: 404
            );
        }

        $attribute->delete();

        return successResponse(
            message: 'Attribute deleted successfully'
        );
    }
}
