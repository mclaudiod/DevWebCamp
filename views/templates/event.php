<div class="event swiper-slide">
    <p class="event__hour"><?php echo $event->hour->hour; ?></p>

    <div class="event__information">
        <h4 class="event__name"><?php echo $event->name; ?></h4>
        <p class="event__introduction"><?php echo $event->description; ?></p>

        <div class="event__speaker-info">
            <picture>
                <source srcset="<?php echo $_ENV["HOST"] . "/img/speakers/" . $event->speaker->img ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV["HOST"] . "/img/speakers/" . $event->speaker->img ?>.png" type="image/png">
                <img class="event__speaker-img" loading="lazy" width="200" height="300" src="<?php echo $_ENV["HOST"] . "/img/speakers/" . $event->speaker->img ?>.png" alt="Image Speaker">
            </picture>

            <p class="event__speaker-name"><?php echo $event->speaker->name . " " . $event->speaker->surname; ?></p>
        </div>
    </div>
</div>