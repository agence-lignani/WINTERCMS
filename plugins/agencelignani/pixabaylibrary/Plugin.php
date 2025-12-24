<?php

namespace Agencelignani\Pixabaylibrary;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Pixabay Image Library',
            'description' => 'Rechercher et importer des images libres de droits depuis Pixabay dans le gestionnaire de Médias.',
            'author'      => 'Agence Lignani',
            'icon'        => 'icon-picture-o',
        ];
    }

    public function registerNavigation()
    {
        return [
            'pixabaylibrary' => [
                'label'       => 'Banque d’images',
                'url'         => Backend::url('agencelignani/pixabaylibrary/images'),
                'icon'        => 'icon-picture-o',
                'permissions' => ['agencelignani.pixabaylibrary.access'],
                'order'       => 500,
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'agencelignani.pixabaylibrary.access' => [
                'tab'   => 'Pixabay',
                'label' => 'Accéder à la banque d’images Pixabay',
            ],
        ];
    }
}
