<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Tariff;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreRequest
 *
 * @package App\Http\Requests\Admin\Tariff
 */
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

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'hint' => 'max:255',
            'price' => 'required|integer|min:0',

            'services' => 'required|array',
            'services.*.service_id' => [
                'required',
                'string',
            ],
            'services.*.duration_type' => 'integer|min:0|max:1',
            'services.*.duration_value' => 'required|string',
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'services' => 'Услуги тарифа',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'services.required' => 'Добавьте хотя бы одну услугу в тариф',
            'services.*.service_id.unique' => 'Вы продублировали услугу в рамках одного тарифа',
            'services.*.duration_type' => 'Вы указали несуществующий тип',
            'services.*.duration_value' => 'Неверный формат значения'
        ];
    }
}
