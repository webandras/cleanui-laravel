<?php

namespace App\View\Components\Admin\Clean\Layout;

use Illuminate\View\Component;

class AdminNosidebarLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('admin-nosidebar.layouts');
    }
}

