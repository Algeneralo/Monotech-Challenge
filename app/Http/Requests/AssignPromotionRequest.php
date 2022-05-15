<?php

namespace App\Http\Requests;

use App\Models\PromotionCode;
use App\Models\UserPromotion;
use Illuminate\Foundation\Http\FormRequest;

class AssignPromotionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'exists:promotion_codes,code'
            ]
        ];
    }

    public function authorize(): bool
    {
        $promotionCode = PromotionCode::query()
            ->where('code', $this->code)
            ->firstOrFail();

        abort_if($promotionCode->quota == 0, 422, 'code_usage_exceeded');
        abort_if($promotionCode->start_date->greaterThan(now()), 422, 'code_not_started');
        abort_if($promotionCode->end_date->lessThan(now()), 422, 'code_expired');

        $usedBefore = UserPromotion::query()
            ->whereBelongsTo($promotionCode)
            ->whereBelongsTo(auth()->user())
            ->exists();

        abort_if($usedBefore, 422, 'code_already_used');

        $this->merge([
            'promotionCode' => $promotionCode,
        ]);

        return true;
    }
}