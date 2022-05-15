<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\PromotionCode;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PromotionCode */
class PromotionCodeResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'code'       => $this->code,
            'start_date' => $this->start_date->toDateTimeString(),
            'end_date'   => $this->end_date->toDateTimeString(),
            'amount'     => $this->amount,
            'quota'      => $this->quota,
            'users'      => $this->whenLoaded('users', function () {
                return UserResource::collection($this->users);
            })
        ];
    }
}
