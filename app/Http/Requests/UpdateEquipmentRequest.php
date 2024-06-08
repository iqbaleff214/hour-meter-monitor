<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isParent() || auth()->user()->id == $this->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'serial_number' => ['required', Rule::unique('equipment', 'serial_number')->ignore($this->id)],
            'code' => ['required'],
            'brand' => ['required'],
            'model' => ['required'],
            'category_id' => ['required'],
            'user_id' => ['nullable'],
            'condition' => ['required'],
        ];
    }
}
