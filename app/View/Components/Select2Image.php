<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select2Image extends Component
{
    public $name;
    public $nameDot;
    public $value;
    public $class;
    public $label;
    public $options = '';
    public $multiple;

    public $selected = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name=null, $value=null,  $class=null, $label=null, $options=null, $multiple=null)
    {
        $this->name  = $name;
        $this->value = old($this->convertArrayDot($name), $value);
        $this->class = $class;
        $this->multiple = ($multiple == "multiple") ? 'multiple="multiple"' : null;
        $this->nameDot = $this->convertArrayDot($name);
        $this->label = $label;
        $this->options = $options;



        if($this->options) {
        foreach($this->options as $key => $item) {
                $item['selected'] = null;
                if((string) $this->value == (string) $key) {
                    $item['selected'] = 'selected';
                }
                $this->options[$key] = $item;
            }
        }

    }

    protected function convertArrayDot($name) {
        return str_replace(']', '', str_replace('[', '.', $name));
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select2-image');
    }
}
