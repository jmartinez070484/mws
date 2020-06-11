<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Helpers\Mws;

class Sidebar extends Component
{
    public $store;
    public $feed;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $mws = Mws::instance();
        $store = $mws -> store;
        $feed = $store -> feed;

        $this -> store = $store;
        $this -> feed = $feed -> take(3);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.sidebar');
    }
}
