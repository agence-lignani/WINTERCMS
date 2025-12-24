<?php namespace agencelignani\aihelper;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * Infos du plugin
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'AI Helper',
            'description' => 'Utilitaires IA (OpenAI) pour le back-office : génération manuelle de descriptions.',
            'author'      => 'Agence Lignani',
            'icon'        => 'icon-magic',
        ];
    }

    /**
     * Page de configuration "IA & OpenAI" dans les Paramètres
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'IA & OpenAI',
                'description' => 'Configuration de la clé API OpenAI pour la génération de contenu.',
                'category'    => 'AI',
                'icon'        => 'icon-magic',
                'class'       => \agencelignani\aihelper\Models\Settings::class,
                'order'       => 500,
            ],
        ];
    }

    /**
     * Déclaration des form widgets personnalisés
     */
    public function registerFormWidgets()
    {
        return [
            'agencelignani\aihelper\FormWidgets\AiDescription' => [
                'label' => 'Description IA',
                'code'  => 'aidescription',
            ],
        ];
    }

    /**
     * IMPORTANT :
     * Pas de boot(), pas de hook sur ThemeData.
     * => AUCUNE génération automatique, l’API n’est appelée
     *    que via le widget (bouton "Générer avec l’IA").
     */
}
