<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as Command;

/**
 * Class ModelMakeCommand
 *
 * @package App\Console\Commands
 */
class ModelMakeCommand extends Command
{
    const MODELS_NAMESPACE = 'Models';

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\\" . self::MODELS_NAMESPACE;
    }
}
