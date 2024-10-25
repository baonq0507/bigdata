<?php

namespace Adminftr\Form\Future\Components;

class Form
{
    protected $inputs = [];

    public function schema(array $inputs)
    {
        $this->inputs = $inputs;

        return $this;
    }

    public function render()
    {
        return $this->inputs;
    }


}
