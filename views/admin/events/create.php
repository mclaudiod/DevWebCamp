<h2 class="dashboard__heading"><?php echo $title; ?></h2>

<div class="dashboard__container-button">
    <a class="dashboard__button" href="/admin/events">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Return
    </a>
</div>

<div class="dashboard__form">
    <?php require_once __DIR__ . "./../../templates/alerts.php"; ?>

    <form class="form" action="/admin/events/create" method="POST">
        <?php require_once __DIR__ . "/form.php"; ?>

        <input class="form__submit form__submit--add" type="submit" value="Add Event">
    </form>
</div>