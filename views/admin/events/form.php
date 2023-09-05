<fieldset class="form__fieldset">
    <legend class="form__legend">Personal Information</legend>

    <div class="form__field">
        <label class="form__label" for="name">Event Name</label>
        <input type="text" class="form__input" id="name" name="name" placeholder="Event Name" value="<?php echo $event->name ?? ''; ?>">
    </div>

    <div class="form__field">
        <label class="form__label" for="description">Event Description</label>
        <textarea class="form__input" id="description" name="description" placeholder="Event Description" rows="8"><?php echo $event->description ?? ''; ?></textarea>
    </div>

    <div class="form__field">
        <label class="form__label" for="description">Categorie</label>
        <select class="form__select" name="categorie_id" id="categorie">
            <option value="">- Select -</option>
            <?php foreach($categories as $categorie) { ?>
                <option <?php echo ($event->categorie_id === $categorie->id) ? "selected" : ""; ?> value="<?php echo $categorie->id; ?>"><?php echo $categorie->name; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form__field">
        <label class="form__label" for="description">Select Day</label>
        <div class="form__radio">
            <?php foreach($days as $day) { ?>
                <div>
                    <label for="<?php echo strtolower($day->name); ?>"><?php echo $day->name; ?></label>
                    <input type="radio" id="<?php echo strtolower($day->name); ?>" name="day" value="<?php echo $day->id; ?>" <?php echo ($event->day_id === $day->id) ? 'checked' : ''; ?>>
                </div>
            <?php } ?>
        </div>

        <input type="hidden" name="day_id" value="<?php echo $event->day_id ?? ''; ?>">
    </div>

    <div id="hours" class="form__field">
        <label class="form__label" for="">Select Time</label>  
        
        <ul id="hours" class="hours">
            <?php foreach($hours as $hour) { ?>
                <li data-hour-id="<?php echo $hour->id; ?>" class="hours__hour hours__hour--disabled"><?php echo $hour->hour; ?></li>
            <?php } ?>
        </ul>

        <input type="hidden" name="hour_id" value="<?php echo $event->hour_id ?? ''; ?>">
    </div>
</fieldset>

<fieldset class="form__fieldset">
    <legend class="form__legen">Extra Information</legend>

    <div class="form__field">
        <label class="form__label" for="speakers">Speaker</label>
        <input type="text" class="form__input" id="speakers" placeholder="Search Speaker">
        <ul id="speakers-list" class="speakers-list"></ul>

        <input type="hidden" name="speaker_id" value="<?php echo $event->speaker_id ?? ''; ?>">
    </div>

    <div class="form__field">
        <label class="form__label" for="seats">Seats Available</label>
        <input type="number" min="1" class="form__input" id="seats" name="seats" placeholder="E.g. 20" value="<?php echo $event->seats ?? ''; ?>">
    </div>
</fieldset>