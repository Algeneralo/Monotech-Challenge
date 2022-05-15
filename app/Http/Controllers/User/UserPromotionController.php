<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\PromotionCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\AssignPromotionRequest;

class UserPromotionController extends ApiBaseController
{
    public function store(AssignPromotionRequest $assignPromotionRequest)
    {
        /** @var PromotionCode $promotionCode */
        $promotionCode = $assignPromotionRequest->promotionCode;

        try {
            DB::beginTransaction();
            $user = auth()->user();

            $promotionCode->userPromotionCodes()->attach($user->id);

            $promotionCode->update([
                'quota' => $promotionCode->quota - 1,
            ]);

            $user->wallet()->increment('balance', $promotionCode->amount);

            DB::commit();

            return $this->response();

        } catch (Exception $exception) {
            DB::rollBack();

            Log::critical('Exception in store UserPromotionController', [
                'exception' => $exception,
                'user'      => auth()->user()
            ]);

            return $this->response(success: false, message: 'Something went wrong');
        }
    }
}