<?php

namespace Adminftr\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateFutureResource extends Command
{
    protected $signature = 'future:resource {name} {--model= : Optional model name}';
    protected $description = 'Create a new future resource with a table and form.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        if (!preg_match('/^[a-zA-Z_]+$/', $name)) {
            $this->error('Resource name must only contain letters and underscores.');
            return;
        }
        $model = $this->option('model') ?: lcfirst($name);
        $basePath = app_path("Future/{$name}Resource");
        $futurePath = app_path("Future");
        // Ensure the base directory exists

        // Check if files already exist
        if (File::exists("{$basePath}/Table.php")) {
            $this->error('Resource already exists!');
            return;
        }

        if (File::exists("{$basePath}/Form.php")) {
            $this->error('Resource already exists!');
            return;
        }
        $textColumn = [];
        $modelPath = app_path("Models/{$model}.php");
        if (File::exists($modelPath)) {
            $modelContent = File::get($modelPath);
            preg_match_all('/\$fillable\s*=\s*\[([^\]]+)\];/', $modelContent, $matches);
            if (isset($matches[1][0])) {
                $textColumn = array_map(function ($column) {
                    $column = trim($column, " \t\n\r\0\x0B'");
                    return "TextColumn::make('{$column}', __('" . ucfirst($column) . "'))->sortable(),";
                }, explode(',', $matches[1][0]));
            }
        }

        File::ensureDirectoryExists($basePath);
        // Define stub paths in the package
        $stubPath = __DIR__ . DIRECTORY_SEPARATOR . 'stubs';
        $stubPath = str_replace('\\', '/', $stubPath);

        $resourceStub = File::get("{$stubPath}/resource.stub");
        $resourceContent = str_replace(['{{name}}'], [$name], $resourceStub);
        File::put("{$futurePath}/{$name}Resource.php", $resourceContent);

        $tableStub = File::get("{$stubPath}". '/table.stub');
        $tableContent = str_replace(
            ['{{ name }}', '{{ model }}', '{{ columns }}'],
            [$name, $model, implode(",\n\t\t", $textColumn)],
            $tableStub
        );
        File::put("{$basePath}/Table.php", $tableContent);

        $formStub = File::get("{$stubPath}". '/form.stub');
        $formContent = str_replace(['{{ name }}', '{{ model }}'], ["{$name}", $model], $formStub);
        File::put("{$basePath}/Form.php", $formContent);

        $this->info('Future resource created successfully.');
    }
}
