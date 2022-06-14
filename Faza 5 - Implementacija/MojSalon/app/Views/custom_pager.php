<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" aria-label="Prva">
                    <span aria-hidden="true">Prva</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="Prethodna">
                    <span aria-hidden="true">Prethodna</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li <?= $link['active'] ? 'class="active"' : '' ?>>
                <a href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="Sledeca">
                    <span aria-hidden="true">Sledeća</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" aria-label="Poslednja">
                    <span aria-hidden="true">Poslednja</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>