<?php

namespace Agencelignani\Pixabaylibrary\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Input;
use Exception;
use Cms\Classes\MediaLibrary;
use Config;
use Agencelignani\Pixabaylibrary\Classes\PixabayService;

class Images extends Controller
{
    public $requiredPermissions = ['agencelignani.pixabaylibrary.access'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Agencelignani.Pixabaylibrary', 'pixabaylibrary', 'pixabaylibrary');
    }

    public function index()
    {
        $this->pageTitle = 'Banque d’images Pixabay';

        $query = trim((string) Input::get('q', ''));
        $page  = (int) Input::get('page', 1);

        $results = null;
        $error   = null;

        if ($query !== '') {
            try {
                $service = new PixabayService();
                $results = $service->search($query, $page);
            } catch (Exception $ex) {
                $error = $ex->getMessage();
            }
        }

        $this->vars['query']   = $query;
        $this->vars['page']    = $page;
        $this->vars['results'] = $results;
        $this->vars['error']   = $error;
    }

    public function onImportImage()
    {
        $imageUrl = Input::get('image_url');
        $filename = Input::get('filename', 'pixabay-image.jpg');

        if (!$imageUrl) {
            throw new Exception('URL de l’image manquante.');
        }

        // Nettoyage du nom de fichier
        $filename = preg_replace('/[^a-zA-Z0-9_\.]/', '_', $filename);
        if ($filename === '') {
            $filename = 'pixabay-image.jpg';
        }

        $pathInMedia = 'pixabay/' . $filename;

        // Limite de taille depuis la config
        $maxKb = (int) Config::get('agencelignani.pixabaylibrary::max_filesize_kb', 250);

        // Téléchargement du fichier
        $context = stream_context_create(['http' => ['timeout' => 12]]);
        $contents = @file_get_contents($imageUrl, false, $context);

        if ($contents === false) {
            throw new Exception('Impossible de télécharger l’image depuis Pixabay.');
        }

        // Vérification de la taille (en Ko)
        $sizeKb = strlen($contents) / 1024;

        if ($maxKb > 0 && $sizeKb > $maxKb) {
            $sizeKbRounded = (int) round($sizeKb);

            throw new Exception(
                'L’image est trop volumineuse (' . $sizeKbRounded . ' Ko). '
                . 'Taille maximale autorisée : ' . $maxKb . ' Ko.'
            );
        }

        // Vérification optionnelle des dimensions
        $info = @getimagesizefromstring($contents);
        if ($info) {
            $width  = $info[0] ?? 0;
            $height = $info[1] ?? 0;

            if ($width > 3000 || $height > 3000) {
                throw new Exception(
                    'L’image est trop grande (' . $width . '×' . $height . ' px). '
                    . 'Dimensions max autorisées : 3000×3000 px.'
                );
            }
        }

        // Si tout est OK, on enregistre dans Médias
        $media = MediaLibrary::instance();
        $media->put($pathInMedia, $contents);

        // 🔄 On force le refresh du cache média
        $media->resetCache();

        Flash::success('Image importée avec succès dans Médias : ' . $pathInMedia);

        return ['#pixabay-flash' => $this->makePartial('flash')];
    }
}
