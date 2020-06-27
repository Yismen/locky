<?php

namespace Dainsys\Locky\View\Components;

use Illuminate\View\Component;

class LockyInputField extends Component
{
    public $fieldValue;

    public $fieldName;

    public $type;

    public $labelName;

    public $required;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fieldValue, $fieldName, $type = null, $labelName, $required = true)
    {
        $this->fieldValue = $fieldValue;
        $this->fieldName = $fieldName;
        $this->type = $type;
        $this->labelName = $labelName;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('locky::components.input-field');
    }
}
