<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationClassRequest extends FormRequest
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
            'instructor_id' => ['required'],
            'weekday' => ['required', Rule::unique('registration_classes')->where(function ($query)  {
                return $query->where('weekday', $this->weekday)->where('registration_id', $this->id);
             })],
            'time' => 'required',
        ];
    }
}
