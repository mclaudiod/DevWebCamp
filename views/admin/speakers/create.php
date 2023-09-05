<h2 class="dashboard__heading"><?php echo $title; ?></h2>

<div class="dashboard__container-button">
    <a class="dashboard__button" href="/admin/speakers">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Return
    </a>
</div>

<div class="dashboard__form">
    <?php require_once __DIR__ . "./../../templates/alerts.php"; ?>

    <form class="form" action="/admin/speakers/create" enctype="multipart/form-data" method="POST">
        <?php require_once __DIR__ . "/form.php"; ?>

        <input class="form__submit form__submit--add" type="submit" value="Add Speaker">
    </form>
</div>