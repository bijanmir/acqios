<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ContactModal extends Component
{
    public $listing;

    public function __construct($listing)
    {
        $this->listing = $listing;
    }

    public function render()
    {
        return view('components.contact-modal');
    }
}
