<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<header class="site-header">
    <nav class="main-nav <?= $currentPage === 'index.php' ? 'home-nav' : '' ?>" id="mainNav">
        <div class="nav-container">

            <!-- BRAND / LOGO -->
            <a href="index.php" class="brand" <?= $currentPage === 'index.php' ? 'data-admin-trigger="true"' : '' ?>>
                <img src="images/logo.jpg" alt="" class="title-logo">
                <span class="brand-name">
                    <span class="brand-symbol">&lt;</span>
                    NAYISHIMANTE
                    <span class="brand-dot">.DEV</span>
                    <span class="brand-symbol">/&gt;</span>
                </span>
            </a>

            <!-- DESKTOP NAVIGATION -->
            <ul class="nav-links" id="navLinks">
                <li>
                    <a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">
                        <span class="nav-number">01</span> Home
                    </a>
                </li>
                <li>
                    <a href="index.php#about" class="<?= $currentPage === 'about.php' ? 'active' : '' ?>">
                        <span class="nav-number">02</span> About
                    </a>
                </li>
                <li>
                    <a href="index.php#projects" class="<?= $currentPage === 'projects.php' ? 'active' : '' ?>">
                        <span class="nav-number">03</span> Projects
                    </a>
                </li>
                <li>
                    <a href="index.php#services" class="<?= $currentPage === 'services.php' ? 'active' : '' ?>">
                        <span class="nav-number">04</span> Services
                    </a>
                </li>
                <li>
                    <a href="contact.php" class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>">
                        <span class="nav-number">05</span> Contact
                    </a>
                </li>
                <li id="adminLoginItem" hidden>
                    <a href="login.php" class="admin-login-link">Admin Login</a>
                </li>
            </ul>

            <!-- RIGHT ACTION AREA -->
            <div class="nav-right">
                <div class="nav-status">
                    <span class="nav-status-dot"></span>
                    ONLINE
                </div>

                <a href="contact.php" class="nav-hire">
                    Hire Me <span>→</span>
                </a>
                <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch to light mode">☼</button>
            </div>

            <!-- MOBILE TOGGLE BUTTON -->
            <button 
                class="mobile-toggle" 
                id="mobileToggle" 
                type="button" 
                aria-label="Toggle navigation menu" 
                aria-expanded="false"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </nav>
</header>