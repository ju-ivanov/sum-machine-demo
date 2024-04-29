<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNumberRequest extends FormRequest
{
    public const FIELD_NUMBER = 'number';

    public function rules(): array
    {
        return [
            self::FIELD_NUMBER => ['required', 'integer', 'min:-1000000', 'max:1000000'],
        ];
    }
}
