<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;
use Illuminate\Database\Eloquent\Model;

class RadioTree extends Field
{
    public array $options = [];
    protected bool $isRelationship = false;
    public function options($source)
    {
        if (is_callable($source)) {
            $this->options = $source();
        } elseif (is_array($source)) {
            $this->options = $source;
        } else {
            throw new \InvalidArgumentException('Options must be a callable or an array.');
        }
        if (!$this->validateOptionsStructure($this->options)) {
            throw new \InvalidArgumentException('Invalid options structure.');
        }
        return $this;
    }
    public function getRelationship()
    {
        return $this->isRelationship;
    }
    public function relation(Model $model,?string $childrenKey = null,string $key = 'id', string $name='name' )
    {
        // Eager loading để giảm số lần truy vấn
        $items = $model::with($childrenKey)->whereNull($this->name)->get();
        $this->options = $items->map(function ($item) use ($key, $name, $childrenKey) {
            $option = [
                'id' => $item->{$key},
                'name' => $item->{$name},
            ];

            // Kiểm tra và ánh xạ children nếu tồn tại
            if ($childrenKey && $item->{$childrenKey}->isNotEmpty()) {
                $option['children'] = $item->{$childrenKey}->map(function ($child) use ($key, $name) {
                    return [
                        'id' => $child->{$key},
                        'name' => $child->{$name},
                    ];
                })->toArray();
            }

            return $option;
        })->toArray();

        return $this;
    }

    private function validateOptionsStructure(array $options): bool
    {
        foreach ($options as $option) {
            if (!isset($option['id'], $option['name'])) {
                return false;
            }

            if (isset($option['children']) && !is_array($option['children'])) {
                return false;
            }

            // Validate sub-categories structure recursively if present
            if (!empty($option['children'])) {
                if (!$this->validateOptionsStructure($option['children'])) {
                    return false;
                }
            }
        }

        return true;
    }
    public function render()
    {
        return view('form::base.form.radio-tree',[
            'name' => $this->name,
            'label' => $this->label,
            'required' => $this->isRequired,
        ]);
    }
}
