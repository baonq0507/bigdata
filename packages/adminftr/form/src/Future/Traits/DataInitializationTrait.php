<?php

namespace Adminftr\Form\Future\Traits;

trait DataInitializationTrait
{
    /**
     * @var array $selectColumns The columns to select from the database.
     */
    protected array $selectColumns = ['id'];

    /**
     * Initialize the form data based on the provided inputs.
     *
     * @param array $inputs The input fields for the form.
     */
    private function initializeData($inputs)
    {
        if ($this->id && $this->model) {
            $this->loadModelData($inputs);
        } else {
            $this->loadDefaultData($inputs);
        }
    }

    /**
     * Load data from the model based on the provided inputs.
     *
     * @param array $inputs The input fields for the form.
     * @return array The loaded data.
     */
    private function loadModelData($inputs)
    {
        [$fields, $with] = $this->getRelationship($inputs);
        $this->model = $this->model::with($with)->select('*')->find($this->id);
        if ($this->model) {
            $this->data = $this->model->toArray();
            foreach ($with as $relation) {
                if (isset($this->data[$relation])) {
                    $this->relations[$relation] = $this->data[$relation];
                    unset($this->data[$relation]);
                }
            }
        } else {
            return redirect()->route('404');
        }
        return $this->data;
    }

    /**
     * Get the relationship fields and their names from the provided inputs.
     *
     * @param array $inputs The input fields for the form.
     * @return array An array containing the fields and relationships.
     */
    private function getRelationship($inputs)
    {
        $fieldNames = array_map(fn($input) => [
            'name' => $input->relationshipName ?? $input->name,
            'isRelationship' => $input->getRelationship()
        ], array_filter($inputs, fn($input) => $input->canHide !== true));
        $fields = [];
        $with = [];
        foreach ($fieldNames as $fieldName) {
            if (str_contains($fieldName['name'], '_confirmation')) {
                $fieldName['name'] = str_replace('_confirmation', '', $fieldName['name']);
                $fields[] = $fieldName['name'];
            } elseif ($fieldName['isRelationship']) {
                $with[] = $fieldName['name'];
            } else {
                $fields[] = $fieldName['name'];
            }
        }
        return [$fields, $with];
    }

    /**
     * Load default data for the form based on the provided inputs.
     *
     * @param array $inputs The input fields for the form.
     */
    private function loadDefaultData($inputs)
    {
        foreach ($inputs as $input) {
            $this->data[$input->name] = $input->defaultValue;
        }
    }
}
