<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $text;
    public $color;
    public $type;
    public $additionalClasses;

    public function __construct($text = 'Button', $color = 'black', $type = 'button', $additionalClasses = '')
    {
        $this->text = $text;
        $this->color = $color;
        $this->type = $type;
        $this->additionalClasses = $additionalClasses;
    }

    public function render()
    {
        return view('components.button');
    }
}
