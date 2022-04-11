<?php

namespace App\View\Components\Site;

use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public ?string $value;
    public ?array $options;
    public string $key;
    public string $optionValue;
    public ?string $label;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param string|null $label
     * @param null $value
     * @param array|null $options
     * @param string $key
     * @param string $optionValue
     */
    public function __construct($name,string $label = '', $value = '', array $options = [], string $key = 'id', string $optionValue = 'title')
    {
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
        $this->key = $key;
        $this->optionValue = $optionValue;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.site.select');
    }
}
