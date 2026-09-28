<?php
require_once __DIR__ . "/config/database.php";
$pageTitle = "Nayishimante Samuel | Full Stack Developer";
$projects = [];
$projectResult = $conn->query("SELECT * FROM projects ORDER BY id DESC LIMIT 3");
if ($projectResult) {
    while ($project = $projectResult->fetch_assoc()) {
        $projects[] = $project;
    }
}
require_once __DIR__ . "/includes/header.php";
require_once __DIR__ . "/includes/navbar.php";
?>

<div class="home-background" aria-hidden="true"><div class="grid-background"></div><div id="particles"></div><div class="glow glow-one"></div><div class="glow glow-two"></div><div class="glow glow-three"></div></div>

<main>
    <section class="hero" id="home">
        <div class="container hero-container">
            <div class="hero-text reveal">
                <div class="developer-tag"><span class="status-dot"></span> AVAILABLE FOR PROJECTS</div>
                <span class="small-title">&lt; HELLO_WORLD /&gt;</span>
                <h1>Nayishimante <span>Samuel</span></h1>
                <h2>I'm a <span id="typingText" class="typing-text">Full Stack Developer</span><span class="typing-cursor">|</span></h2>
                <p>I build useful, accessible digital products that turn complex ideas into clear, fast and delightful experiences.</p>
                <div class="hero-buttons"><a href="#projects" class="btn btn-primary">View Projects <span>→</span></a><a href="contact.php" class="btn btn-outline">Contact Me</a><a href="#resume" class="text-link">Download CV ↓</a></div>
                <div class="hero-tech"><span>PHP</span><span>MySQL</span><span>JavaScript</span><span>React</span><span>Node.js</span></div>
            </div>
            <div class="hero-image reveal">
                <div class="profile-wrapper"><div class="profile-ring ring-one"></div><div class="profile-ring ring-two"></div><div class="profile-ring ring-three"></div><div class="profile-glow"></div><div class="image-circle"><img src="images/title.jpg" alt="Portrait of Nayishimante Samuel"></div></div>
                <div class="floating-card card-one"><span class="floating-icon">&lt;/&gt;</span><div><strong>PHP</strong><small>Backend</small></div></div>
                <div class="floating-card card-two"><span class="floating-icon">DB</span><div><strong>MySQL</strong><small>Database</small></div></div>
                <div class="floating-card card-three"><span class="floating-icon">JS</span><div><strong>React</strong><small>Frontend</small></div></div>
            </div>
        </div>
    </section>

    <section class="stats-section"><div class="container"><div class="stats-grid">
        <div class="stat-card reveal"><div class="stat-icon">🚀</div><h2><span class="counter" data-target="20">0</span>+</h2><p>Projects completed</p></div>
        <div class="stat-card reveal"><div class="stat-icon">⚡</div><h2><span class="counter" data-target="10">0</span>+</h2><p>Technologies</p></div>
        <div class="stat-card reveal"><div class="stat-icon">🌍</div><h2>Rwanda</h2><p>Based in Kigali</p></div>
        <div class="stat-card reveal"><div class="stat-icon">💡</div><h2>24/7</h2><p>Always learning</p></div>
    </div></div></section>

    <section class="portfolio-section" id="about"><div class="container split-section"><div class="section-heading align-left reveal"><span>01 / ABOUT ME</span><h2>Building with purpose, not just pixels.</h2></div><div class="about-copy reveal"><p>I’m Nayishimante Samuel, a Full Stack Developer from Kigali, Rwanda. I enjoy creating dependable web applications that make everyday work simpler.</p><p>My approach blends thoughtful UI, maintainable code and practical problem solving. I value curiosity, clear communication and shipping work that people can trust.</p><div class="detail-grid"><div><strong>Education</strong><span>Software development</span></div><div><strong>Specialization</strong><span>Web apps &amp; product UI</span></div><div><strong>Interests</strong><span>Open source, design systems</span></div><div><strong>Values</strong><span>Clarity, empathy, craft</span></div></div></div></div></section>

    <section class="portfolio-section" id="skills"><div class="container"><div class="section-heading reveal"><span>02 / CAPABILITIES</span><h2>Tools for turning ideas into products.</h2><p>A balanced toolkit across interface, backend and delivery.</p></div><div class="skills-showcase"><img class="skills-image reveal" src="images/download.jpg" alt="Web development technology icons" loading="lazy"><div class="skills-grid">
        <div class="skill-card reveal"><span class="skill-icon">⌘</span><h3>Frontend</h3><p>HTML, CSS, JavaScript, React, responsive UI</p><div class="skill-meter"><span style="width:92%"></span></div></div>
        <div class="skill-card reveal"><span class="skill-icon">{ }</span><h3>Backend</h3><p>PHP, Node.js, REST APIs, authentication</p><div class="skill-meter"><span style="width:88%"></span></div></div>
        <div class="skill-card reveal"><span class="skill-icon">▦</span><h3>Data &amp; tools</h3><p>MySQL, Git, testing, deployment workflows</p><div class="skill-meter"><span style="width:85%"></span></div></div>
        <div class="skill-card reveal"><span class="skill-icon">✦</span><h3>Product thinking</h3><p>UI design, accessibility, communication, ownership</p><div class="skill-meter"><span style="width:90%"></span></div></div>
    </div></div></div></section>

    <section class="portfolio-section projects-section" id="projects"><div class="container"><div class="section-heading reveal"><span>03 / SELECTED WORK</span><h2>Projects that solve real problems.</h2><p>Explore the systems and experiences I’ve helped bring to life.</p></div><div class="project-showcase">
        <?php if ($projects): foreach ($projects as $project): $projectImage = basename((string) ($project['image'] ?? '')); $projectImagePath = __DIR__ . "/images/" . $projectImage; if ($projectImage === '' || !is_file($projectImagePath)) { $projectImage = "profile.jpg"; } ?><article class="project-feature reveal"><div class="project-image"><img src="images/<?= htmlspecialchars($projectImage) ?>" alt="<?= htmlspecialchars($project['title']) ?>" loading="lazy"></div><div class="project-content"><span class="project-kicker">CASE STUDY · <?= htmlspecialchars($project['technologies'] ?? 'Web application') ?></span><h3><?= htmlspecialchars($project['title']) ?></h3><p><?= htmlspecialchars($project['description']) ?></p><a href="projects.php" class="text-link">View project details →</a></div></article><?php endforeach; else: ?><article class="project-feature reveal"><div class="project-image"><img src="images/profile.jpg" alt="Technology logos used in web development" loading="lazy"></div><div class="project-content"><span class="project-kicker">CASE STUDY</span><h3>Digital products with measurable impact.</h3><p>Project details will appear here once your portfolio database is populated.</p><a href="contact.php" class="text-link">Start a project →</a></div></article><?php endif; ?>
    </div><a href="projects.php" class="btn btn-outline centered-btn">View all projects →</a></div></section>

    <section class="portfolio-section" id="experience"><div class="container"><div class="section-heading reveal"><span>04 / EXPERIENCE</span><h2>A steady practice of learning and delivery.</h2></div><div class="timeline"><div class="timeline-item reveal"><span class="timeline-date">2023 — PRESENT</span><div><h3>Full Stack Developer</h3><p class="timeline-company">Independent / Client Projects</p><p>Designing and building responsive web platforms, dashboards and database-driven tools from discovery through launch.</p></div></div><div class="timeline-item reveal"><span class="timeline-date">FOUNDATION</span><div><h3>Software Development</h3><p class="timeline-company">Education &amp; continuous learning</p><p>Developing strong foundations in programming, databases, system design and modern product development.</p></div></div></div></div></section>

    <section class="portfolio-section" id="services"><div class="container"><div class="section-heading reveal"><span>05 / SERVICES</span><h2>How I can help your next idea move forward.</h2></div><div class="services-grid"><div class="service-tile reveal"><span>01</span><h3>Web development</h3><p>Fast, responsive websites and web applications built around your goals.</p></div><div class="service-tile reveal"><span>02</span><h3>UI / UX design</h3><p>Clear interfaces and thoughtful flows that feel natural to use.</p></div><div class="service-tile reveal"><span>03</span><h3>Backend &amp; data</h3><p>Secure PHP, APIs and database systems that are ready to grow.</p></div><div class="service-tile reveal"><span>04</span><h3>Consulting</h3><p>Practical technical direction, audits and implementation support.</p></div></div></div></section>

    <section class="portfolio-section testimonial-section" id="testimonials"><div class="container quote-card reveal"><span class="quote-mark">“</span><blockquote>Good software is where technical quality meets a clear understanding of people.</blockquote><p>— A principle behind every project I build</p></div></section>

    <section class="portfolio-section resume-section" id="resume"><div class="container resume-card reveal"><div><span class="section-label">06 / RESUME</span><h2>Ready to work together?</h2><p>View my experience, skills and education, then print or save it as a PDF.</p></div><a class="btn btn-primary" href="resume.php">View / Print CV ↓</a></div></section>

    <section class="home-cta" id="contact"><div class="container"><div class="cta-box reveal"><span>07 / LET’S CONNECT</span><h2>Have a project in mind?<strong> Let’s talk.</strong></h2><p>Tell me what you’re building and I’ll get back to you with the next step.</p><a href="contact.php" class="btn btn-primary">Start a conversation →</a></div></div></section>
</main>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
