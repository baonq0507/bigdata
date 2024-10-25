<?php

namespace Adminftr\Form\Future\Components\Fields;

use Adminftr\Form\Future\Components\Field;
use Adminftr\Form\Future\Components\UrlHelper;

class Upload extends Field
{
    public bool $canHide = false;

    public int $maxfiles = 5;
    public string $path = '';
    public string $acceptedFileTypes = 'image/png, image/jpeg, image/gif';
    public string $namesave = '';
    public string $disk = 'public';
    protected bool $multiple = false;
    public bool $isRelationship = false;
    public $relationshipName = '';
    public $filePath = '';

    public function multiple(bool $multiple = true)
    {
        $this->multiple = $multiple;

        return $this;
    }
    public function getRelationship()
    {
        return $this->isRelationship;
    }
    public function relationship(string $name, string $path, callable $modifyQueryUsing = null)
    {
        $this->relationshipName = $name;
        $this->filePath = $path;
        $this->modifyQueryUsing = $modifyQueryUsing;
        $this->isRelationship = true;
        return $this;
    }

    public function maxFiles(int $maxfiles)
    {
        $this->maxfiles = $maxfiles;

        return $this;
    }

    public function storeAs($path, $name, $disk)
    {
        $this->path = $path;
        $this->namesave = $name;
        $this->disk = $disk;

        return $this;
    }

    public function accept(string $acceptedFileTypes)
    {
        $this->acceptedFileTypes = $acceptedFileTypes;

        return $this;
    }

    public function render()
    {
        $wireModelDirective = $this->multiple ? 'wire:model.lazy' : 'wire:model';
        if (!$this->canHide) {
            return view('form::base.form.upload', [
                'name' => $this->name,
                'multiple' => $this->multiple,
                'label' => $this->label,
                'wireModelDirective' => $wireModelDirective,
                'maxfiles' => $this->maxfiles,
                'acceptedFileTypes' => $this->acceptedFileTypes,
                'isRelationship' => $this->isRelationship,
                'relationshipName'=>$this->relationshipName,
                'filePath'=>$this->filePath,
            ]);
        }

        return '';
    }
}
