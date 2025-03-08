<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AttributeValues\StoreAttributeValueApiRequest;
use App\Http\Requests\Api\AttributeValues\UpdateAttributeValueApiRequest;
use App\Services\Api\AttributeValueApiService;
use Illuminate\Http\JsonResponse;

class AttributeValueApiController extends Controller
{
    public function __construct(public readonly AttributeValueApiService $attributeValueApiService) {}

    public function index(): JsonResponse
    {
        return $this->attributeValueApiService->getAttributeValues(user: auth()->user(), perPage: request('per_page'));
    }

    public function show($attributeValueId): JsonResponse
    {
        return $this->attributeValueApiService->getAttributeValue(user: auth()->user(), attributeValueId: $attributeValueId);
    }

    public function store(StoreAttributeValueApiRequest $request): JsonResponse
    {
        return $this->attributeValueApiService->store(user: auth()->user(), validatedData: $request->validated());
    }

    public function update(UpdateAttributeValueApiRequest $request, $attributeValueId): JsonResponse
    {
        return $this->attributeValueApiService->update(user: auth()->user(), attributeValueId: $attributeValueId, validatedData: $request->validated());
    }

    public function destroy($attributeValueId): JsonResponse
    {
        return $this->attributeValueApiService->destroy(user: auth()->user(), attributeValueId: $attributeValueId);
    }
}
