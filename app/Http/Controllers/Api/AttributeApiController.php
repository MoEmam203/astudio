<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Attributes\StoreAttributeApiRequest;
use App\Http\Requests\Api\Attributes\UpdateAttributeApiRequest;
use App\Services\Api\AttributeApiService;
use Illuminate\Http\JsonResponse;

class AttributeApiController extends Controller
{
    public function __construct(public readonly AttributeApiService $attributeApiService) {}

    public function index(): JsonResponse
    {
        return $this->attributeApiService->getAttributes(perPage: request('per_page'));
    }

    public function show($attributeId): JsonResponse
    {
        return $this->attributeApiService->getAttribute(attributeId: $attributeId);
    }

    public function store(StoreAttributeApiRequest $request): JsonResponse
    {
        return $this->attributeApiService->store(validatedData: $request->validated());
    }

    public function update(UpdateAttributeApiRequest $request, $attributeId): JsonResponse
    {
        return $this->attributeApiService->update(validatedData: $request->validated(), attributeId: $attributeId);
    }

    public function destroy($attributeId): JsonResponse
    {
        return $this->attributeApiService->destroy(attributeId: $attributeId);
    }
}
