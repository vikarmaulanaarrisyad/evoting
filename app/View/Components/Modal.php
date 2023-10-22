<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     */

    public $size;
    public $method;
    public $enctype;

    public function __construct($size = 'modal-md', $method = 'post', $enctype = 'multipart/form-data')
    {
        $this->size = $size;
        $this->method = $method;
        $this->enctype = $enctype;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
