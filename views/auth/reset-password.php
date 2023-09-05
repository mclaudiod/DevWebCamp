<main class="auth">
    <h2 class="auth__heading"><?php echo $title; ?></h2>

    <?php require_once __DIR__ . "/../templates/alerts.php"; ?>

    <?php if($validToken) { ?>
        <form class="form" method="POST">
            <div class="form__field">
                <label class="form__label" for="password">New Password</label>
                <input type="password" class="form__input" placeholder="Your new Password" id="password" name="password">
            </div>

            <div class="form__field">
                <label class="form__label" for="rpassword">Repeat New Password</label>
                <input type="password" class="form__input" placeholder="Repeat your new Password" id="rpassword" name="rpassword">
            </div>

            <input type="submit" class="form__submit" value="Reset Password">
        </form>
    <?php } ?>

    <div class="actions">
        <a href="/login" class="actions__link">You already have an account? Log In</a>
        <a href="/create-account" class="actions__link">You don't have an account yet? Create one</a>
    </div>
</main>