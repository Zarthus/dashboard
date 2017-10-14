<nav class="panel">
    <?php if (isset($heading)) { ?>
        <p class="panel-heading">
            <?= $heading ?>
        </p>
    <?php } ?>

    <?php $useIcons = isset($icons) && $icons; ?>
    <?php foreach ($items ?? ['No items'] as $panelItem) { ?>
        <a class="panel-block <?= $panelItem['classes'] ?? '' ?>" href="<?= $panelItem['href'] ?>" target="_blank">
            <?php if ($useIcons && isset($panelItem['icon'])) { ?>
                <span class="panel-icon">
                <i class="fa fa-<?= $panelItem['icon'] ?>"></i>
            </span>
            <?php } ?>
            <?= $panelItem['name'] ?>
        </a>
    <?php } ?>
</nav>
