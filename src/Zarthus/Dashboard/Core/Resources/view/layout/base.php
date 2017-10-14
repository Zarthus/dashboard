<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title><?= $this->e($title) ?></title>

    <link rel="stylesheet" href="/assets/css/<?= $layout['theme'] ?? 'bulma-slate' ?>.css" />
    <?php if ($layout['icons'] ?? false) { ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <?php } ?>
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
    <br>
    <?php } ?>

    <?= $contents ?>
</body>
</html>
