<?php

include "../includes/auth.php";
include "../config/database.php";

$result = $conn->query(
    "SELECT * FROM messages ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Contact Messages | Admin Dashboard</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet"
          href="../css/style.css">

</head>

<body class="admin-page bg-slate-950 text-slate-100 font-sans antialiased min-h-screen">

<div class="admin-layout flex min-h-screen">

    <!-- Admin Sidebar -->
    <aside class="sidebar w-64 bg-slate-900 border-r border-slate-800/80 flex flex-col justify-between shrink-0 fixed inset-y-0 left-0 z-30 md:static">
        
        <div>
            <!-- Admin Logo -->
            <div class="admin-logo px-6 py-6 border-b border-slate-800/80 flex items-center justify-between">
                <a href="index.php" class="text-xl font-extrabold tracking-wider bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">
                    <span class="text-indigo-500 font-normal">&lt;</span>Sodique<span class="text-indigo-500 font-normal">/&gt;</span>
                </a>
                <span class="text-[10px] uppercase font-bold tracking-widest px-2 py-0.5 rounded bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                    Admin
                </span>
            </div>

            <!-- Sidebar Navigation Links -->
            <nav class="p-4 space-y-1">
                <a href="index.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition-colors text-sm font-medium">
                    <i class="fa-solid fa-chart-pie w-5 text-center text-slate-400"></i>
                    <span>Dashboard</span>
                </a>

                <a href="projects.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition-colors text-sm font-medium">
                    <i class="fa-solid fa-folder-open w-5 text-center text-slate-400"></i>
                    <span>Projects</span>
                </a>

                <a href="services.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition-colors text-sm font-medium">
                    <i class="fa-solid fa-cubes w-5 text-center text-slate-400"></i>
                    <span>Services</span>
                </a>

                <a href="messages.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-indigo-600 text-white font-medium text-sm shadow-lg shadow-indigo-600/20">
                    <i class="fa-solid fa-envelope w-5 text-center text-white"></i>
                    <span>Messages</span>
                </a>
            </nav>
        </div>

        <!-- Footer Action Links -->
        <div class="p-4 border-t border-slate-800/80 space-y-1">
            <a href="../index.php" target="_blank" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-white transition-colors text-sm font-medium">
                <i class="fa-solid fa-globe w-5 text-center text-slate-400"></i>
                <span>View Website</span>
            </a>

            <a href="../logout.php" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-rose-400 hover:bg-rose-500/10 transition-colors text-sm font-medium">
                <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                <span>Logout</span>
            </a>
        </div>

    </aside>

    <!-- Main Admin Content -->
    <main class="admin-content flex-1 p-6 md:p-10 max-w-7xl mx-auto w-full">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Contact Messages</h1>
                <p class="text-slate-400 text-sm mt-1">Review inquiry messages received from your portfolio website.</p>
            </div>
            
            <div class="inline-flex items-center space-x-2 bg-slate-900 border border-slate-800 px-4 py-2 rounded-xl text-slate-300 text-sm font-medium shadow-sm">
                <i class="fa-solid fa-inbox text-indigo-400"></i>
                <span>Total: <?= $result ? $result->num_rows : 0 ?></span>
            </div>
        </div>

        <!-- Table Container Card -->
        <div class="admin-table bg-slate-900/80 border border-slate-800/80 rounded-2xl shadow-xl overflow-hidden backdrop-blur-xl">

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    <thead>
                        <tr class="bg-slate-800/50 border-b border-slate-800 text-slate-400 text-xs uppercase font-semibold tracking-wider">
                            <th class="py-4 px-6">Sender</th>
                            <th class="py-4 px-6">Subject</th>
                            <th class="py-4 px-6">Message</th>
                            <th class="py-4 px-6">Date</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-800/60 text-sm text-slate-300">

                        <?php if ($result && $result->num_rows > 0): ?>

                            <?php while ($message = $result->fetch_assoc()): ?>

                                <tr class="hover:bg-slate-800/30 transition-colors duration-150">

                                    <!-- Sender Name & Email -->
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-white mb-0.5">
                                            <?= htmlspecialchars($message['name']) ?>
                                        </div>
                                        <a href="mailto:<?= htmlspecialchars($message['email']) ?>" class="text-xs text-indigo-400 hover:underline flex items-center space-x-1">
                                            <i class="fa-regular fa-envelope text-[10px]"></i>
                                            <span><?= htmlspecialchars($message['email']) ?></span>
                                        </a>
                                    </td>

                                    <!-- Subject -->
                                    <td class="py-4 px-6 font-medium text-slate-200">
                                        <span class="line-clamp-1">
                                            <?= htmlspecialchars($message['subject']) ?>
                                        </span>
                                    </td>

                                    <!-- Message Body -->
                                    <td class="py-4 px-6 max-w-md">
                                        <p class="text-slate-400 text-sm leading-relaxed line-clamp-3 whitespace-pre-line">
                                            <?= htmlspecialchars($message['message']) ?>
                                        </p>
                                    </td>

                                    <!-- Date Badge -->
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="inline-flex items-center space-x-1.5 text-xs text-slate-400 bg-slate-800 px-3 py-1 rounded-lg border border-slate-700/50">
                                            <i class="fa-regular fa-clock text-[11px] text-slate-500"></i>
                                            <span>
                                                <?php 
                                                    if (!empty($message['created_at'])) {
                                                        echo htmlspecialchars(date('M d, Y · H:i', strtotime($message['created_at'])));
                                                    } else {
                                                        echo "N/A";
                                                    }
                                                ?>
                                            </span>
                                        </span>
                                    </td>

                                    <!-- Action Button (Reply) -->
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <a href="mailto:<?= htmlspecialchars($message['email']) ?>?subject=Re: <?= urlencode($message['subject']) ?>" 
                                           class="inline-flex items-center space-x-1.5 px-3 py-1.5 bg-indigo-500/10 text-indigo-400 hover:bg-indigo-600 hover:text-white rounded-lg border border-indigo-500/20 text-xs font-medium transition-all duration-200">
                                            <i class="fa-solid fa-reply text-[11px]"></i>
                                            <span>Reply</span>
                                        </a>
                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <!-- Empty State Row -->
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <div class="w-12 h-12 rounded-full bg-slate-800/80 flex items-center justify-center text-slate-400 text-xl">
                                            <i class="fa-regular fa-envelope-open"></i>
                                        </div>
                                        <p class="text-slate-400 font-medium text-base">No messages received yet.</p>
                                        <p class="text-slate-600 text-xs max-w-sm">When users fill out your contact form on the main website, their inquiries will appear here.</p>
                                    </div>
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

        </div>

    </main>

</div>

</body>
</html>