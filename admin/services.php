<?php

include "../includes/auth.php";
include "../config/database.php";

$message = "";

if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    $stmt = $conn->prepare(
        "DELETE FROM services WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $stmt->close();

    header("Location: services.php");

    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $icon = trim($_POST['icon']);

    $stmt = $conn->prepare(
        "INSERT INTO services
        (title, description, icon)
        VALUES (?, ?, ?)"
    );

    $stmt->bind_param(
        "sss",
        $title,
        $description,
        $icon
    );

    $stmt->execute();

    $stmt->close();

    $message = "Service added successfully.";
}

$result = $conn->query(
    "SELECT * FROM services ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Services</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet"
          href="../css/style.css">

</head>

<body class="admin-page bg-gray-50 text-gray-800 font-sans antialiased">

<div class="admin-layout min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar -->
    <aside class="sidebar w-full md:w-64 bg-slate-900 text-slate-300 flex-shrink-0 p-6 flex flex-col justify-between shadow-xl">

        <div>
            <div class="admin-logo text-2xl font-bold text-white tracking-wider mb-8 flex items-center space-x-3">
                <i class="fa-solid fa-code text-indigo-500"></i>
                <span>Sodique</span>
            </div>

            <nav class="space-y-1">
                <a href="index.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-chart-pie w-5"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="projects.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-folder-open w-5"></i>
                    <span class="font-medium">Projects</span>
                </a>
                <a href="services.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-indigo-600 text-white shadow-md transition-colors duration-200">
                    <i class="fa-solid fa-cubes w-5"></i>
                    <span class="font-medium">Services</span>
                </a>
                <a href="messages.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-envelope w-5"></i>
                    <span class="font-medium">Messages</span>
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-slate-800 space-y-1">
            <a href="../index.php" target="_blank" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200">
                <i class="fa-solid fa-arrow-up-right-from-square w-5"></i>
                <span class="font-medium">Website</span>
            </a>
            <a href="../logout.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition-colors duration-200">
                <i class="fa-solid fa-right-from-bracket w-5"></i>
                <span class="font-medium">Logout</span>
            </a>
        </div>

    </aside>

    <!-- Main Content -->
    <main class="admin-content flex-1 p-6 md:p-10 space-y-8 max-w-7xl mx-auto w-full">

        <header class="flex items-center justify-between border-b border-gray-200 pb-5">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manage Services</h1>
        </header>

        <?php if ($message): ?>

            <div class="alert success bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center space-x-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <span class="text-emerald-800 font-medium"><?= htmlspecialchars($message) ?></span>
            </div>

        <?php endif; ?>

        <!-- Form Section -->
        <div class="admin-form bg-white rounded-xl shadow-sm border border-gray-200/80 p-6 md:p-8">

            <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center space-x-2">
                <i class="fa-solid fa-plus-circle text-indigo-600"></i>
                <span>Add Service</span>
            </h2>

            <form method="POST" class="space-y-5">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Service Title</label>
                        <input
                            type="text"
                            name="title"
                            placeholder="e.g. Web Development"
                            required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-400"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Icon / Emoji</label>
                        <input
                            type="text"
                            name="icon"
                            placeholder="e.g. 💻 or fa-solid fa-code"
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-400"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea
                        name="description"
                        placeholder="Detailed overview of the service offered..."
                        required
                        rows="4"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-400"
                    ></textarea>
                </div>

                <div class="pt-2">
                    <button class="btn bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg shadow-sm hover:shadow transition-all duration-200 flex items-center space-x-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Service</span>
                    </button>
                </div>

            </form>

        </div>

        <!-- Table Section -->
        <div class="admin-table bg-white rounded-xl shadow-sm border border-gray-200/80 overflow-hidden">

            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                    <i class="fa-solid fa-cubes text-indigo-600"></i>
                    <span>Services</span>
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            <th class="py-3.5 px-6">ID</th>
                            <th class="py-3.5 px-6">Service</th>
                            <th class="py-3.5 px-6">Description</th>
                            <th class="py-3.5 px-6 text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm">

                        <?php while ($service = $result->fetch_assoc()): ?>

                            <tr class="hover:bg-slate-50/80 transition-colors">

                                <td class="py-4 px-6 text-gray-500 font-mono text-xs">
                                    #<?= $service['id'] ?>
                                </td>

                                <td class="py-4 px-6 font-medium text-gray-900 min-w-[200px]">
                                    <div class="flex items-center space-x-3">
                                        <?php if (!empty($service['icon'])): ?>
                                            <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-base shrink-0 border border-indigo-100">
                                                <?php if (str_starts_with(trim($service['icon']), 'fa-')): ?>
                                                    <i class="<?= htmlspecialchars($service['icon']) ?>"></i>
                                                <?php else: ?>
                                                    <?= htmlspecialchars($service['icon']) ?>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                        <span><?= htmlspecialchars($service['title']) ?></span>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-gray-600 max-w-md leading-relaxed">
                                    <?= htmlspecialchars($service['description']) ?>
                                </td>

                                <td class="py-4 px-6 text-right">

                                    <a
                                        href="?delete=<?= $service['id'] ?>"
                                        class="delete-btn inline-flex items-center space-x-1.5 text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-md transition-colors text-xs font-medium"
                                        onclick="return confirm('Delete this service?')"
                                    >
                                        <i class="fa-regular fa-trash-can"></i>
                                        <span>Delete</span>
                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>
            </div>

        </div>

    </main>

</div>

</body>
</html>