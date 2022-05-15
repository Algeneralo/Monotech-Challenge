<?php

namespace App\Http\Controllers\Backoffice;

use App\Models\PromotionCode;
use App\Http\Controllers\ApiBaseController;
use App\Http\Resources\PromotionCodeResource;
use App\Http\Requests\Backoffice\StorePromotionRequest;

class PromotionCodesController extends ApiBaseController
{
    public function index()
    {
        $codes = PromotionCode::query()
            ->where('backoffice_id', auth()->id())
            ->with('users', 'users.wallet')
            ->get();

        $data = PromotionCodeResource::collection($codes)->resolve();

        return $this->response(data: $data);
    }

    public function show(PromotionCode $promotionCode)
    {
        $data = (new PromotionCodeResource($promotionCode->load('users', 'users.wallet')))->resolve();

        return $this->response(data: $data);
    }

    public function store(StorePromotionRequest $storePromotionRequest)
    {
        $code = PromotionCode::generateUniqueCode();

        $attributes = [
            'code'           => $code,
            'backoffice_id'  => auth()->id(),
            'original_quota' => $storePromotionRequest->get('quota')
        ];

        $attributes = $storePromotionRequest->validated() + $attributes;

        $promotionCode = PromotionCode::query()
            ->create($attributes);

        $data = (new PromotionCodeResource($promotionCode))->resolve();

        return $this->response(data: $data);
    }
}