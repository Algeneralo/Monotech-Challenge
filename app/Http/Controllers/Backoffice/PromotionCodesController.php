<?php

namespace App\Http\Controllers\Backoffice;

use App\Models\PromotionCode;
use App\Http\Controllers\ApiBaseController;
use App\Http\Resources\PromotionCodeResource;

class PromotionCodesController extends ApiBaseController
{
    public function index()
    {
        $codes = PromotionCode::query()
            ->where('backoffice_id', auth()->id())
            ->get();

        $data = PromotionCodeResource::collection($codes)->resolve();

        return $this->response(data: $data);
    }

    public function show(PromotionCode $promotionCode)
    {
        $data = (new PromotionCodeResource($promotionCode))->resolve();

        return $this->response(data: $data);
    }
}