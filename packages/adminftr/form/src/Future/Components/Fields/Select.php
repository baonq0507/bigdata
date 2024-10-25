<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Select extends Field
{
    public array $options = [];

    public bool $multiple = false;

    public string $valueField = 'id';

    public string $labelField = 'name';

    public int $maxOptions = 50;

    public bool $liveSearch = false;

    public array $searchable = ['name'];
    public string $keySearch = 'name';
    public int $limit = 50;

    public array $plugins = ['input_autogrow', 'caret_position'];

    protected bool $isRelationship = false;
    public function options(array|callable $options)
    {
        if (is_callable($options)) {
            $this->options = call_user_func($options);
        } else {
            $this->options = $options;
        }

        return $this;
    }

    public function getRelationship()
    {
        return $this->isRelationship;
    }

    public function relationship(string $name, string $titleAttribute, callable $modifyQueryUsing = null)
    {
        $this->relationshipName = $name;
        $this->labelField = $titleAttribute;
        $this->modifyQueryUsing = $modifyQueryUsing;
        $this->isRelationship = true;
        $this->liveSearch = true;
        return $this;
    }

    public function searchable(array $searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function getItemsRelation($model, string $value)
    {
        $model = new $model;
        if (!method_exists($model, $this->relationshipName)) {
            throw new Exception("The relationship {$this->relationshipName} does not exist on the model.");
        }
        $modelRelation = $model->{$this->relationshipName}();
        $relatedModelName = $modelRelation->getRelated();
        $query = $relatedModelName::query();
        if ($this->modifyQueryUsing) {
            $query = call_user_func($this->modifyQueryUsing, $query);
        }
        foreach ($this->searchable as $searchable) {
            $query->orWhere($searchable, 'like', '%' . $value . '%');
        }
        return $query->limit($this->limit)->get()->map(function ($item) {
            return [
                "$this->valueField" => $item->{$this->valueField},
                "$this->labelField" => $item->{$this->labelField},
            ];
        });
    }

    public function plugins($plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }

    public function maxOptions(int $maxOptions)
    {
        $this->maxOptions = $maxOptions;

        return $this;
    }

    public function valueField(string $valueField)
    {
        $this->valueField = $valueField;

        return $this;
    }


    public function keySearch(string $keySearch)
    {
        $this->keySearch = $keySearch;

        return $this;
    }


    public function limit(int $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function multiple(bool $multiple = true)
    {
        $this->multiple = $multiple;

        return $this;
    }



    public function render()
    {
        return view('form::base.form.select', [
            'isRequired' => $this->isRequired,
            'classes' => $this->classes,
            'attributes' => $this->getAttributes(),
            'options' => $this->options,
            'defaultValue' => $this->defaultValue,
            'label' => $this->label,
            'canHide' => $this->canHide,
            'name' => $this->name,
            'multiple' => $this->multiple,
            'reactive' => $this->reactive,
            'valueField' => $this->valueField,
            'maxOptions' => $this->maxOptions,
            'liveSearch' => $this->liveSearch,
            'keySearch' => $this->keySearch,
            'labelField' => $this->labelField,
            'plugins' => $this->plugins,
            'isRelationship' => $this->isRelationship,
        ]);
    }


}
