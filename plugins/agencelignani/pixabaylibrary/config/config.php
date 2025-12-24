<?php

return [

    // Clé API Pixabay (à définir dans .env : PIXABAY_API_KEY=xxx)
    'api_key'  => env('PIXABAY_API_KEY', ''),

    // Nombre de résultats par page
    'per_page' => 24,

    // Taille maximale autorisée pour une image importée (en kilo-octets)
    // 250 = 250 Ko max
    'max_filesize_kb' => 250,
];
