<?php include_once __DIR__ . "/conferences.php"; ?>

<section class="summary">
    <div class="summary__grid">
        <div <?php aos_animacion(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $speakersTotal; ?></p>
            <p class="summary__text">Speakers</p>
        </div>

        <div <?php aos_animacion(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $conferences; ?></p>
            <p class="summary__text">Conferences</p>
        </div>

        <div <?php aos_animacion(); ?> class="summary__block">
            <p class="summary__text summary__text--number"><?php echo $workshops; ?></p>
            <p class="summary__text">Workshops</p>
        </div>

        <div <?php aos_animacion(); ?> class="summary__block">
            <p class="summary__text summary__text--number">500</p>
            <p class="summary__text">Attendees</p>
        </div>
    </div>
</section>

<section class="speakers">
    <h2 class="speakers__heading">Speakers</h2>
    <p class="speakers__description">Get to know our experts here at DevWebCamp</p>

    <div class="speakers__grid">
        <?php foreach($speakers as $speaker) { ?>
            <div <?php aos_animacion(); ?> class="speaker">
                <picture>
                    <source srcset="img/speakers/<?php echo $speaker->img; ?>.webp" type="image/webp">
                    <source srcset="img/speakers/<?php echo $speaker->img; ?>.png" type="image/png">
                    <img class="speaker__img" loading="lazy" width="200" height="300" src="img/speakers/<?php echo $speaker->img; ?>.png" alt="Image Speaker">
                </picture>

                <div class="speaker__information">
                    <h4 class="speaker__name">
                        <?php echo $speaker->name . ' ' . $speaker->surname; ?>
                    </h4>

                    <p class="speaker__location">
                        <?php echo $speaker->city . ', ' . $speaker->country; ?>
                    </p>

                    <nav class="speaker-networks">
                        <?php $networks = json_decode($speaker->networks); ?>
                        
                        <?php if(!empty($networks->facebook)) { ?>
                            <a class="speaker-networks__link" rel="noopener noreferrer" target="_blank" href="<?php echo $networks->facebook; ?>">
                                <span class="speaker-networks__hide">Facebook</span>
                            </a> 
                        <?php } ?>

                        <?php if(!empty($networks->twitter)) { ?>
                            <a class="speaker-networks__link" rel="noopener noreferrer" target="_blank" href="<?php echo $networks->twitter; ?>">
                                <span class="speaker-networks__hide">Twitter</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($networks->youtube)) { ?>
                            <a class="speaker-networks__link" rel="noopener noreferrer" target="_blank" href="<?php echo $networks->youtube; ?>">
                                <span class="speaker-networks__hide">YouTube</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($networks->instagram)) { ?>
                            <a class="speaker-networks__link" rel="noopener noreferrer" target="_blank" href="<?php echo $networks->instagram; ?>">
                                <span class="speaker-networks__hide">Instagram</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($networks->tiktok)) { ?>
                            <a class="speaker-networks__link" rel="noopener noreferrer" target="_blank" href="<?php echo $networks->tiktok; ?>">
                                <span class="speaker-networks__hide">Tiktok</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($networks->github)) { ?>
                            <a class="speaker-networks__link" rel="noopener noreferrer" target="_blank" href="<?php echo $networks->github; ?>">
                                <span class="speaker-networks__hide">Github</span>
                            </a>
                        <?php } ?> 
                    </nav>

                    <ul class="speaker__list-skills">
                        <?php $tags = explode(',', $speaker->tags);
                        foreach($tags as $tag) { ?>
                            <li class="speaker__skill"><?php echo $tag; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<div id="map" class="map"></div>

<section class="tickets">
    <h2 class="tickets__heading">Tickets and Prices</h2>
    <p class="tickets__description">Prices for DevWebCamp</p>

    <div class="tickets__grid">
        <div <?php aos_animacion(); ?> class="ticket ticket--presential">
            <h4 class="ticket__logo">&#60;DevWebCamp/></h4>
            <p class="ticket__plan">Presential</p>
            <p class="ticket__price">$199</p>
        </div>

        <div <?php aos_animacion(); ?> class="ticket ticket--virtual">
            <h4 class="ticket__logo">&#60;DevWebCamp/></h4>
            <p class="ticket__plan">Virtual</p>
            <p class="ticket__price">$49</p>
        </div>

        <div <?php aos_animacion(); ?> class="ticket ticket--free">
            <h4 class="ticket__logo">&#60;DevWebCamp/></h4>
            <p class="ticket__plan">Free</p>
            <p class="ticket__price">Free - $0</p>
        </div>
    </div>

    <div class="ticket__link-container">
        <a href="/packages" class="ticket__link">See Packages</a>
    </div>
</section>