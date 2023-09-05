<main class="auth">
    <h2 class="auth__heading"><?php echo $title; ?></h2>
    <p class="auth__text">Recover your access to DevWebCamp</p>

    <?php require_once __DIR__ . "/../templates/alerts.php"; ?>

    <form class="form" method="POST" action="/forgot-password">
        <div class="form__field">
            <label class="form__label" for="email">Email</label>
            <input type="email" class="form__input" placeholder="Your Email" id="email" name="email">
        </div>

        <input type="submit" class="form__submit" value="Send Instructions">
    </form>

    <div class="actions">
        <a href="/login" class="actions__link">You already have an account? Log In</a>
        <a href="/create-account" class="actions__link">You don't have an account yet? Create one</a>
    </div>
</main>