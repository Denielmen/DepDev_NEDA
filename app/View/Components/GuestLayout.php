<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('layouts.guest');
    }
}
