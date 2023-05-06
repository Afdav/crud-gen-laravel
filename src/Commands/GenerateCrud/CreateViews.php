<?php

namespace App\Console\Commands\GenerateCrud;

use Illuminate\Support\Facades\File;

trait CreateViews
{
    protected $command;
/*
    public function __construct($command)
    {
        $this->command = $command;
    }
*/
    private function createViews($tableName, $modelName, $viewNamespace)
    {
        // Crear directorio de vistas
        $viewsPath = resource_path("views/{$tableName}");
        if (!File::exists($viewsPath)) {
            File::makeDirectory($viewsPath);
        }

        // Crear vistas (index, create, show y edit)
        $views = ['index', 'create', 'show', 'edit'];
        foreach ($views as $view) {
            $viewPath = "{$viewsPath}/{$view}.blade.php";
            if (!File::exists($viewPath)) {
                $viewContent = $this->getViewContent($view, $modelName, $viewNamespace);
                File::put($viewPath, $viewContent);
                $this->info("Vista {$view} creada en: {$viewPath}");
            } else {
                $this->info("Vista {$view} ya existe en: {$viewPath}");
            }
        }
    }

    private function getViewContent($view, $modelName, $viewNamespace)
    {
        switch ($view) {
            case 'index':
                return "@extends('layouts.app')

@section('content')
    <h1>{{ __('{$viewNamespace}.index') }}</h1>
    {{-- Aquí va el código para mostrar la lista de {$modelName}s --}}
@endsection
";
            case 'create':
                return "@extends('layouts.app')

@section('content')
    <h1>{{ __('{$viewNamespace}.create') }}</h1>
    {{-- Aquí va el código para el formulario de creación de {$modelName} --}}
@endsection
";
            case 'show':
                return "@extends('layouts.app')

@section('content')
    <h1>{{ __('{$viewNamespace}.show') }}</h1>
    {{-- Aquí va el código para mostrar los detalles de un {$modelName} --}}
@endsection
";
            case 'edit':
                return "@extends('layouts.app')

@section('content')
    <h1>{{ __('{$viewNamespace}.edit') }}</h1>
    {{-- Aquí va el código para el formulario de edición de {$modelName} --}}
@endsection
";
            default:
                return '';
        }
    }
}
