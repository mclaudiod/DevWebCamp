<main class="auth">
    <h2 class="auth__heading"><?php echo $title; ?></h2>
    <p class="auth__text">Create an account on DevWebCamp</p>

    <?php require_once __DIR__ . "/../templates/alerts.php"; ?>

    <form class="form" action="/create-account" method="POST">
        <div class="form__field">
            <label class="form__label" for="name">Name</label>
            <input type="text" class="form__input" placeholder="Your Name" id="name" name="name" value="<?php echo $user->name; ?>">
        </div>

        <div class="form__field">
            <label class="form__label" for="surname">Surname</label>
            <input type="text" class="form__input" placeholder="Your Surname" id="surname" name="surname" value="<?php echo $user->surname; ?>">
        </div>

        <div class="form__field">
            <label class="form__label" for="email">Email</label>
            <input type="email" class="form__input" placeholder="Your Email" id="email" name="email" value="<?php echo $user->email; ?>">
        </div>

        <div class="form__field">
            <label class="form__label" for="password">Password</label>
            <input type="password" class="form__input" placeholder="Your Password" id="password" name="password">
        </div>

        <div class="form__field">
            <label class="form__label" for="rpassword">Repeat Password</label>
            <input type="password" class="form__input" placeholder="Repeat your Password" id="rpassword" name="rpassword">
        </div>

        <input type="submit" class="form__submit" value="Create Account">
    </form>

    <div class="actions">
        <a href="/login" class="actions__link">You already have an account? Log In</a>
        <a href="/forgot-password" class="actions__link">Forgot your password?</a>
    </div>
</main>