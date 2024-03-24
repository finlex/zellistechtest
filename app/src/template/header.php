<html lang="en">
    <head>
        <?php if (true === isset($title)): ?>
            <title><?php echo $title; ?></title>
        <?php endif; ?>

        <meta charset="UTF-8">
        <link rel="stylesheet" href="/assets/normalize.css">
        <link rel="stylesheet" href="/assets/styles.css">

        <?php if (true === isset($styles)): ?>
            <?php echo $styles; ?>
        <?php endif; ?>
    </head>

    <body>