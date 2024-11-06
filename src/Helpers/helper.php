<?php

if (!function_exists('config_path')) {
    /**
     * Récupère le chemin du dossier de configuration.
     *
     * @param  string  $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath('config') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
