<?php

include "config/database.php";

$pageTitle = "About | Nayishimante Samuel";

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
            Who I Am
        </span>

        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-100 to-indigo-200">
            About Me
        </h1>

        <p class="max-w-2xl mx-auto text-slate-300 text-base md:text-lg leading-relaxed">
            Developer, problem solver and technology enthusiast.
        </p>
    </div>
</section>

<!-- About Section -->
<section class="section py-16 md:py-24 bg-slate-50 min-h-screen">

    <div class="container max-w-6xl mx-auto px-6">

        <div class="about-grid grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

            <!-- Profile Image Column -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="about-image relative group w-full max-w-md">
                    <!-- Ambient Glow Behind Image -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-500"></div>
                    
                    <div class="relative rounded-2xl overflow-hidden bg-white border border-slate-200/80 shadow-lg">
                        <img 
                            src="images/title.jpg"
                            alt="Nayishimante Samuel"
                            class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-500"
                        >
                    </div>
                </div>
            </div>

            <!-- Text Content Column -->
            <div class="about-text lg:col-span-7 space-y-6">

                <span class="section-label inline-flex items-center space-x-2 text-xs font-bold tracking-widest text-indigo-600 uppercase bg-indigo-50 px-3 py-1.5 rounded-md border border-indigo-100">
                    <i class="fa-solid fa-user text-indigo-500"></i>
                    <span>About Me</span>
                </span>

                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
                    Building Digital<br class="hidden sm:inline"> Experiences
                </h2>

                <p class="text-slate-600 text-base md:text-lg leading-relaxed">
                    I am Nayishimante Samuel, a passionate Full Stack Developer interested in building useful and modern digital solutions.
                </p>

                <p class="text-slate-600 text-base leading-relaxed">
                    I work with frontend and backend technologies to create responsive websites, web applications and database-driven systems.
                </p>

                <!-- Skills Badges -->
                <div class="pt-4">
                    <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-3">Technologies & Skills</h3>
                    <div class="skills-list flex flex-wrap gap-2">
                        <span class="px-3.5 py-1.5 bg-white text-slate-800 text-sm font-medium rounded-lg border border-slate-200/80 shadow-sm hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/50 transition-colors">HTML</span>
                        <span class="px-3.5 py-1.5 bg-white text-slate-800 text-sm font-medium rounded-lg border border-slate-200/80 shadow-sm hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/50 transition-colors">CSS</span>
                        <span class="px-3.5 py-1.5 bg-white text-slate-800 text-sm font-medium rounded-lg border border-slate-200/80 shadow-sm hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/50 transition-colors">JavaScript</span>
                        <span class="px-3.5 py-1.5 bg-white text-slate-800 text-sm font-medium rounded-lg border border-slate-200/80 shadow-sm hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/50 transition-colors">PHP</span>
                        <span class="px-3.5 py-1.5 bg-white text-slate-800 text-sm font-medium rounded-lg border border-slate-200/80 shadow-sm hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/50 transition-colors">MySQL</span>
                        <span class="px-3.5 py-1.5 bg-white text-slate-800 text-sm font-medium rounded-lg border border-slate-200/80 shadow-sm hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/50 transition-colors">React</span>
                        <span class="px-3.5 py-1.5 bg-white text-slate-800 text-sm font-medium rounded-lg border border-slate-200/80 shadow-sm hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/50 transition-colors">Node.js</span>
                        <span class="px-3.5 py-1.5 bg-white text-slate-800 text-sm font-medium rounded-lg border border-slate-200/80 shadow-sm hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/50 transition-colors">Vue.js</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>

<?php include "includes/footer.php"; ?>