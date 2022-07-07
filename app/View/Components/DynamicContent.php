<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Helpers\Mws;

class DynamicContent extends Component
{

    private $validStores = [3045];
    public $mws;
    public $store;
    public $valid;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $mws = Mws::instance();

        $this -> mws = $mws;
        $this -> store = $mws -> store;;
        $this -> valid = in_array($this -> store -> id,$this -> validStores) ? true : false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.dynamic-content');
    }
}
