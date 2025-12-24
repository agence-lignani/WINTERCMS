<?php namespace agencelignani\aihelper\Classes;

use agencelignani\aihelper\Models\Settings;
use Winter\Storm\Exception\ApplicationException;

class OpenAiClient
{
    public static function generateDishDescription(string $dishName, string $language = 'fr'): ?string
    {
        // 1) D'abord .env si présent
        $apiKey = env('OPENAI_API_KEY');

        // 2) Sinon les Settings du plugin
        if (!$apiKey) {
            $apiKey = Settings::get('openai_api_key');
        }

        if (!$apiKey) {
            throw new ApplicationException('Clé API OpenAI manquante (ni OPENAI_API_KEY, ni paramètres IA & OpenAI).');
        }

        $prompt = "
Tu es un rédacteur spécialisé dans les descriptions de plats pour des restaurants généralistes.

Directives de style :
- Ton neutre et convivial.
- Style simple, accessible à tous types de clients.
- Texte fluide, naturel, sans formulations trop techniques.
- 2 à 3 phrases maximum.
- Pas de liste à puces.
- Ne pas répéter le nom du plat au début de manière robotique.
- Faire envie sans exagération.

Rédige une description en français pour le plat suivant : \"{$dishName}\".
";

        $endpoint = 'https://api.openai.com/v1/chat/completions';

        $payload = [
            'model' => 'gpt-4.1-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Tu rédiges des descriptions courtes, neutres et conviviales pour des menus de restaurants généralistes.',
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'temperature' => 0.6,
            'max_tokens'  => 150,
        ];

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_TIMEOUT        => 15,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (!isset($data['choices'][0]['message']['content'])) {
            return null;
        }

        $text = trim($data['choices'][0]['message']['content']);
        $text = preg_replace('/^["“]+|["”]+$/u', '', $text);

        return $text;
    }
}
