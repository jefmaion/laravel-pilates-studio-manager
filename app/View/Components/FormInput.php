<?php

namespace App\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class FormInput extends Component
{

    public $name;
    public $nameDot;

    public $type;
    public $value;
    public $class;

    public $label;


    //textarea
    public $rows;

    public $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type='text', $name=null, $value=null, $rows=5, $class=null, $label=null, $options=null)
    {


        

        $this->name  = $name;
        $this->type  = $type;
        $this->value = old($this->convertArrayDot($name), $value);
        $this->class = $class;
        $this->rows  = $rows;

        $this->nameDot = $this->convertArrayDot($name);

        $this->label = $label;

        $this->options = $options;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-input');
    }


    protected function convertArrayDot($name) {
        return str_replace(']', '', str_replace('[', '.', $name));
    }
}
