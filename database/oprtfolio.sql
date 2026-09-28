CREATE DATABASE IF NOT EXISTS portfolio_db;

USE portfolio_db;

-- =========================
-- USERS
-- =========================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password)
VALUES (
    'nayishimantesodique@gmail.com',
    '$2y$12$LOCIsnPx1QZNXQOsBjQk8uJV2xN7t3jcaVKAcRNIpUd3U..Lnqqp2'
);

-- =========================
-- PROJECTS
-- =========================

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255),
    technologies VARCHAR(255),
    project_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO projects
(title, description, image, technologies, project_url)
VALUES
(
    'Pharmacy Management System',
    'A web-based system for managing pharmacy stock, sales and branches.',
    'project1.jpg',
    'PHP, MySQL, HTML, CSS, JavaScript',
    '#'
),
(
    'Portfolio Website',
    'A modern responsive developer portfolio website.',
    'project2.jpg',
    'PHP, MySQL, CSS, JavaScript',
    '#'
);

-- =========================
-- SERVICES
-- =========================

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO services (title, description, icon)
VALUES
(
    'Web Development',
    'Modern and responsive websites using current web technologies.',
    '💻'
),
(
    'Backend Development',
    'Secure and scalable backend systems using PHP and MySQL.',
    '⚙️'
),
(
    'Database Design',
    'Efficient relational database design and management.',
    '🗄️'
),
(
    'UI Design',
    'Modern and responsive user interfaces for web applications.',
    '🎨'
);

-- =========================
-- SKILLS
-- =========================

CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    percentage INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO skills (name, percentage)
VALUES
('HTML', 95),
('CSS', 90),
('JavaScript', 85),
('PHP', 90),
('MySQL', 90),
('React', 80),
('Node.js', 75),
('Vue.js', 75);

-- =========================
-- MESSAGES
-- =========================

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);