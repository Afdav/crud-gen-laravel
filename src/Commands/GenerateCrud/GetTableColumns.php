<?php

namespace App\Console\Commands\GenerateCrud;

use Illuminate\Support\Facades\Schema;

trait GetTableColumns
{
    protected $command;
/*
    public function __construct($command)
    {
        $this->command = $command;
    }
*/
    public function getTableColumns($tableName)
    {
        return Schema::getColumnListing($tableName);
    }
}
