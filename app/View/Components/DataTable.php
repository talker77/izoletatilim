<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    /**
     * @var array
     */
    public $columns;

    /**
     * @var
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @param array $columns
     * @param string $url
     */
    public function __construct(array $columns,string $url)
    {
        $this->columns = $columns;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.data-table');
    }
}
