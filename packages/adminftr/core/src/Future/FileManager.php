<?php

namespace Adminftr\Core\Future;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Lazy;
use Livewire\Component;
//#[Lazy]
class FileManager extends Component
{
    public int $limit = 48;
    public function getFiles(string $folderName='')
    {
        $this->skipRender();
        if ($folderName === '') {
            $folderPath = 'public';
        }else {
            $folderPath = 'public/' . $folderName;
        }
        $folders = Storage::disk('public')->directories($folderName);
        $offset = $this->limit - 48;
        $files = \Adminftr\Core\Http\Models\FileManager::where('folder_path','=', $folderPath)->offset($offset)->limit($this->limit)->get();
        return [
            'folders' => $folders,
            'files' => $files
        ];
    }

    public function findFile($file)
    {
        $this->skipRender();
        return \Adminftr\Core\Http\Models\FileManager::where('file_name', $file)->first();
    }

    public function deleteFile($file)
    {
        $this->skipRender();
        $file = \Adminftr\Core\Http\Models\FileManager::where('file_name', $file)->first();
        if ($file) {
            $file->delete();
            return $file->file_name;
        }
        return;
    }


    public function deleteFolder($name)
    {
        $this->skipRender();
        Storage::disk('public')->deleteDirectory($name);
        return $name;
    }

    public function createFolder($folderName, $path)
    {
        $this->skipRender();
        if ($path !== '') {
            $folderName = $path . '/' . $folderName;
        }
        if (Storage::disk('public')->exists($folderName) ) {
            $this->dispatch('alert-error', 'Error', 'Folder already exists');
            return;
        }

        Storage::disk('public')->makeDirectory($folderName);
        return $folderName;
    }


    public function uploadAllFromDirectory($directory='public')
    {
        $this->skipRender();
        // Get all files in the specified directory
        $files = Storage::allFiles($directory);

        // Iterate over each file
        foreach ($files as $file) {
            $path = Storage::path($file);
            $fileInfo = pathinfo($path);

            // Gather file details
            $fileDetails = [
                'file_name'   => $fileInfo['basename'],
                'file_path'   => $file,
                'folder_path' => dirname($file),
                'file_type'   => Storage::mimeType($file),
                'file_size'   => Storage::size($file),
                'description' => null, // Default to null or add logic to set this
                'tags'        => null, // Default to null or add logic to set this
            ];
            $file = \Adminftr\Core\Http\Models\FileManager::where('file_name', $fileInfo['basename'])
                ->Where('folder_path', dirname($file))
                ->first();
            if ($file) {
                $file->update($fileDetails);
                continue;
            }
           \Adminftr\Core\Http\Models\FileManager::create($fileDetails);

            $this->dispatch('fileUploaded');

            return;
        }

      return;
    }
    public function render()
    {
        return view('future::future.file-manager');
    }
}
