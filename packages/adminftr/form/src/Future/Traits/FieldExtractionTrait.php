<?php

namespace Adminftr\Form\Future\Traits;

use Adminftr\Form\Future\Components\Field;
use Adminftr\Form\Future\Components\Fields\RadioTree;
use Adminftr\Form\Future\Components\Fields\Select;
use Adminftr\Form\Future\Components\Fields\Upload;

trait FieldExtractionTrait
{
    protected function findInputByName($name)
    {
        return collect($this->getInputFields())->first(function ($field) use ($name) {
            return $field->name === $name;
        });
    }

    protected function findInputByRelationshipName($name)
    {
        return collect($this->getInputFields())->first(function ($field) use ($name) {
            return $field->relationshipName === $name;
        });
    }

    protected function getRadioTreeFields()
    {
        return $this->extractFields($this->form->render(), RadioTree::class);
    }

    protected function getRadioTreeField($name)
    {
        return collect($this->getRadioTreeFields())->first(function ($field) use ($name) {
            return $field->name === $name;
        });
    }

    protected function getInputFields()
    {
        return $this->extractFields($this->form->render(), Field::class);
    }

    private function extractFields($fields, $type, $isRelationship = false)
    {
        return array_reduce($fields, function ($extractedFields, $field) use ($type, $isRelationship) {
            if ($field instanceof $type && (!$isRelationship || $field->getRelationship()) && !$field->canHide) {
                $extractedFields[] = $field;
            } elseif (method_exists($field, 'getFields')) {
                $extractedFields = array_merge($extractedFields, $this->extractFields($field->getFields(), $type, $isRelationship));
            }
            return $extractedFields;
        }, []);
    }

    protected function getSelectFields()
    {
        return $this->extractFields($this->form->render(), Select::class);
    }

    protected function getRelationshipFields()
    {
        return $this->extractFields($this->form->render(), Field::class, true);
    }

    protected function findRelationshipField($name)
    {
        return collect($this->getRelationshipFields())->first(function ($field) use ($name) {
            return $field->name === $name;
        });
    }

    protected function getUploadFields()
    {
        return $this->extractFields($this->form->render(), Upload::class);
    }
}
