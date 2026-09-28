document.addEventListener("DOMContentLoaded", () => {
    const progress = document.getElementById("scrollProgress");
    const themeToggle = document.getElementById("themeToggle");
    const updateProgress = () => {
        if (!progress) return;
        const max = document.documentElement.scrollHeight - window.innerHeight;
        progress.style.width = `${max > 0 ? (window.scrollY / max) * 100 : 0}%`;
    };
    window.addEventListener("scroll", updateProgress, { passive: true });
    updateProgress();
    if (themeToggle) {
        const savedTheme = localStorage.getItem("portfolio-theme");
        if (savedTheme === "light") document.body.classList.add("light-mode");
        themeToggle.addEventListener("click", () => {
            const light = document.body.classList.toggle("light-mode");
            localStorage.setItem("portfolio-theme", light ? "light" : "dark");
            themeToggle.setAttribute("aria-label", light ? "Switch to dark mode" : "Switch to light mode");
            themeToggle.textContent = light ? "☾" : "☼";
        });
    }

    /* ========================================
       LOADER
    ======================================== */

    const loader = document.getElementById("loadingScreen");
    const loaderDots = document.getElementById("loaderDots");

    let dots = 1;
    const loaderStartedAt = performance.now();
    const dotTimer = loaderDots ? window.setInterval(() => {
        dots = dots % 3 + 1;
        loaderDots.textContent = ".".repeat(dots);
    }, 350) : null;
    let loaderDismissed = false;

    const dismissLoader = () => {
        if (!loader || loaderDismissed) return;
        loaderDismissed = true;
        if (dotTimer !== null) window.clearInterval(dotTimer);
        const minimumDisplayTime = 550;
        const remainingTime = Math.max(0, minimumDisplayTime - (performance.now() - loaderStartedAt));
        window.setTimeout(() => {
            const loaderProgress = document.getElementById("loaderProgress");
            if (loaderProgress) loaderProgress.style.width = "100%";
            window.setTimeout(() => {
                loader.classList.add("hidden");
                window.setTimeout(() => loader.remove(), 650);
            }, 180);
        }, remainingTime);
    };

    if (loader) {
        window.addEventListener("load", dismissLoader, { once: true });
        window.setTimeout(dismissLoader, 8000);
    }


    /* ========================================
       MOBILE MENU
    ======================================== */

    const mobileToggle =
        document.getElementById("mobileToggle");

    const navLinks =
        document.getElementById("navLinks");


    if (mobileToggle && navLinks) {

        mobileToggle.addEventListener(
            "click",
            () => {

                navLinks.classList.toggle(
                    "active"
                );

                const isOpen =
                    navLinks.classList.contains(
                        "active"
                    );

                mobileToggle.setAttribute(
                    "aria-expanded",
                    isOpen
                );

            }
        );
    }

    const brand = document.querySelector(".brand[data-admin-trigger='true']");
    const adminLoginItem = document.getElementById("adminLoginItem");
    if (brand && adminLoginItem) {
        let logoClicks = 0;
        let clickResetTimer = null;

        brand.addEventListener("click", event => {
            event.preventDefault();
            if (!adminLoginItem.hidden) return;

            logoClicks += 1;
            window.clearTimeout(clickResetTimer);
            if (logoClicks >= 3) {
                adminLoginItem.hidden = false;
                logoClicks = 0;
                return;
            }

            clickResetTimer = window.setTimeout(() => {
                logoClicks = 0;
            }, 1500);
        });
    }


    /* ========================================
       TYPING EFFECT
    ======================================== */

    const typingText =
        document.getElementById("typingText");


    if (typingText) {

        const roles = [

            "Full Stack Developer",

            "PHP Developer",

            "JavaScript Developer",

            "React Developer",

            "Backend Developer",

            "Software Developer"

        ];


        let roleIndex = 0;

        let charIndex = 0;

        let deleting = false;


        function type() {

            const role =
                roles[roleIndex];


            if (!deleting) {

                typingText.textContent =
                    role.substring(
                        0,
                        charIndex + 1
                    );

                charIndex++;


                if (
                    charIndex ===
                    role.length
                ) {

                    deleting = true;

                    setTimeout(
                        type,
                        1500
                    );

                    return;

                }

            } else {

                typingText.textContent =
                    role.substring(
                        0,
                        charIndex - 1
                    );

                charIndex--;


                if (charIndex === 0) {

                    deleting = false;

                    roleIndex++;

                    if (
                        roleIndex >=
                        roles.length
                    ) {

                        roleIndex = 0;

                    }

                }

            }


            setTimeout(
                type,
                deleting ? 45 : 90
            );

        }


        type();

    }


    /* ========================================
       PARTICLES
    ======================================== */

    const particles =
        document.getElementById("particles");


    if (particles) {

        const count =
            window.innerWidth <= 700
                ? 25
                : 55;


        for (
            let i = 0;
            i < count;
            i++
        ) {

            const particle =
                document.createElement("span");


            particle.className =
                "particle";


            particle.style.left =
                Math.random() * 100 + "%";


            particle.style.top =
                Math.random() * 100 + "%";


            particle.style.animationDelay =
                Math.random() * 8 + "s";


            particle.style.animationDuration =
                5 +
                Math.random() * 8 +
                "s";


            particles.appendChild(
                particle
            );

        }

    }


    /* ========================================
       SCROLL REVEAL
    ======================================== */

    const reveals =
        document.querySelectorAll(
            ".reveal"
        );


    if (reveals.length) {

        const observer =
            new IntersectionObserver(
                entries => {

                    entries.forEach(
                        entry => {

                            if (
                                entry.isIntersecting
                            ) {

                                entry.target.classList.add(
                                    "active"
                                );

                                observer.unobserve(
                                    entry.target
                                );

                            }

                        }
                    );

                },
                {
                    threshold: 0.15
                }
            );


        reveals.forEach(element => {

            observer.observe(element);

        });

    }


    /* ========================================
       COUNTERS
    ======================================== */

    const counters =
        document.querySelectorAll(
            ".counter"
        );


    if (counters.length) {

        const counterObserver =
            new IntersectionObserver(
                entries => {

                    entries.forEach(
                        entry => {

                            if (
                                !entry.isIntersecting
                            ) {
                                return;
                            }


                            const counter =
                                entry.target;


                            const target =
                                Number(
                                    counter.dataset.target
                                );


                            let current = 0;


                            const increment =
                                Math.max(
                                    1,
                                    Math.ceil(
                                        target / 60
                                    )
                                );


                            function update() {

                                current +=
                                    increment;


                                if (
                                    current >=
                                    target
                                ) {

                                    counter.textContent =
                                        target;

                                    return;

                                }


                                counter.textContent =
                                    current;


                                requestAnimationFrame(
                                    update
                                );

                            }


                            update();


                            counterObserver.unobserve(
                                counter
                            );

                        }
                    );

                }
            );


        counters.forEach(counter => {

            counterObserver.observe(
                counter
            );

        });

    }


    /* ========================================
       NAVBAR SCROLL
    ======================================== */

    const navbar =
        document.querySelector(
            ".main-nav"
        );


    if (navbar) {

        window.addEventListener(
            "scroll",
            () => {

                if (
                    window.scrollY > 50
                ) {

                    navbar.classList.add(
                        "scrolled"
                    );

                } else {

                    navbar.classList.remove(
                        "scrolled"
                    );

                }

            },
            {
                passive: true
            }
        );

    }

});