<?php

include "config/database.php";

$pageTitle = "Services | Nayishimante Samuel";

$result = $conn->query(
    "SELECT * FROM services ORDER BY id ASC"
);

include "includes/header.php";
include "includes/navbar.php";

?>

<!-- Include CDN assets if not already loaded in header.php -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Hero Banner Section -->
<section class="page-banner relative bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white py-20 px-6 overflow-hidden">
    <!-- Ambient Glow Effects -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container max-w-6xl mx-auto text-center relative z-10">
        <span class="inline-block px-3 py-1 text-xs font-semibold tracking-widest text-indigo-400 uppercase bg-indigo-500/10 border border-indigo-500/20 rounded-full mb-4">
            What I Do
        </span>

        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-100 to-indigo-200">
            My Services
        </h1>

        <p class="max-w-2xl mx-auto text-slate-300 text-base md:text-lg leading-relaxed">
            Technology solutions designed for modern businesses.
        </p>
    </div>
</section>

<!-- Services Grid Section -->
<section class="section py-16 bg-slate-50 min-h-screen">

    <div class="container max-w-6xl mx-auto px-6">

        <div class="service-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php while ($service = $result->fetch_assoc()): ?>

                <div class="service-card bg-white rounded-2xl p-8 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">

                    <div>
                        <!-- Icon Support for Emojis, FontAwesome, or Fallback -->
                        <div class="service-icon w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                            <?php if (!empty($service['icon'])): ?>
                                <?php if (str_starts_with(trim($service['icon']), 'fa-')): ?>
                                    <i class="<?= htmlspecialchars($service['icon']) ?>"></i>
                                <?php else: ?>
                                    <?= htmlspecialchars($service['icon']) ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <i class="fa-solid fa-cubes"></i>
                            <?php endif; ?>
                        </div>

                        <h2 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors mb-3">
                            <?= htmlspecialchars($service['title']) ?>
                        </h2>

                        <p class="text-slate-600 text-sm leading-relaxed">
                            <?= htmlspecialchars($service['description']) ?>
                        </p>
                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    </div>

</section>

<?php include "includes/footer.php"; ?>