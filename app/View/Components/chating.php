<?php

namespace App\View\Components;

use App\Models\Application;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class chating extends Component
{
    /**
     * Create a new component instance.
     */

    public $selected_application;

    public function __construct(Application $selectedApplication)
    {
        //
        $this->selected_application = $selectedApplication;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chating');
    }
}
