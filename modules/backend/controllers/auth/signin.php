<div class="connect-signin">

    <div class="connect-signin__header">
        <div class="connect-signin__space">
            <div class="connect-signin__space-title">Espace restaurateur</div>
            <div class="connect-signin__space-icon" aria-hidden="true"></div>
        </div>

        <?php if ($logo = Backend\Models\BrandSetting::getLogo()): ?>
            <img
                src="<?= e($logo) ?>"
                alt="<?= e(Backend\Models\BrandSetting::get('app_name')) ?>"
                class="connect-signin__logoimg"
            />
        <?php endif; ?>
    </div>

    <?= Form::open() ?>
        <input type="hidden" name="postback" value="1" />

        <div class="connect-signin__group" role="form">

            <label class="connect-signin__label" for="login">
                <?= e(trans('Votre identifiant')) ?> <span class="req">*</span>
            </label>
            <input
                id="login"
                type="text"
                name="login"
                value="<?= e(post('login')) ?>"
                class="connect-signin__input"
                placeholder="<?= e(trans('Identifiant')) ?>"
                autocomplete="off"
                maxlength="255"
                autofocus
            />

            <label class="connect-signin__label" for="password">
                <?= e(trans('Votre mot de passe')) ?> <span class="req">*</span>
            </label>
            <div class="connect-signin__passwordwrap">
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="connect-signin__input"
                    placeholder="<?= e(trans('Mot de passe')) ?>"
                    autocomplete="off"
                    maxlength="255"
                />
                <button type="button" class="connect-signin__toggle" aria-label="Afficher/Masquer le mot de passe"></button>
            </div>

            <?php if (is_null(config('cms.backendForceRemember', true))): ?>
                <label class="connect-signin__remember">
                    <input type="checkbox" id="remember" name="remember" />
                    <span><?= e(trans('backend::lang.account.remember_me')) ?></span>
                </label>
            <?php endif; ?>

            <button type="submit" class="connect-signin__submit login-button" data-attach-loading>
                Se connecter
            </button>

        </div>
    <?= Form::close() ?>

    <?= $this->fireViewEvent('backend.auth.extendSigninView') ?>
</div>

<script>
(function() {
    var btn = document.querySelector('.connect-signin__toggle');
    var input = document.getElementById('password');
    if (!btn || !input) return;
    btn.addEventListener('click', function() {
        var isPwd = input.type === 'password';
        input.type = isPwd ? 'text' : 'password';
        btn.classList.toggle('is-active', isPwd);
    });
})();
</script>
