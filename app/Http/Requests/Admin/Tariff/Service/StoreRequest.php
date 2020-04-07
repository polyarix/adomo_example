<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Tariff\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'icon' => 'required|string'
        ];
    }

    public function attributes(): array
    {
        return ['name' => 'Название', 'icon' => 'Иконка'];
    }
}
