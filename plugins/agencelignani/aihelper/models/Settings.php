<?php namespace agencelignani\aihelper\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'agencelignani_aihelper_settings';
    public $settingsFields = 'fields.yaml';
}
