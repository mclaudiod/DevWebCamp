<header class="header">
    <div class="header__container">
        <nav class="header__nav">
            <?php if(isAuth()) { ?>
                <a href="<?php echo isAdmin() ? "/admin/dashboard" : "/finish-registration"; ?>" class="header__link">Administrate</a>
                <form method="POST" action="/logout" class="header__s-form">
                    <input type="submit" value="Log Out" class="header__submit">
                </form>
            <?php } else { ?>
                <a href="/create-account" class="header__link">Create Account</a>
                <a href="/login" class="header__link">Log In</a>
            <?php } ?>
        </nav>

        <div class="header__content">
            <a href="/">
                <h1 class="header__logo">&#60;DevWebCamp/></h1>
            </a>

            <p class="header__text">October 5-6 - 2023</p>
            <p class="header__text header__text--mode">Online - Presential</p>

            <a href="/create-account" class="header__button">Purchase Pass</a>
        </div>
    </div>
</header>

<div class="bar">
    <div class="bar__content">
        <a href="/">
            <h2 class="bar__logo">&#60;DevWebCamp/></h2>
        </a>

        <nav class="nav">
            <a href="/devwebcamp" class="nav__link <?php echo currentPage("/devwebcamp") ? "nav__link--current" : ""; ?>">Event</a>
            <a href="/packages" class="nav__link <?php echo currentPage("/packages") ? "nav__link--current" : ""; ?>">Packages</a>
            <a href="/workshops-conferences" class="nav__link <?php echo currentPage("/workshops-conferences") ? "nav__link--current" : ""; ?>">Workshops / Conferences</a>
            <a href="/create-account" class="nav__link <?php echo currentPage("/create-account") ? "nav__link--current" : ""; ?>">Purchase Pass</a>
        </nav>
    </div>
</div>