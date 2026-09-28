<?php

include "../includes/auth.php";
include "../config/database.php";

$projects = $conn->query(
    "SELECT COUNT(*) AS total FROM projects"
)->fetch_assoc()['total'];

$services = $conn->query(
    "SELECT COUNT(*) AS total FROM services"
)->fetch_assoc()['total'];

$messages = $conn->query(
    "SELECT COUNT(*) AS total FROM messages"
)->fetch_assoc()['total'];

$recentProjects = $conn->query(
    "SELECT title, created_at FROM projects ORDER BY created_at DESC LIMIT 3"
);
$recentServices = $conn->query(
    "SELECT title, created_at FROM services ORDER BY created_at DESC LIMIT 3"
);
$recentMessages = $conn->query(
    "SELECT name, subject, created_at FROM messages ORDER BY created_at DESC LIMIT 3"
);

$contentTotal = (int) $projects + (int) $services + (int) $messages;
$engagementPercent = $contentTotal > 0
    ? (int) round(((int) $messages / $contentTotal) * 100)
    : 0;
$engagementPercent = min(100, max(0, $engagementPercent));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sodique Portfolio Admin Dashboard">

    <title>Dashboard | Sodique Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Admin styling -->
    <link rel="stylesheet" href="../css/admin.css">

    <style>
        :root {
            --bg-dark: #090d16;
            --bg-card: rgba(18, 26, 43, 0.65);
            --bg-card-hover: rgba(28, 39, 64, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --border-highlight: rgba(99, 102, 241, 0.3);
            
            --primary: #6366f1;
            --primary-glow: rgba(99, 102, 241, 0.25);
            --accent-cyan: #06b6d4;
            --accent-green: #10b981;
            --accent-gold: #fbbf24;
            
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --text-dim: #6b7280;
            
            --sidebar-width: 280px;
            --topbar-height: 72px;
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --transition-fast: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-smooth: 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        body.theme-light {
            --bg-dark: #edf2ff;
            --bg-card: rgba(255, 255, 255, 0.82);
            --bg-card-hover: rgba(255, 255, 255, 0.96);
            --border-color: rgba(99, 102, 241, 0.12);
            --border-highlight: rgba(99, 102, 241, 0.25);
            --primary: #4f46e5;
            --primary-glow: rgba(79, 70, 229, 0.14);
            --accent-cyan: #0891b2;
            --accent-green: #16a34a;
            --accent-gold: #d97706;
            --text-main: #0f172a;
            --text-muted: #475569;
            --text-dim: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.admin-page {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Background */
        .admin-background {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .admin-grid {
            position: absolute;
            inset: 0;
            background-image: 
                radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.6;
        }

        .admin-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.25;
            animation: floatGlow 20s ease-in-out infinite alternate;
        }

        .glow-one {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: #4f46e5;
        }

        .glow-two {
            bottom: -15%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: #06b6d4;
        }

        .glow-three {
            top: 40%;
            left: 35%;
            width: 350px;
            height: 350px;
            background: #8b5cf6;
            opacity: 0.15;
        }

        @keyframes floatGlow {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(30px, -20px) scale(1.08); }
            100% { transform: translate(-20px, 30px) scale(0.95); }
        }

        /* Layout Structure */
        .admin-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Overlay */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(4, 7, 13, 0.8);
            backdrop-filter: blur(8px);
            z-index: 40;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-smooth);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.96) 0%, rgba(17, 24, 39, 0.96) 100%);
            backdrop-filter: blur(16px);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            padding: 1.5rem 1.25rem;
            transition: transform var(--transition-smooth);
            box-shadow: inset -1px 0 0 rgba(255,255,255,0.04);
        }

        body.theme-light .sidebar {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(241, 245, 249, 0.98) 100%);
            box-shadow: 10px 0 30px rgba(15, 23, 42, 0.08);
        }

        .sidebar-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .admin-logo {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            text-decoration: none;
            color: #fff;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: 0.5px;
        }

        .logo-symbol {
            color: var(--primary);
            font-weight: 800;
        }

        .logo-dot {
            color: var(--accent-cyan);
            font-size: 0.85rem;
        }

        .sidebar-close {
            display: none;
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.25rem;
            line-height: 1;
            transition: color var(--transition-fast);
        }

        .sidebar-close:hover {
            color: #fff;
        }

        /* Profile Widget */
        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            padding: 0.85rem 1rem;
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
            position: relative;
        }

        .profile-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent-cyan));
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 0 12px var(--primary-glow);
        }

        .sidebar-profile strong {
            display: block;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .sidebar-profile span {
            display: block;
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        .online-dot {
            width: 8px;
            height: 8px;
            background: var(--accent-green);
            border-radius: 50%;
            margin-left: auto;
            box-shadow: 0 0 8px var(--accent-green);
        }

        /* Nav Sections */
        .sidebar-section {
            margin-bottom: 1.75rem;
        }

        .sidebar-label {
            display: block;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-dim);
            font-size: 1rem;
            font-weight: 700;
        }

            letter-spacing: 0.02em;
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.8rem 0.9rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 700;
            border-radius: var(--radius-sm);
            transition: all var(--transition-fast);
            letter-spacing: 0.02em;
        }

        .sidebar-nav a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-nav a.active {
            color: #fff;
            background: linear-gradient(90deg, rgba(6, 182, 212, 0.3), rgba(6, 182, 212, 0.04));
            border-left: 4px solid #06b6d4;
        }

        body.theme-light .sidebar-nav a,
        body.theme-light .sidebar-label,
        body.theme-light .admin-logo,
        body.theme-light .sidebar-profile strong {
            color: #1e293b;
        }

        body.theme-light .sidebar-nav a.active {
            color: #083344;
        }

        body.theme-light .sidebar-profile,
        body.theme-light .sidebar-nav a:hover {
            background: rgba(6, 182, 212, 0.08);
        }

        body.theme-light .dashboard-header h1,
        body.theme-light .section-heading h2,
        body.theme-light .dashboard-card h2.counter,
        body.theme-light .quick-card strong,
        body.theme-light .system-content h3,
        body.theme-light .user-details strong {
            color: #0f172a;
        }

        body.theme-light .quick-card,
        body.theme-light .dashboard-card,
        body.theme-light .chart-card,
        body.theme-light .ring-card,
        body.theme-light .activity-card,
        body.theme-light .search-panel,
        body.theme-light .settings-panel {
            color: #0f172a;
        }

        body.theme-light .dashboard-time,
        body.theme-light .stat-chip {
            background: rgba(255, 255, 255, 0.82);
        }

        .nav-icon {
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            width: 20px;
            color: var(--text-muted);
            transition: color var(--transition-fast);
        }

        .sidebar-nav a.active .nav-icon,
        .sidebar-nav a:hover .nav-icon {
            color: var(--primary);
        }

        .nav-badge {
            margin-left: auto;
            background: var(--primary);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            box-shadow: 0 0 10px var(--primary-glow);
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .logout-link {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.75rem 0.85rem;
            color: #ef4444;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: var(--radius-sm);
            transition: background var(--transition-fast);
        }

        .logout-link:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        /* Main Content Container */
        .admin-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem 2.5rem;
            max-width: 1400px;
            width: calc(100% - var(--sidebar-width));
        }

        /* Topbar Header */
        .admin-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: var(--topbar-height);
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1rem;
        }

        .mobile-menu {
            display: none;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            padding: 0.6rem;
            border-radius: var(--radius-sm);
            cursor: pointer;
            flex-direction: column;
            gap: 4px;
            width: 40px;
            height: 40px;
            justify-content: center;
            align-items: center;
        }

        .mobile-menu span {
            display: block;
            width: 18px;
            height: 2px;
            background-color: var(--text-main);
            border-radius: 2px;
        }

        .system-indicator {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            color: var(--accent-green);
            padding: 0.4rem 0.85rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .system-dot {
            width: 6px;
            height: 6px;
            background: var(--accent-green);
            border-radius: 50%;
            box-shadow: 0 0 6px var(--accent-green);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.4; }
            100% { opacity: 1; }
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-color);
            display: grid;
            place-items: center;
            font-weight: 700;
            color: #fff;
        }

        .user-details strong {
            display: block;
            font-size: 0.9rem;
            color: #fff;
            line-height: 1.2;
        }

        .user-details span {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Dashboard Page Header */
        .dashboard-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;

        .dashboard-tools {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .search-panel,
        .settings-panel {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-height: 62px;
            padding: 0.75rem 1rem;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
        }

        .search-box {
            position: relative;
            flex: 1;
        }

        .search-box i {
            position: absolute;
            top: 50%;
            left: 0.75rem;
            transform: translateY(-50%);
            color: var(--text-dim);
        }

        .search-box input,
        .settings-select {
            width: 100%;
            min-height: 42px;
            border: 1px solid var(--border-color);
            border-radius: 9px;
            background: rgba(15, 23, 42, 0.25);
            color: var(--text-main);
            font: inherit;
            padding: 0.6rem 0.75rem 0.6rem 2.2rem;
            outline: none;
        }

        .search-box input:focus,
        .settings-select:focus {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.12);
        }

        .settings-panel > i {
            color: var(--accent-cyan);
        }

        .settings-select {
            width: 150px;
            padding-left: 0.75rem;
        }

        .search-hidden {
            display: none !important;
        }
            margin-bottom: 2.5rem;
            gap: 1.5rem;
        }

        .page-eyebrow {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: var(--primary);
            text-transform: uppercase;
            margin-bottom: 0.35rem;
        }

        .dashboard-header h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.25rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .dashboard-tools {
            display: grid;
            grid-template-columns: 1.5fr 0.9fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .search-panel,
        .settings-panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1rem 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            backdrop-filter: blur(12px);
        }

        .search-box {
            position: relative;
            flex: 1;
        }

        .search-box i,
        .settings-panel i {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
        }

        .search-box input,
        .settings-select {
            width: 100%;
            background: rgba(15, 23, 42, 0.04);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-main);
            padding: 0.8rem 0.9rem 0.8rem 2.5rem;
            font-size: 0.92rem;
            outline: none;
        }

        .settings-panel {
            justify-content: space-between;
        }

        .settings-select {
            width: 140px;
            padding-left: 0.85rem;
            background: rgba(255,255,255,0.04);
        }

        .dashboard-time {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 0.75rem 1.25rem;
            border-radius: var(--radius-md);
            text-align: right;
            backdrop-filter: blur(10px);
        }

        .time-label {
            display: block;
            font-size: 0.68rem;
            color: var(--text-dim);
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 0.15rem;
        }

        .dashboard-time strong {
            color: var(--accent-cyan);
            font-size: 0.95rem;
            letter-spacing: 1px;
        }

        /* Main Dashboard Card Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .dashboard-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            backdrop-filter: blur(12px);
            position: relative;
            overflow: hidden;
            transition: all var(--transition-smooth);
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0;
            transition: opacity var(--transition-smooth);
        }

        .dashboard-card:hover {
            background: var(--bg-card-hover);
            transform: translateY(-4px);
            border-color: var(--border-highlight);
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
        }

        .dashboard-card:hover::before {
            opacity: 1;
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .card-icon {
            width: 46px;
            height: 46px;
            border-radius: var(--radius-md);
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
            display: grid;
            place-items: center;
            font-size: 1.25rem;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .card-status {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 0.65rem;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        .card-content {
            margin-bottom: 1.5rem;
        }

        .card-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
        }

        .dashboard-card h2.counter {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.75rem;
            font-weight: 700;
            color: #fff;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .card-content p {
            font-size: 0.85rem;
            color: var(--text-dim);
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--primary);
            font-size: 0.88rem;
            font-weight: 600;
            transition: gap var(--transition-fast);
        }

        .card-link span {
            transition: transform var(--transition-fast);
        }

        .card-link:hover {
            color: #fff;
        }

        .card-link:hover span {
            transform: translateX(4px);
        }

        /* Quick Actions Section */
        .dashboard-section {
            margin-bottom: 2.5rem;
        }

        .section-heading {
            margin-bottom: 1.25rem;
        }

        .section-heading span {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-dim);
            letter-spacing: 1.2px;
            margin-bottom: 0.25rem;
        }

        .section-heading h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.35rem;
            color: #fff;
            font-weight: 600;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
        }

        .quick-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 1.25rem;
            text-decoration: none;
            color: var(--text-main);
            transition: all var(--transition-smooth);
            backdrop-filter: blur(8px);
        }

        .quick-card:hover {
            background: var(--bg-card-hover);
            border-color: var(--border-highlight);
            transform: translateY(-2px);
        }

        .quick-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            color: #fff;
            flex-shrink: 0;
            transition: background var(--transition-fast);
        }

        .quick-card:hover .quick-icon {
            background: var(--primary);
        }

        .quick-card strong {
            display: block;
            color: #fff;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.15rem;
        }

        .quick-card span {
            display: block;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .quick-arrow {
            margin-left: auto;
            color: var(--text-dim);
            font-size: 1.1rem;
            transition: transform var(--transition-fast), color var(--transition-fast);
        }

        .quick-card:hover .quick-arrow {
            transform: translateX(4px);
            color: #fff;
        }

        /* System Info Banner Panel */
        .analytics-panel {
            display: grid;
            grid-template-columns: 1.4fr 0.8fr;
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .chart-card,
        .ring-card,
        .activity-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1.35rem;
            backdrop-filter: blur(12px);
        }

        .chart-header,
        .ring-header,
        .activity-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .chart-header h3,
        .ring-header h3,
        .activity-header h3 {
            margin: 0;
            color: var(--text-main);
            font-size: 1rem;
            font-weight: 700;
        }

        .mini-badge {
            background: rgba(99, 102, 241, 0.12);
            border: 1px solid rgba(99, 102, 241, 0.2);
            color: var(--primary);
            border-radius: 999px;
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .chart-bars {
            display: flex;
            align-items: end;
            gap: 0.75rem;
            height: 180px;
            padding-top: 0.5rem;
        }

        .chart-bars span {
            display: flex;
            align-items: end;
            justify-content: center;
            width: 100%;
            min-height: 40px;
            border-radius: 12px 12px 0 0;
            background: linear-gradient(180deg, rgba(96, 165, 250, 0.95), rgba(99, 102, 241, 0.8));
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
            position: relative;
        }

        .chart-bars span[data-value]::before {
            content: attr(data-value);
            position: absolute;
            top: -1.3rem;
            color: var(--text-muted);
            font-size: 0.65rem;
        }

        .chart-bars span[data-value]::before {
            content: attr(data-value);
            position: absolute;
            top: -1.3rem;
            font-size: 0.65rem;
            color: var(--text-muted);
        }

        .chart-bars span::after {
            content: attr(data-label);
            position: absolute;
            bottom: -1.7rem;
            font-size: 0.65rem;
            color: var(--text-dim);
        }

        .ring-wrap {
            display: grid;
            place-items: center;
            margin-top: 0.5rem;
        }

        .ring {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: conic-gradient(var(--primary) 0 0%, rgba(148,163,184,0.18) 0% 100%);
            display: grid;
            place-items: center;
            position: relative;
        }

        .ring::before {
            content: "";
            position: absolute;
            inset: 16px;
            border-radius: 50%;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
        }

        .ring strong {
            position: absolute;
            font-size: 1.3rem;
            color: var(--text-main);
            z-index: 1;
        }

        .ring-legend {
            display: grid;
            gap: 0.7rem;
            margin-top: 1rem;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .legend-left {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        .activity-list {
            list-style: none;
            display: grid;
            gap: 0.8rem;
            margin: 0;
            padding: 0;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.9rem 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            background: rgba(255,255,255,0.02);
            transition: all 0.2s ease;
        }

        .activity-item.hidden {
            display: none;
        }

        .activity-empty {
            display: none;
            color: var(--text-muted);
            padding: 1rem 0.25rem;
            font-size: 0.9rem;
        }

        .activity-empty.visible {
            display: block;
        }

        .activity-main {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: rgba(99, 102, 241, 0.12);
            color: var(--primary);
            font-weight: 700;
        }

        .activity-main strong {
            display: block;
            color: var(--text-main);
            font-size: 0.9rem;
        }

        .activity-main span {
            display: block;
            color: var(--text-muted);
            font-size: 0.73rem;
        }

        .activity-pill {
            background: rgba(16, 185, 129, 0.12);
            color: var(--accent-green);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 999px;
            padding: 0.3rem 0.6rem;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .activity-pill.pending {
            background: rgba(251, 191, 36, 0.12);
            color: var(--accent-gold);
            border-color: rgba(251, 191, 36, 0.2);
        }

        .activity-pill.info {
            background: rgba(6, 182, 212, 0.12);
            color: var(--accent-cyan);
            border-color: rgba(6, 182, 212, 0.2);
        }

        .system-panel {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.12), rgba(6, 182, 212, 0.08));
            border: 1px solid rgba(99, 102, 241, 0.25);
            border-radius: var(--radius-lg);
            padding: 1.75rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 3rem;
            backdrop-filter: blur(10px);
        }

        .system-icon {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-md);
            background: rgba(99, 102, 241, 0.2);
            color: var(--primary);
            display: grid;
            place-items: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .system-content span {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .system-content h3 {
            color: #fff;
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 0.35rem;
        }

        .system-content p {
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        .system-status {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(16, 185, 129, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            border: 1px solid rgba(16, 185, 129, 0.3);
            flex-shrink: 0;
        }

        .status-circle {
            width: 8px;
            height: 8px;
            background: var(--accent-green);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--accent-green);
        }

        .system-status strong {
            color: var(--accent-green);
            font-size: 0.75rem;
            letter-spacing: 1px;
        }

        /* Footer */
        .admin-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid var(--border-color);
            padding-top: 1.5rem;
            color: var(--text-dim);
            font-size: 0.82rem;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .admin-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 868px) {
            .dashboard-tools,
            .analytics-panel {
                grid-template-columns: 1fr;
            }

            .settings-panel {
                justify-content: flex-start;
                flex-wrap: wrap;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-close {
                display: block;
            }

            .admin-content {
                margin-left: 0;
                width: 100%;
                padding: 1.25rem;
            }

            .mobile-menu {
                display: flex;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .dashboard-time {
                text-align: left;
                width: 100%;
            }

            .system-panel {
                flex-direction: column;
                align-items: flex-start;
            }

            .system-status {
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="admin-page">

<div class="admin-background">
    <div class="admin-grid"></div>
    <div class="admin-glow glow-one"></div>
    <div class="admin-glow glow-two"></div>
    <div class="admin-glow glow-three"></div>
</div>

<div class="admin-layout">

    <!-- MOBILE OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="adminSidebar">

        <div class="sidebar-top">
            <a href="index.php" class="admin-logo">
                <span class="logo-symbol">&lt;</span>
                SODIQUE
                <span class="logo-dot">.DEV</span>
                <span class="logo-symbol">/&gt;</span>
            </a>

            <button class="sidebar-close" id="sidebarClose" type="button" aria-label="Close sidebar">
                ×
            </button>
        </div>

        <div class="sidebar-profile">
            <div class="profile-avatar">
                S
            </div>
            <div>
                <strong>Sodique</strong>
                <span>Administrator</span>
            </div>
            <span class="online-dot"></span>
        </div>

        <div class="sidebar-section">
            <span class="sidebar-label">MAIN MENU</span>
            <nav class="sidebar-nav">
                <a href="index.php" class="active">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    </span>
                    <span>Dashboard</span>
                </a>

                <a href="projects.php">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    </span>
                    <span>Projects</span>
                </a>

                <a href="services.php">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 8v4l3 3"></path></svg>
                    </span>
                    <span>Services</span>
                </a>

                <a href="messages.php">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </span>
                    <span>Messages</span>
                    <?php if ($messages > 0): ?>
                        <span class="nav-badge"><?= $messages ?></span>
                    <?php endif; ?>
                </a>

                <a href="#settings-panel">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    </span>
                    <span>Settings</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-section">
            <span class="sidebar-label">WEBSITE</span>
            <nav class="sidebar-nav">
                <a href="../index.php">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                    </span>
                    <span>View Website</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <a href="../logout.php" class="logout-link">
                <span class="nav-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </span>
                <span>Logout</span>
            </a>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-content">

        <!-- TOP BAR -->
        <header class="admin-topbar">
            <button class="mobile-menu" id="mobileMenu" type="button" aria-label="Open navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="topbar-left">
                <span class="system-indicator">
                    <span class="system-dot"></span>
                    SYSTEM ONLINE
                </span>
            </div>

            <div class="topbar-right" style="display: flex; align-items: center; gap: 0.75rem;">
                <button id="themeToggle" type="button" class="theme-toggle" aria-label="Toggle theme" style="background: rgba(255,255,255,0.04); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 999px; width: 42px; height: 42px; cursor: pointer; display: grid; place-items: center;">
                    <i class="fa-solid fa-moon"></i>
                </button>
                <div class="admin-user">
                    <div class="user-avatar">
                        S
                    </div>
                    <div class="user-details">
                        <strong><?= htmlspecialchars($_SESSION['admin_username']) ?></strong>
                        <span>Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE HEADER -->
        <section class="dashboard-header">
            <div>
                <span class="page-eyebrow">ADMIN CONTROL CENTER</span>
                <h1>Dashboard</h1>
                <p>Manage your portfolio content, services and incoming messages.</p>
            </div>

            <div class="dashboard-time">
                <span class="time-label">SYSTEM STATUS</span>
                <strong id="liveStatusText">ACTIVE</strong>
                <div id="liveClock" style="margin-top: 0.35rem; font-size: 0.8rem; color: #a5b4fc; letter-spacing: 0.08em;">--:--:--</div>
            </div>
        </section>

        <section id="settings-panel" class="dashboard-tools">
            <div class="search-panel">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input id="adminSearch" type="search" placeholder="Search projects, services, messages..." aria-label="Search dashboard content">
                </div>
            </div>

            <div class="settings-panel">
                <i class="fa-solid fa-sliders" style="position: static; transform: none;"></i>
                <select id="contentFilter" class="settings-select" aria-label="Filter content type">
                    <option value="all">All content</option>
                    <option value="project">Projects</option>
                    <option value="service">Services</option>
                    <option value="message">Messages</option>
                </select>
            </div>
        </section>

        <section class="analytics-panel">
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Portfolio Content</h3>
                    <span class="mini-badge">Current totals</span>
                </div>
                <div class="chart-bars">
                    <span data-label="Projects" data-value="<?= (int) $projects ?>" style="height: <?= max(8, $contentTotal ? (int) round($projects / $contentTotal * 100) : 8) ?>%"></span>
                    <span data-label="Services" data-value="<?= (int) $services ?>" style="height: <?= max(8, $contentTotal ? (int) round($services / $contentTotal * 100) : 8) ?>%"></span>
                    <span data-label="Messages" data-value="<?= (int) $messages ?>" style="height: <?= max(8, $contentTotal ? (int) round($messages / $contentTotal * 100) : 8) ?>%"></span>
                </div>
            </div>

            <div class="ring-card">
                <div class="ring-header">
                    <h3>Message Share</h3>
                    <span class="mini-badge"><?= $engagementPercent ?>%</span>
                </div>
                <div class="ring-wrap">
                    <div class="ring" style="background: conic-gradient(var(--primary) 0 <?= $engagementPercent ?>%, rgba(148,163,184,0.18) <?= $engagementPercent ?>% 100%);"><strong><?= $engagementPercent ?>%</strong></div>
                </div>
                <div class="ring-legend">
                    <div class="legend-item">
                        <span class="legend-left"><span class="legend-dot" style="background: var(--primary);"></span>Messages</span>
                        <strong><?= (int) $messages ?></strong>
                    </div>
                    <div class="legend-item">
                        <span class="legend-left"><span class="legend-dot" style="background: rgba(148,163,184,0.35);"></span>Other content</span>
                        <strong><?= (int) $projects + (int) $services ?></strong>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATISTICS -->
        <section class="dashboard-grid">

            <!-- PROJECTS -->
            <article class="dashboard-card projects-card">
                <div class="card-top">
                    <div class="card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    </div>
                    <span class="card-status">ACTIVE</span>
                </div>

                <div class="card-content">
                    <span class="card-label">TOTAL PROJECTS</span>
                    <h2 class="counter" data-target="<?= $projects ?>">0</h2>
                    <p>Projects available in your portfolio.</p>
                </div>

                <a href="projects.php" class="card-link">
                    Manage Projects
                    <span>→</span>
                </a>
            </article>

            <!-- SERVICES -->
            <article class="dashboard-card services-card">
                <div class="card-top">
                    <div class="card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    </div>
                    <span class="card-status">ACTIVE</span>
                </div>

                <div class="card-content">
                    <span class="card-label">TOTAL SERVICES</span>
                    <h2 class="counter" data-target="<?= $services ?>">0</h2>
                    <p>Services currently offered to clients.</p>
                </div>

                <a href="services.php" class="card-link">
                    Manage Services
                    <span>→</span>
                </a>
            </article>

            <!-- MESSAGES -->
            <article class="dashboard-card messages-card">
                <div class="card-top">
                    <div class="card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <span class="card-status">INBOX</span>
                </div>

                <div class="card-content">
                    <span class="card-label">TOTAL MESSAGES</span>
                    <h2 class="counter" data-target="<?= $messages ?>">0</h2>
                    <p>Messages received from website visitors.</p>
                </div>

                <a href="messages.php" class="card-link">
                    View Messages
                    <span>→</span>
                </a>
            </article>

        </section>

        <!-- QUICK ACTIONS -->
        <section class="dashboard-section">
            <div class="section-heading">
                <div>
                    <span>QUICK ACTIONS</span>
                    <h2>Manage Your Portfolio</h2>
                </div>
            </div>

            <div class="quick-actions">

                <a href="projects.php" class="quick-card">
                    <div class="quick-icon">+</div>
                    <div>
                        <strong>Projects</strong>
                        <span>Add or manage projects</span>
                    </div>
                    <span class="quick-arrow">→</span>
                </a>

                <a href="services.php" class="quick-card">
                    <div class="quick-icon">+</div>
                    <div>
                        <strong>Services</strong>
                        <span>Manage your services</span>
                    </div>
                    <span class="quick-arrow">→</span>
                </a>

                <a href="messages.php" class="quick-card">
                    <div class="quick-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    </div>
                    <div>
                        <strong>Messages</strong>
                        <span>Read client messages</span>
                    </div>
                    <span class="quick-arrow">→</span>
                </a>

                <a href="../index.php" class="quick-card">
                    <div class="quick-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                    </div>
                    <div>
                        <strong>Website</strong>
                        <span>View public portfolio</span>
                    </div>
                    <span class="quick-arrow">→</span>
                </a>

            </div>
        </section>

        <section class="activity-card" style="margin-bottom: 2rem;">
            <div class="activity-header">
                <h3>Recent Content</h3>
                <span class="mini-badge">Latest records</span>
            </div>

            <ul class="activity-list" id="activityList">
                <?php while ($item = $recentProjects->fetch_assoc()): ?>
                    <li class="activity-item" data-category="project" data-search="<?= htmlspecialchars(strtolower($item['title']), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="activity-main">
                            <div class="activity-icon">P</div>
                            <div>
                                <strong>Project</strong>
                                <span><?= htmlspecialchars($item['title']) ?> · <?= htmlspecialchars(date('M j, Y', strtotime($item['created_at']))) ?></span>
                            </div>
                        </div>
                        <span class="activity-pill">Project</span>
                    </li>
                <?php endwhile; ?>
                <?php while ($item = $recentServices->fetch_assoc()): ?>
                    <li class="activity-item" data-category="service" data-search="<?= htmlspecialchars(strtolower($item['title']), ENT_QUOTES, 'UTF-8') ?>">
                        <div class="activity-main">
                            <div class="activity-icon">S</div>
                            <div>
                                <strong>Service</strong>
                                <span><?= htmlspecialchars($item['title']) ?> · <?= htmlspecialchars(date('M j, Y', strtotime($item['created_at']))) ?></span>
                            </div>
                        </div>
                        <span class="activity-pill info">Service</span>
                    </li>
                <?php endwhile; ?>
                <?php while ($item = $recentMessages->fetch_assoc()): ?>
                    <?php $messageSearch = strtolower($item['name'] . ' ' . ($item['subject'] ?? '')); ?>
                    <li class="activity-item" data-category="message" data-search="<?= htmlspecialchars($messageSearch, ENT_QUOTES, 'UTF-8') ?>">
                        <div class="activity-main">
                            <div class="activity-icon">M</div>
                            <div>
                                <strong>Message from <?= htmlspecialchars($item['name']) ?></strong>
                                <span><?= htmlspecialchars($item['subject'] ?: 'No subject') ?> · <?= htmlspecialchars(date('M j, Y', strtotime($item['created_at']))) ?></span>
                            </div>
                        </div>
                        <span class="activity-pill pending">Message</span>
                    </li>
                <?php endwhile; ?>
            </ul>
            <p id="activityEmpty" class="activity-empty">No matching content found.</p>
        </section>

        <!-- SYSTEM INFORMATION -->
        <section class="system-panel">
            <div class="system-icon">⚡</div>
            <div class="system-content">
                <span>SYSTEM INFORMATION</span>
                <h3>Portfolio Control Center</h3>
                <p>Your administrator panel is connected to the portfolio database and ready for management.</p>
            </div>
            <div class="system-status">
                <span class="status-circle"></span>
                <strong>ONLINE</strong>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="admin-footer">
            <span>© <?= date("Y") ?> Nayishimante Sodique</span>
            <span>SODIQUE.DEV</span>
        </footer>

    </main>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    /* ==========================================
        MOBILE SIDEBAR LOGIC (Preserved)
    ========================================== */
    const mobileMenu = document.getElementById("mobileMenu");
    const sidebar = document.getElementById("adminSidebar");
    const sidebarClose = document.getElementById("sidebarClose");
    const overlay = document.getElementById("sidebarOverlay");
    const themeToggle = document.getElementById("themeToggle");
    const searchInput = document.getElementById("adminSearch");
    const contentFilter = document.getElementById("contentFilter");
    const activityItems = document.querySelectorAll(".activity-item");
    const activityEmpty = document.getElementById("activityEmpty");

    function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.add("open");
        if (overlay) overlay.classList.add("active");
        document.body.classList.add("sidebar-open");
    }

    function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove("open");
        if (overlay) overlay.classList.remove("active");
        document.body.classList.remove("sidebar-open");
    }

    if (mobileMenu) mobileMenu.addEventListener("click", openSidebar);
    if (sidebarClose) sidebarClose.addEventListener("click", closeSidebar);
    if (overlay) overlay.addEventListener("click", closeSidebar);

    document.querySelectorAll(".sidebar-nav a").forEach(function (link) {
        link.addEventListener("click", closeSidebar);
    });

    /* ==========================================
        THEME TOGGLE (New innovation)
    ========================================== */
    const savedTheme = localStorage.getItem("adminTheme") || "dark";
    document.body.classList.toggle("theme-light", savedTheme === "light");

    if (themeToggle) {
        themeToggle.addEventListener("click", function () {
            const isLight = document.body.classList.toggle("theme-light");
            localStorage.setItem("adminTheme", isLight ? "light" : "dark");
            themeToggle.innerHTML = isLight ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';
        });

        themeToggle.innerHTML = savedTheme === "light"
            ? '<i class="fa-solid fa-sun"></i>'
            : '<i class="fa-solid fa-moon"></i>';
    }

    /* ==========================================
        SEARCH + FILTER (New innovation)
    ========================================== */
    function applyActivityFilter() {
        const query = (searchInput ? searchInput.value : "").toLowerCase();
        const filterValue = contentFilter ? contentFilter.value : "all";
        let visibleItems = 0;

        activityItems.forEach(function (item) {
            const category = item.dataset.category || "";
            const searchableText = (item.dataset.search || "") + " " + item.textContent.toLowerCase();
            const matchQuery = searchableText.includes(query);
            const matchCategory = filterValue === "all" || category === filterValue;
            const isVisible = matchQuery && matchCategory;
            item.classList.toggle("search-hidden", !isVisible);
            if (isVisible) visibleItems += 1;
        });

        if (activityEmpty) activityEmpty.classList.toggle("visible", visibleItems === 0);
    }

    if (searchInput) {
        searchInput.addEventListener("input", applyActivityFilter);
    }

    if (contentFilter) {
        contentFilter.addEventListener("change", applyActivityFilter);
    }

    /* ==========================================
        COUNTER ANIMATION (Preserved)
    ========================================== */
    const counters = document.querySelectorAll(".counter");

    counters.forEach(function (counter) {
        const target = parseInt(counter.dataset.target || 0, 10);
        let current = 0;

        if (target === 0) {
            counter.textContent = "0";
            return;
        }

        const duration = 1200;
        const increment = Math.max(target / (duration / 20), 1);

        const timer = setInterval(function () {
            current += increment;

            if (current >= target) {
                current = target;
                clearInterval(timer);
            }

            counter.textContent = Math.floor(current);
        }, 20);
    });

    /* ==========================================
        LIVE CLOCK + STATUS (New innovation)
    ========================================== */
    const liveClock = document.getElementById("liveClock");
    const liveStatusText = document.getElementById("liveStatusText");

    function updateLiveClock() {
        const now = new Date();
        const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
        const date = now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric' });

        if (liveClock) {
            liveClock.textContent = date + ' • ' + time;
        }

        if (liveStatusText) {
            liveStatusText.textContent = now.getHours() >= 9 && now.getHours() < 18 ? 'ACTIVE' : 'STANDBY';
        }
    }

    updateLiveClock();
    setInterval(updateLiveClock, 1000);

    /* ==========================================
        CARD REVEAL (Preserved)
    ========================================== */
    const cards = document.querySelectorAll(".dashboard-card, .quick-card, .system-panel");

    cards.forEach(function (card, index) {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";

        setTimeout(function () {
            card.style.transition = "opacity .6s cubic-bezier(0.16, 1, 0.3, 1), transform .6s cubic-bezier(0.16, 1, 0.3, 1)";
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, 100 + (index * 80));
    });

    /* ==========================================
        ESCAPE KEY (Preserved)
    ========================================== */
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeSidebar();
        }
    });

});
</script>

</body>
</html>