<!DOCTYPE html>
<html lang="<?= App::getLocale() ?>" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <meta name="robots" content="noindex">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="backend-base-path" content="<?= Backend::baseUrl() ?>">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="icon" type="image/png" href="<?= e(Backend\Models\BrandSetting::getFavicon()) ?>">
    <title><?= e(trans('Démonstration')) ?></title>

    <?php
    $coreBuild = System\Models\Parameter::get('system::core.build', 1);

    $styles = [
        Url::asset('modules/system/assets/ui/storm.css'),
        Url::asset('modules/system/assets/ui/icons.css'),
        Backend::skinAsset('assets/css/winter.css'),
    ];
    foreach ($styles as $style) {
        $this->addCss($style, ['build' => 'core', 'order' => 1]);
    }

    // CONNECT override CSS (after winter.css)
    $this->addCss(Url::asset('modules/backend/assets/css/connect-auth.css'), [
        'build' => 'core',
        'order' => 2,
    ]);

    $scripts = [
        Backend::skinAsset('assets/js/vendor/jquery.min.js'),
        Backend::skinAsset('assets/js/vendor/jquery-migrate.min.js'),
        Url::asset('modules/system/assets/js/framework.js'),
        Url::asset('modules/system/assets/ui/storm-min.js'),
        Backend::skinAsset('assets/js/winter-min.js'),
        Url::asset('modules/backend/assets/js/auth/auth.js'),
        Url::asset('modules/system/assets/js/lang/lang.'.App::getLocale().'.js'),
    ];
    foreach ($scripts as $script) {
        $this->addJs($script, ['build' => 'core', 'order' => 1]);
    }
    ?>

    <?php if (!Config::get('cms.enableBackendServiceWorkers', false)): ?>
        <script>
            "use strict";
            if (location.protocol === 'https:') {
                navigator.serviceWorker.getRegistrations().then(
                    function (registrations) {
                        registrations.forEach(function (registration) {
                            registration.unregister();
                        });
                    }
                );
            }
        </script>
    <?php endif; ?>

    <?= $this->makeAssets() ?>
    <?= Block::placeholder('head') ?>
    <?= $this->makeLayoutPartial('custom_styles') ?>
    <?= $this->fireViewEvent('backend.layout.extendHead', ['layout' => 'auth']) ?>
</head>

<body class="layout-auth connect-auth outer <?= $this->bodyClass ?>">

    <header class="connect-topbar" aria-hidden="true">
        <div class="connect-topbar__left">
            <?php if ($logo = Backend\Models\BrandSetting::getLogo()): ?>
                <img src="<?= e($logo) ?>" alt="<?= e(Backend\Models\BrandSetting::get('app_name')) ?>">
            <?php else: ?>
                <span class="connect-topbar__app"><?= e(Backend\Models\BrandSetting::get('app_name')) ?></span>
            <?php endif; ?>
        </div>
        <div class="connect-topbar__center">SITE DE DEMONSTRATION</div>
        <div class="connect-topbar__right">CONNECT</div>
    </header>

    <main class="connect-page">
        <section class="connect-shell">

            <aside class="connect-left">
                <div class="connect-info">
                    <h2>Ce site est une version de démonstration.</h2>
                    <p>
                        Aucunes de vos données personnelles ne seront stockées.
                    </p>
                </div>

                <div class="connect-left-grid">
                    <div class="connect-illus" aria-hidden="true">
                        <div class="sketch"></div>

                        <!-- Poster image -->
                        <div class="poster">
                            <img src="https://agence-lignani.com/modules/backend/assets/images/img-restaurant.jpg" alt="Poster restaurant">
                        </div>
                    </div>

                    <div class="connect-quiz" aria-hidden="true">
                        <div class="badge">Le savez-vous ?</div>
                        <p class="q">Parmi les restaurateurs interrogés, 52% constatent une croissance de leur chiffre d’affaires liée à leur présence digitale, et pour 30%, cette part dépasse 30% du chiffre d'affaires total.</p>
                        <i>Source : FRANCE NUM</i>
                    </div>
                </div>
            </aside>

            <section class="connect-right">
                <div class="connect-card">
                    <?= Block::placeholder('body') ?>
                </div>
            </section>

        </section>
    </main>

    <div id="layout-flash-messages"><?= $this->makeLayoutPartial('flash_messages') ?></div>

</body>
</html>
