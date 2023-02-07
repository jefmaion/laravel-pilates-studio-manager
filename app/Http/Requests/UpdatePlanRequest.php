<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'duration' =>'numeric|required',
            'class_per_week' => 'numeric|required',
            'value' => 'numeric|required'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'value' => BRL_USD($this->value)
        ]);
    }
}
