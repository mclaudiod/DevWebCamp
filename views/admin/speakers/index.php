<h2 class="dashboard__heading"><?php echo $title; ?></h2>

<div class="dashboard__container-button">
    <a class="dashboard__button" href="/admin/speakers/create">
        <i class="fa-solid fa-circle-plus"></i>
        Add Speaker
    </a>
</div>

<div class="dashboard__container">
    <?php if(!empty($speakers)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Name</th>
                    <th scope="col" class="table__th">Location</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($speakers as $speaker) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $speaker->name . " " . $speaker->surname; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $speaker->city . ", " . $speaker->country; ?>
                        </td>

                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/admin/speakers/edit?id=<?php echo $speaker->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Edit
                            </a>

                            <form class="table__form" action="/admin/speakers/delete" method="POST">
                                <input type="hidden" name="id" value="<?php echo $speaker->id; ?>">
                                <button class="table__action table__action--delete" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">There aren't any speakers yet</p>
    <?php } ?>
</div>

<?php echo $pagination; ?>