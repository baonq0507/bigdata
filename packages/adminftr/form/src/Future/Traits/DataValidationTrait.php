<?php

namespace Adminftr\Form\Future\Traits;

trait DataValidationTrait
{
    public function rules()
    {
        $inputs = $this->getInputFields();
        $rules = [];
        foreach ($inputs as $input) {
            if ($input->rule) {
                if (str_contains($input->rule, ',')) {
                    $input->rule = str_replace(',', '|', $input->rule);
                    $input->rule = preg_replace('/\s+/', '', $input->rule);
                }
                if (str_contains($input->name, '_confirmation')) {
                    $input->rule = str_replace('confirmed:', 'confirmed:data.', $input->rule);
                }
                $rules["data.{$input->name}"] = $input->rule;
            }
        }
        return $rules;
    }

    public function messages()
    {
        $inputs = $this->getInputFields();
        $messages = [];
        foreach ($inputs as $input) {
            if (!empty($input->messages)) {
                $messages["data.{$input->name}"] = $input->messages;
            }
        };
        return $messages;
    }
}
