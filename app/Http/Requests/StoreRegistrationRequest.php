<?php

namespace App\Http\Requests;

use App\Models\Plan;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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


        $min = 1;
        $max = 1;

        if(!empty($this->plan_id)) {
            $plan = Plan::find($this->plan_id);
            $min = $plan->class_per_week;
            $max = $min;
        }

        return [
            'student_id' => 'required',
            'plan_id' => 'required',
            'due_date' => 'required',
            'start' => 'required',


            'class' => 'array|min:'.$min.'|max:'.$min,
            'class.*.instructor_id' => 'required_with:class.*.time',
            'class.*.time' => 'required_with:class.*.instructor_id'
        ];
    }


    protected function prepareForValidation()
    {
        // $this->merge([
        //     'value' => BRL_USD($this->value)
        // ]);

        $values = [];
        foreach($this->class as $key => $item) {

            //verifica se ta vazio
            if(empty($item['instructor_id']) && empty($item['time'])) {
                continue;
            }

            $values[$key] = $item;
        }

        $this->merge([
            'class' => $values
        ]);
    }
}
