<?php

namespace App\Console\Commands\GenerateCrud;

use Illuminate\Support\Facades\File;

trait CreateModel
{
    protected $command;
/*
    public function __construct($command)
    {
        $this->command = $command;
    }
*/
    private function createModel($modelName, $columns, $relations)
    {
        $modelPath = app_path("Models/{$modelName}.php");

        if (!File::exists($modelPath)) {
            // Generar código para relaciones
            $relationMethods = '';
            foreach ($relations as $relation) {
                $relationMethods .= "\n    public function {$relation['relationName']}()
    {
        return \$this->{$relation['type']}('App\\\\Models\\\\{$relation['relatedModel']}');
    }\n";
            }

            // Generar contenido del modelo
            $modelContent = "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {$modelName} extends Model
{
    use HasFactory;

    protected \$fillable = ['" . implode("', '", $columns) . "'];{$relationMethods}
}";

            File::put($modelPath, $modelContent);
            $this->info("Modelo {$modelName} creado en: {$modelPath}");
        } else {
            $this->info("Modelo {$modelName} ya existe en: {$modelPath}");
        }
    }
}
