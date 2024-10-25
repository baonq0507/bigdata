<?php

namespace Adminftr\Form\Future\Traits;

use Adminftr\Core\Http\Models\FileManager;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait DataPersistenceTrait
{
    /**
     * Persist the form data by processing uploads and updating or creating the model.
     * @throws Exception
     */
    private function persistData()
    {
        $this->processUploads();
        if ($this->id) {
            $this->updateModel();
        } else {
            $this->createModel();
        }
    }

    /**
     * Process file uploads for the form.
     */
    private function processUploads()
    {
        $uploadFields = $this->getUploadFields();
        if (!$uploadFields) {
            return;
        }

        foreach ($uploadFields as $field) {
            if ($field->isRelationship) {
                $name = $field->relationshipName;
                $dataItem = $this->relations[$name] ?? null;
            } else {
                $name = $field->name;
                $dataItem = $this->data[$name] ?? null;
            }
            if (!$dataItem) {
                continue;
            }
            if ($dataItem instanceof UploadedFile) {
                if ($field->isRelationship) {
                    $this->relations[$name] = $this->storeUploadedFile($dataItem, $field);
                } else {
                    $this->data[$name] = $this->storeUploadedFile($dataItem, $field);
                }
            } elseif (is_array($dataItem)) {
                if ($field->isRelationship) {
                    $this->relations[$name] = $this->storeUploadedFiles($dataItem, $field);
                } else {
                    $this->data[$name] = $this->storeUploadedFiles($dataItem, $field);
                }
            }
        }

    }

    /**
     * Store a single uploaded file.
     *
     * @param UploadedFile $file The uploaded file.
     * @param object $field The field configuration.
     * @return int The ID of the stored file.
     */
    private function storeUploadedFile(UploadedFile $file, $field)
    {
        $filename = str_replace(' ', '_', $file->getClientOriginalName());
        $file->storeAs($field->path, $filename, $field->disk);
        return FileManager::updateOrCreate([
            'file_path' => $field->disk.'/'.$field->path . '/' . $filename,
            'file_name' => $filename,
            'folder_path' => $field->disk.'/'.$field->path,
            'user_id' => auth()->id() ?? null,
            'file_type' => Storage::disk($field->disk)->mimeType($field->path . '/' . $filename),
            'file_size' => $file->getSize(),
        ])->file_path;
    }

    /**
     * Store multiple uploaded files.
     *
     * @param array $files The array of uploaded files.
     * @param object $field The field configuration.
     * @return array The IDs of the stored files.
     */
    private function storeUploadedFiles(array $files, $field)
    {
        $isFileArray = false;
        $uploadedPaths = [];
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $isFileArray = true;
                $uploadedPaths[] = $this->storeUploadedFile($file, $field);
            }
        }
        if (!$isFileArray) {
            return $files;
        }
        return $uploadedPaths;
    }

    /**
     * Update the existing model with the form data.
     *
     * @throws Exception If the model is not found.
     */
    private function updateModel()
    {
        $model = $this->model::find($this->id);
        if (!$model) {
            throw new Exception('Record not found.');
        }
        $modelData = $this->data;
        $relationshipData = $this->relations;
        // Remove null values
        $modelData = array_filter($modelData, fn($value) => $value !== null && $value !== '');
        $model->update($modelData);
        $this->processRelationships($model, $relationshipData);
        $this->refreshData();
    }

    /**
     * Create a new model with the form data.
     */
    private function createModel()
    {
        $modelData = $this->data;
        $relationshipData = $this->relations;
        $model = $this->model::create($modelData);
        $this->processRelationships($model, $relationshipData);
    }

    /**
     * Process the relationships for the model.
     *
     * @param object $model The model instance.
     * @param array $relationshipData The relationship data.
     */
    private function processRelationships($model, $relationshipData)
    {
        foreach ($relationshipData as $relationKey => $data) {
            $relationName = $relationKey;
            $relation = $model->$relationName();
            if (!$relation) {
                continue;
            }
            $filed = $this->findInputByRelationshipName($relationName);
            if ($relation instanceof BelongsToMany) {
                $this->processBelongsToMany($relation, $data, $filed);
            } else {
                $this->processHasOneOrMany($relation, $data, $filed);
            }
        }
    }

    /**
     * Process a BelongsToMany relationship.
     *
     * @param BelongsToMany $relation The relationship instance.
     * @param array $data The relationship data.
     * @param object $field The field configuration.
     */
    private function processBelongsToMany($relation, $data, $field)
    {
        if (empty($data)) {
            return;
        }
        $relation->detach();
        $syncData = [];
        foreach ($data as $value) {
            if (is_callable($field->beforeSave)) {
                $value = call_user_func($field->beforeSave, [$value]);
            }
            if (is_array($value)) {
                $syncData[] = $value['id'];
            }
            else {
                $syncData[] = $value;
            }
        }
        $relation->attach($syncData);
    }

    /**
     * Process a HasOne or HasMany relationship.
     *
     * @param object $relation The relationship instance.
     * @param array $data The relationship data.
     * @param object $field The field configuration.
     * @param string $keyField The key field for the relationship.
     */
    private function processHasOneOrMany($relation, $data, $field, $keyField='id')
    {
        if (empty($data)) {
            if ($relation->exists()) {
                $relation->delete();
            }
            return;
        }

        foreach ($data as $value) {
            if (is_callable($field->beforeSave)) {
                $value = call_user_func($field->beforeSave, $value);
            }

            $keyValue = is_array($value) ? ($value[$keyField] ?? null) : $value;

            $relation->updateOrCreate(
                [$keyField => $keyValue],
                $value
            );
        }
    }

    /**
     * Refresh the form data from the model.
     */
    private function refreshData()
    {
        $inputs = $this->getInputFields();
        [$fields, $with] = $this->getRelationship($inputs);

        $this->data = $this->model::with($with)->find($this->id)->toArray();

        foreach ($with as $relation) {
            if (isset($this->data[$relation])) {
                $this->relations[$relation] = $this->data[$relation];
                unset($this->data[$relation]);
            }
        }
    }
}
