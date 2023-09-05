<div class="event">
    <p class="event__hour"><?php echo $event->hour->hour; ?></p>
    <div class="event__information">
        <h4 class="event__name"><?php echo $event->name; ?></h4>
        <p class="event__introduction"><?php echo $event->description; ?></p>
        <div class="event__speaker-info">
            <picture>
                <source srcset="<?php echo $_ENV['HOST']; ?>/img/speakers/<?php echo $event->speaker->img; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST']; ?>/img/speakers/<?php echo $event->speaker->img; ?>.png" type="image/png">
                <img class="event__speaker-img" loading="lazy" width="200" height="300" src="<?php echo $_ENV['HOST']; ?>/img/speakers/<?php echo $event->speaker->img; ?>.png" alt="Speaker Image">
            </picture>
            <p class="event__speaker-name">
                <?php echo $event->speaker->name . " " . $event->speaker->surname; ?>
            </p>
        </div>

        <button type="button" data-id="<?php echo $event->id; ?>" class="event__add" <?php echo ($event->seats === "0") ? 'disabled' : ''; ?>>
            <?php  echo ($event->seats === "0") ? 'Sold Out' : 'Add - ' .  $event->seats . ' seats left' ?>
        </button>
    </div>
</div>