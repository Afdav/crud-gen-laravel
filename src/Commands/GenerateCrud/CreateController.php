<?php

namespace App\Console\Commands\GenerateCrud;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait CreateController
{
    protected $command;
/*
    public function __construct($command)
    {
        $this->command = $command;
    }
*/
    private function createController($controllerName, $modelName, $relations)
    {
        $controllerPath = app_path("Http/Controllers/{$controllerName}.php");

        if (!File::exists($controllerPath)) {
            // Generar código para la inyección de dependencias en el constructor
            $relatedModels = array_unique(array_map(function ($relation) {
                return $relation['relatedModel'];
            }, $relations));
            $constructorCode = '';
            foreach ($relatedModels as $relatedModel) {
                $constructorCode .= "use App\\Models\\{$relatedModel};\n";
            }

            $modelNamePlural = Str::plural(Str::camel($modelName));
            $viewNamespace = Str::snake($modelName);

            // Generar código para las funciones básicas de controlador de recursos
            $functionCode = "
            public function index()
            {
                \${$modelNamePlural} = {$modelName}::all();
                return view('{$viewNamespace}.index', compact('{$modelNamePlural}'));
            }

            public function create()
            {
                return view('{$viewNamespace}.create');
            }

            public function store(Request \$request)
            {
                \$request->validate([
                    // Agregar reglas de validación aquí
                ]);

                {$modelName}::create(\$request->all());
                return redirect()->route('{$viewNamespace}.index')->with('success', '{$modelName} created successfully.');
            }

            public function show({$modelName} \${$modelName})
            {
                return view('{$viewNamespace}.show', compact('{$modelName}'));
            }

            public function edit({$modelName} \${$modelName})
            {
                return view('{$viewNamespace}.edit', compact('{$modelName}'));
            }

            public function update(Request \$request, {$modelName} \${$modelName})
            {
                \$request->validate([
                    // Agregar reglas de validación aquí
                ]);

                \${$modelName}->update(\$request->all());
                return redirect()->route('{$viewNamespace}.index')->with('success', '{$modelName} updated successfully.');
            }

            public function destroy({$modelName} \${$modelName})
            {
                \${$modelName}->delete();
                return redirect()->route('{$viewNamespace}.index')->with('success', '{$modelName} deleted successfully.');
            }
        ";

            // Generar contenido del controlador
            $controllerContent = "<?php

namespace App\Http\Controllers;

use App\Models\\{$modelName};
use Illuminate\Http\Request;
{$constructorCode}
class {$controllerName} extends Controller
{
    {$functionCode}
}";

            File::put($controllerPath, $controllerContent);
            $this->info("Controlador {$controllerName} creado en: {$controllerPath}");
        } else {
            $this->info("Controlador {$controllerName} ya existe en: {$controllerPath}");
        }
    }
}
