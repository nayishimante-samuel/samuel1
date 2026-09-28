<?php
if (!isset($pageTitle)) {
    $pageTitle = "Nayishimante Samuel | Full Stack Developer";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nayishimante Samuel - Full Stack Developer building modern web applications.">
    <meta name="author" content="Nayishimante Samuel">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
    <meta property="og:description" content="Nayishimante Samuel — Full Stack Developer building thoughtful digital products.">
    <meta property="og:type" content="website">

    <!-- Browser Tab Title -->
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <!-- Browser Tab Logo (Favicon) -->
    <link rel="icon" type="image/jpeg" href="images/logo.jpg">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<noscript><style>#loadingScreen{display:none!important}</style></noscript>
<div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>

<?php if (basename($_SERVER["PHP_SELF"]) === "index.php"): ?>
<div id="loadingScreen" role="status" aria-label="Loading portfolio">
    <div class="loader-wrapper">
        <div class="loader-orbit">
            <span class="loader-dot dot-1"></span>
            <span class="loader-dot dot-2"></span>
            <span class="loader-dot dot-3"></span>
            <span class="loader-dot dot-4"></span>
            <span class="loader-dot dot-5"></span>
            <span class="loader-dot dot-6"></span>
            <span class="loader-dot dot-7"></span>
            <span class="loader-dot dot-8"></span>

            <div class="loader-core">
                <img src="images/logo.jpg" alt="">
            </div>
        </div>

        <div class="loader-brand">
            NAYISHIMANTE
            <span>
                .DEV
            </span>
        </div>

        <div class="loader-status">
            <span>
                LOADING PORTFOLIO
            </span>
            <span id="loaderDots" class="loader-dots">
                ...
            </span>
        </div>
        <?php endif; ?>

        <div class="loader-progress">
            <div id="loaderProgress" class="loader-progress-bar"></div>
        </div>
    </div>
</div>