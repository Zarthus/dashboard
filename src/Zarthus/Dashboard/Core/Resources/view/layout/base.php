<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <title><?= $this->e($title) ?></title>

        <link rel="stylesheet" href="/assets/css/<?= $layout['theme'] ?? 'bulma-slate' ?>.css" />
    </head>
    <body>
        <?php if (isset($layout['has-hero']) && $layout['has-hero']) { ?>
        <section class="hero">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        <?= $this->e($layout['title']) ?>
                    </h1>
                    <h2 class="subtitle">
                        <?= $this->e($layout['subtitle']) ?>
                    </h2>
                </div>
            </div>
        </section>
        <?php } ?>

        <?= $contents ?>
    </body>
</html>
