<?php

namespace App\View\Components;

use App\Models\Menu as MenuModel;
use Illuminate\View\Component;

class Menu extends Component
{
    public $menuItems;
    public $type; // e.g., 'navbar', 'footer'

    public function __construct($name, $type = 'navbar')
    {
        $this->type = $type;
        $menu = MenuModel::with(['rootItems.children.children.children'])
            ->where('name', $name)
            ->first();

        $this->menuItems = $menu ? $menu->rootItems : collect();
    }

    public function render()
    {
        return view('components.menu');
    }
}
