<?php

namespace App\Http\Requests\Backoffice;

use App\Models\Backoffice;
use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->check() && auth()->user() instanceof Backoffice;
    }

    public function rules(): array
    {
        return [
            'start_date' => [
                'required',
                'date',
                'before:end_date'
            ]
            , 'end_date' => [
                'required',
                'date',
                'after:start_date'
            ],
            'amount'     => [
                'required',
                'numeric',
                'gt:0'
            ],
            'quota'      => [
                'required',
                'numeric',
                'gt:0'
            ],

        ];
    }

}