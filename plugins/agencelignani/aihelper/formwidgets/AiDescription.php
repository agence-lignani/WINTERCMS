<?php namespace agencelignani\aihelper\FormWidgets;

use Backend\Classes\FormWidgetBase;
use agencelignani\aihelper\Classes\OpenAiClient;
use Winter\Storm\Exception\ApplicationException;

class AiDescription extends FormWidgetBase
{
    protected $defaultAlias = 'aidescription';

    public function widgetDetails()
    {
        return [
            'name'        => 'Description IA',
            'description' => 'Textarea avec bouton pour générer une description via OpenAI.',
        ];
    }

    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('aidescription');
    }

    protected function prepareVars()
    {
        $this->vars['name']       = $this->formField->getName();
        $this->vars['value']      = $this->getLoadValue();
        $this->vars['field']      = $this->formField;
        $this->vars['textareaId'] = $this->getId('textarea');

        $fieldName = $this->formField->getName();

        if (strpos($fieldName, '[desc]') !== false) {
            $sourceName = str_replace('[desc]', '[name]', $fieldName);
        } elseif (strpos($fieldName, '[description]') !== false) {
            $sourceName = str_replace('[description]', '[name]', $fieldName);
        } else {
            $sourceName = $fieldName;
        }

        $this->vars['sourceNameField'] = $sourceName;
    }

    public function getSaveValue($value)
    {
        return $value;
    }

    public function onGenerateDescription()
    {
        $dishName = post('dish_name');

        if (!$dishName) {
            throw new ApplicationException("Le nom du plat doit être renseigné avant de générer la description.");
        }

        $description = OpenAiClient::generateDishDescription($dishName);

        if (!$description) {
            throw new ApplicationException("Impossible de générer une description pour ce plat.");
        }

        return [
            'description' => $description,
        ];
    }
}
