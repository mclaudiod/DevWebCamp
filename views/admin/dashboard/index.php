<h2 class="dashboard__heading"><?php echo $title; ?></h2>

<main class="blocks">
    <div class="blocks__grid">
        <div class="block">
            <h3 class="block__heading">Last Registers</h3>

            <?php foreach($registers as $register) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php echo $register->user->name . " " . $register->user->surname; ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <div class="block">
            <h3 class="block__heading">Income</h3>
            <p class="block__text--quantity">$ <?php echo $income; ?></p>
        </div>

        <div class="block">
            <h3 class="block__heading">Events with less seats left</h3>
            <?php foreach($lessSeats as $event) { ?>
                <div class="block__content">
                    <p class="block__text">
                        <?php echo $event->name . " - " . $event->seats . ' seats available'; ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <div class="block">
            <h3 class="block__heading">Events with most seats left</h3>
            <?php foreach($mostSeats as $event) { ?>
                <div class="block__contenido">
                    <p class="block__texto">
                        <?php echo $event->name . " - " . $event->seats . ' seats available'; ?>
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
</main>