<?php

namespace App\View\Components\chat;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class chatInfoDocument extends Component
{
    /**
     * Create a new component instance.
     */
    public $selected_application;

    public function __construct(array $selectedApplication)
    {
        $this->selected_application = $selectedApplication;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chat.chat-info-document');
    }
}
