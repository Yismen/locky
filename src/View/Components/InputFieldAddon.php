<?php

namespace Dainsys\Locky\View\Components;

use Illuminate\View\Component;

class InputFieldAddon extends Component
{
    public $fieldValue;

    public $fieldName;

    public $type;

    public $labelName;

    public $required;

    public $buttonAction;

    public $btnClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fieldValue, $fieldName, $type = null, $labelName, $required = true, $buttonAction = "CREATE", $btnClass = 'btn-primary')
    {
        $this->fieldValue = $fieldValue;
        $this->fieldName = $fieldName;
        $this->type = $type;
        $this->labelName = $labelName;
        $this->required = $required;
        $this->buttonAction = $buttonAction;
        $this->btnClass = $btnClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('locky::components.input-field-addon');
    }
}
