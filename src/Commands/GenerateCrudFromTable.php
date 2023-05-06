<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\GenerateCrud\CreateModel;
use App\Console\Commands\GenerateCrud\CreateController;
use App\Console\Commands\GenerateCrud\GetTableColumns;
use App\Console\Commands\GenerateCrud\GetTableRelations;
use App\Console\Commands\GenerateCrud\CreateViews;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateCrudFromTable extends Command
{
    use CreateModel, CreateController, GetTableColumns, GetTableRelations, CreateViews;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:crud {table_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera el CRUD (Modelo, Controlador y Vistas) a partir de una tabla existente';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    //public function __construct()
    //{
    //    parent::__construct();
    //}


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->command = $this;
            $tableName = $this->argument('table_name');

            // Verificar si la tabla existe
            if (!Schema::hasTable($tableName)) {
                $this->error("La tabla '{$tableName}' no existe.");
                return;
            }

            $modelName = Str::studly(Str::singular($tableName));
            $controllerName = $modelName . 'Controller';
            $viewNamespace = Str::kebab($modelName);

            // Obtener columnas de la tabla
            //$columns = $this->getTableColumns($tableName);
            // Obtener relaciones de la tabla
            //$relations = $this->getTableRelations($tableName);
            // Crear Modelo
            //$this->createModel($modelName, $columns, $relations);
            // Crear Controlador
            //$this->createController($controllerName, $modelName, $relations);
            // Crear directorio de vistas y contenido básico
            //$this->createViews($tableName, $modelName, $viewNamespace);
            /* Crear vistas
            $views = ['index', 'create', 'show', 'edit'];
            foreach ($views as $view) {
                $this->createViews($view, $modelName, $viewNamespace);
            }*/

            // Crear instancias de las clases de funciones
            //$createModel = new CreateModel($this);
            //$createController = new CreateController($this);
            //$getTableColumns = new GetTableColumns($this);
            //$getTableRelations = new GetTableRelations($this);
            //$createView = new CreateViews($this);

            // Utilizar las funciones de los traits
            $columns = $this->getTableColumns($tableName);
            $relations = $this->getTableRelations($tableName);
            $this->createModel($modelName, $columns, $relations);
            $this->createController($controllerName, $modelName, $relations);
            $this->createViews($tableName, $modelName, $viewNamespace);

            // Agregar rutas al archivo de rutas
            $routeFile = base_path('routes/web.php');
            $controllerNamespace = "App\Http\Controllers";
            $resourceRoute = "Route::resource('" . Str::kebab(Str::plural($modelName)) . "', '{$controllerNamespace}\\{$controllerName}');";

            if (File::exists($routeFile)) {
                $content = File::get($routeFile);
                if (!str_contains($content, $resourceRoute)) {
                    File::append($routeFile, PHP_EOL . $resourceRoute . PHP_EOL);
                    $this->info("Rutas agregadas al archivo 'routes/web.php'.");
                } else {
                    $this->info("Las rutas ya están presentes en 'routes/web.php'.");
                }
            } else {
                $this->error("No se pudo encontrar el archivo 'routes/web.php'.");
            }



            $this->info("CRUD generado correctamente para la tabla '{$tableName}'.");
        } catch (\Exception $e) {
            $this->error("Error al ejecutar el comando: {$e->getMessage()}");
        }
    }
}
