<fieldset class="form__fieldset">
    <legend class="form__legend">Personal Information</legend>

    <div class="form__field">
        <label class="form__label" for="name">Name</label>
        <input type="text" class="form__input" id="name" name="name" placeholder="Speaker Name" value="<?php echo $speaker->name ?? ''; ?>">
    </div>

    <div class="form__field">
        <label class="form__label" for="surname">Surname</label>
        <input type="text" class="form__input" id="surname" name="surname" placeholder="Speaker Surname" value="<?php echo $speaker->surname ?? ''; ?>">
    </div>

    <div class="form__field">
        <label class="form__label" for="city">City</label>
        <input type="text" class="form__input" id="city" name="city" placeholder="Speaker City" value="<?php echo $speaker->city ?? ''; ?>">
    </div>

    <div class="form__field">
        <label class="form__label" for="country">Country</label>
        <input type="text" class="form__input" id="country" name="country" placeholder="Speaker Country" value="<?php echo $speaker->country ?? ''; ?>">
    </div>

    <div class="form__field">
        <label class="form__label" for="img">Image</label>
        <input type="file" class="form__input form__input--file" id="img" name="img">
    </div>

    <?php if(isset($speaker->currentImg)) { ?>
        <p class="form__text">Current Image:</p>

        <div class="form__img">
            <picture>
                <source srcset="<?php echo $_ENV["HOST"] . "/img/speakers/" . $speaker->img ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV["HOST"] . "/img/speakers/" . $speaker->img ?>.png" type="image/png">
                <img src="<?php echo $_ENV["HOST"] . "/img/speakers/" . $speaker->img ?>.png" alt="Image Speaker">
            </picture>
        </div>
    <?php } ?>
</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legend">Extra Information</legend>

    <div class="form__field">
        <label class="form__label" for="tags-input">Areas of Expertise (Separated by Commas)</label>
        <input type="text" class="form__input" id="tags-input" placeholder="E.g. Node.js, PHP, CSS, Laravel, UX / UI">
        <div id="tags" class="form__list"></div>
        <input type="hidden" name="tags" value="<?php echo $speaker->tags ?? ''; ?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legend">Social Networks</legend>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-facebook"></i>
            </div>
            <input type="text" class="form__input--socials" name="networks[facebook]" placeholder="Facebook" value="<?php echo $networks->facebook ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-twitter"></i>
            </div>
            <input type="text" class="form__input--socials" name="networks[twitter]" placeholder="Twitter" value="<?php echo $networks->twitter ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <input type="text" class="form__input--socials" name="networks[youtube]" placeholder="YouTube" value="<?php echo $networks->youtube ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-instagram"></i>
            </div>
            <input type="text" class="form__input--socials" name="networks[instagram]" placeholder="Instagram" value="<?php echo $networks->instagram ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-tiktok"></i>
            </div>
            <input type="text" class="form__input--socials" name="networks[tiktok]" placeholder="Tiktok" value="<?php echo $networks->tiktok ?? ''; ?>">
        </div>
    </div>

    <div class="form__field">
        <div class="form__container-icon">
            <div class="form__icon">
                <i class="fa-brands fa-github"></i>
            </div>
            <input type="text" class="form__input--socials" name="networks[github]" placeholder="GitHub" value="<?php echo $networks->github ?? ''; ?>">
        </div>
    </div>
</fieldset>