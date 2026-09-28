<?php

include "config/database.php";

$pageTitle = "Projects | Nayishimante Samuel";

$result = $conn->query(
    "SELECT * FROM projects ORDER BY id DESC"
);

include "includes/header.php";
include "includes/navbar.php";

?>

<!-- Include CDN assets if not already loaded in header.php -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Hero Banner Section -->
<section class="page-banner relative bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white py-20 px-6 overflow-hidden">
    <!-- Subtle Background Glow Elements -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container max-w-6xl mx-auto text-center relative z-10">
        <span class="inline-block px-3 py-1 text-xs font-semibold tracking-widest text-indigo-400 uppercase bg-indigo-500/10 border border-indigo-500/20 rounded-full mb-4">
            My Work
        </span>

        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-100 to-indigo-200">
            Featured Projects
        </h1>

        <p class="max-w-2xl mx-auto text-slate-300 text-base md:text-lg leading-relaxed">
            Some of the projects and systems I have developed.
        </p>
    </div>
</section>

<!-- Projects Grid Section -->
<section class="section py-16 bg-slate-50 min-h-screen">

    <div class="container max-w-6xl mx-auto px-6">

        <div class="project-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php while ($project = $result->fetch_assoc()): ?>

                <article class="project-card bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">

                    <div>
                        <?php
                        $projectImage = basename((string) ($project['image'] ?? ''));
                        $projectImagePath = __DIR__ . "/images/" . $projectImage;
                        if ($projectImage === '' || !is_file($projectImagePath)) {
                            $projectImage = "profile.jpg";
                        }
                        ?>
                        <?php if (!empty($projectImage)): ?>
                            <div class="relative overflow-hidden aspect-video bg-slate-100">
                                <img
                                    src="images/<?= htmlspecialchars($projectImage) ?>"
                                    alt="<?= htmlspecialchars($project['title']) ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                >
                            </div>
                        <?php else: ?>
                            <!-- Fallback Banner if no image is uploaded -->
                            <div class="w-full h-32 bg-gradient-to-br from-indigo-50 to-slate-100 flex items-center justify-center text-slate-300 border-b border-slate-100">
                                <i class="fa-solid fa-code text-4xl"></i>
                            </div>
                        <?php endif; ?>

                        <div class="project-body p-6">

                            <h2 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors mb-3">
                                <?= htmlspecialchars($project['title']) ?>
                            </h2>

                            <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-3">
                                <?= htmlspecialchars($project['description']) ?>
                            </p>

                            <!-- Technology Badges -->
                            <div class="technology mb-6">
                                <?php if (!empty($project['technologies'])): ?>
                                    <div class="flex flex-wrap gap-1.5">
                                        <?php foreach (explode(',', $project['technologies']) as $tech): ?>
                                            <span class="inline-block bg-indigo-50 text-indigo-700 border border-indigo-100 rounded-md px-2.5 py-1 text-xs font-semibold">
                                                <?= htmlspecialchars(trim($tech)) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                    <!-- Footer / Link Container -->
                    <div class="px-6 pb-6 pt-2 border-t border-slate-100/80 mt-auto">
                        <?php if (!empty($project['project_url'])): ?>

                            <a
                                href="<?= htmlspecialchars($project['project_url']) ?>"
                                class="project-link inline-flex items-center space-x-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors group/link"
                                target="_blank"
                            >
                                <span>View Project</span>
                                <i class="fa-solid fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i>
                            </a>

                        <?php endif; ?>
                    </div>

                </article>

            <?php endwhile; ?>

        </div>

    </div>

</section>

<?php include "includes/footer.php"; ?>