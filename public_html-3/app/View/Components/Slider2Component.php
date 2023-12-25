<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Slider2Component extends Component
{
    public $headers;
    public $id;
    
    public function __construct($headers, $id)
    {
        $this->headers = $headers;
        $this->id = $id;
    }

    public function render()
    {
        $data['headers_id'] = $this->id;
        
        return view(theme('components.slider-2-component'), $data);
    }
}
