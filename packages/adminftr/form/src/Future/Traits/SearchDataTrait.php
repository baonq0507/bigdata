<?php

namespace Adminftr\Form\Future\Traits;

trait SearchDataTrait
{
    public function searchSelect($value, $field)
    {
        $this->skipRender();
        $selectFields = $this->getSelectFields();

        foreach ($selectFields as $selectField) {
            if ($selectField->name == $field) {
                if ($selectField->getRelationship()) {
                    return $selectField->getItemsRelation($this->model, $value);
                }
            }
        }

        return [];
    }

    public function optionsRadioTree($name)
    {
        $this->skipRender();
        $radioTreeFields = $this->getRadioTreeField($name);
        return $radioTreeFields->options;
    }

    public function checkBoxOptions($name)
    {
        $this->skipRender();
        $inputs = $this->getInputFields();
        foreach ($inputs as $input) {
            if ($input->name === $name) {
              if ($input->getRelationship()) {
                return $input->getOptionsInRelationship($this->model);
              }else{
                  return is_callable($input->options) ? call_user_func($input->options) : $input->options;
              }
            }
        }
        return [];
    }

    public function getItemsRelation($name, $search)
    {
        $this->skipRender();
        $inputs = $this->getInputFields();
        foreach ($inputs as $input) {
            if ($input->name === $name) {
                return $input->relation($search);
            }
        }
        return [];
    }
}
