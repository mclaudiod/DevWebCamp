<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $title; ?></h2>
    <p class="devwebcamp__description">Get to know the most important conference of America</p>

    <div class="devwebcamp__grid">
        <div <?php aos_animacion(); ?> class="devwebcamp__img">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img loading="lazy" width="200" height="300" src="build/img/sobre_devwebcamp.jpg" alt="Image DevWebcamp">
            </picture>
        </div>

        <div  class="devwebcamp__content">
            <p <?php aos_animacion(); ?> class="devwebcamp__text">Aliquam est elit, condimentum a justo vitae, fringilla dignissim tortor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam quis lorem eget felis dignissim dignissim. Praesent ac lorem convallis, ultrices neque quis, cursus lorem.</p>
            
            <p <?php aos_animacion(); ?> class="devwebcamp__text">Aliquam est elit, condimentum a justo vitae, fringilla dignissim tortor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam quis lorem eget felis dignissim dignissim. Praesent ac lorem convallis, ultrices neque quis, cursus lorem.</p>
        </div>
    </div>
</main>