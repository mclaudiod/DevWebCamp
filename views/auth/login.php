<main class="auth">
    <h2 class="auth__heading"><?php echo $title; ?></h2>
    <p class="auth__text">Log In on DevWebCamp</p>

    <?php require_once __DIR__ . "/../templates/alerts.php"; ?>

    <form class="form" method="POST" action="/login">
        <div class="form__field">
            <label class="form__label" for="email">Email</label>
            <input type="email" class="form__input" placeholder="Your Email" id="email" name="email">
        </div>

        <div class="form__field">
            <label class="form__label" for="password">Password</label>
            <input type="password" class="form__input" placeholder="Your Password" id="password" name="password">
        </div>

        <input type="submit" class="form__submit" value="Log In">
    </form>

    <div class="actions">
        <a href="/create-account" class="actions__link">You don't have an account yet? Create one</a>
        <a href="/forgot-password" class="actions__link">Forgot your password?</a>
    </div>
</main>