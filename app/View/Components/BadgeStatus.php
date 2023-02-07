<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BadgeStatus extends Component
{

    public $value;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value=1)
    {
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.badge-status');
    }
}
