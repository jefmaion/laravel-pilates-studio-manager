<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalDelete extends Component
{

    public $route;
    public $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route, $message=null)
    {
        $this->route = $route;
        $this->message = (empty($message)) ? 'Deseja excluir esse registro?' : $message;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-delete');
    }
}
