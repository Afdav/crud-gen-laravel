<?php

namespace App\Console\Commands\GenerateCrud;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait GetTableRelations
{
    protected $command;
/*
    public function __construct($command)
    {
        $this->command = $command;
    }
*/
    private function getTableRelations($tableName)
    {
        $relations = [];

        // Obtener las claves foráneas de la tabla
        $foreignKeys = DB::select(
            "
        SELECT kcu.COLUMN_NAME as column_name,
               kcu.REFERENCED_TABLE_NAME as referenced_table_name,
               kcu.REFERENCED_COLUMN_NAME as referenced_column_name
        FROM information_schema.KEY_COLUMN_USAGE as kcu
        WHERE kcu.TABLE_SCHEMA = ? AND
              kcu.TABLE_NAME = ? AND
              kcu.REFERENCED_TABLE_NAME IS NOT NULL",
            [env('DB_DATABASE'), $tableName]
        );

        // Detectar relaciones basadas en las claves foráneas
        foreach ($foreignKeys as $foreignKey) {
            $relationName = Str::camel(Str::singular($foreignKey->referenced_table_name));
            $relations[] = [
                'type' => 'belongsTo',
                'column' => $foreignKey->column_name,
                'relatedModel' => Str::studly($relationName),
                'relationName' => $relationName,
            ];
        }

        return $relations;
    }
}
