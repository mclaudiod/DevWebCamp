<h2 class="page__heading"><?php echo $title; ?></h2>
<p class="page__description">Choose up to 5 events to attend in person.</p>

<div class="events-register">
    <main class="events-register__list">
        <h3 class="events-register__heading--conferences">&lt;Conferences/></h3>
        <p class="events-register__date">Friday October 6th</p>

        <div class="events-register__grid">
            <?php foreach($events['conferences_f'] as $event ) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <p class="events-register__date">Saturday October 7th</p>
        <div class="events-register__grid">
            <?php foreach($events['conferences_s'] as $event ) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <h3 class="events-register__heading--workshops">&lt;Workshops/></h3>
        <p class="events-register__date">Friday October 6th</p>

        <div class="events-register__grid events--workshops">
            <?php foreach($events['workshops_f'] as $event ) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

        <p class="events-register__date">Saturday October 7th</p>
        <div class="events-register__grid events--workshops">
            <?php foreach($events['workshops_s'] as $event ) { ?>
                <?php include __DIR__ . '/event.php'; ?>
            <?php } ?>
        </div>

    </main>

    <aside class="register-pay">
        <h2 class="register-pay__heading">Your registration</h2>

        <div id="register-summary" class="register-pay__summary"></div>

        <div class="register-pay__gift">
            <label for="gift" class="register-pay__label">Choose a gift</label>
            <select id="gift" class="register-pay__select">
                <option value="">-- Choose your gift --</option>
                <?php foreach($gifts as $gift) { ?>
                    <option value="<?php echo $gift->id; ?>"><?php echo $gift->name; ?></option>
                <?php } ?>
            </select>
        </div>

        <form id="register" class="form">
            <div class="form__field">
                <input type="submit" class="form__submit form__submit--full" value="Sign Up">
            </div>
        </form>
    </aside>
</div>