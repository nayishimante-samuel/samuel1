<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/database.php";

$error = "";

if (isset($_SESSION['admin_id'])) {
    header("Location: admin/index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username !== "" && $password !== "") {
        $stmt = $conn->prepare(
            "SELECT id, username, password
             FROM users
             WHERE username = ?
             LIMIT 1"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                session_regenerate_id(true);

                $_SESSION["admin_id"] = $user["id"];
                $_SESSION["admin_username"] = $user["username"];

                header("Location: admin/index.php");
                exit;
            }
        }

        $error = "Invalid username or password.";

        if (isset($stmt)) {
            $stmt->close();
        }
    } else {
        $error = "Please enter both username and password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body class="login-page">

<main class="login-shell">
    <div class="login-brand">
        <span class="login-brand-mark">&lt;/&gt;</span>
        <span>NAYISHIMANTE.DEV</span>
    </div>

    <section class="login-box" aria-labelledby="loginHeading">
        <p class="login-kicker">Administrator access</p>
        <h1 class="login-heading" id="loginHeading">Welcome back.</h1>
        <p class="login-description">Sign in to manage your portfolio dashboard.</p>

    <?php if ($error): ?>
        <div class="login-error" role="alert">
            <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
            <span><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

        <form method="POST" id="loginForm" class="login-form">
            <div class="login-field">
                <label for="usernameInput">Username or email</label>
                <div class="login-input-wrap">
                    <i class="login-input-icon fa-regular fa-envelope" aria-hidden="true"></i>
                <input
                    id="usernameInput"
                    type="text"
                    name="username"
                    autocomplete="username"
                    placeholder="name@example.com"
                    required
                    class="login-input"
                >
                </div>
            </div>

            <div class="login-field">
                <label for="passwordInput">Password</label>
                <div class="login-input-wrap">
                    <i class="login-input-icon fa-solid fa-lock" aria-hidden="true"></i>
                <input
                    id="passwordInput"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    placeholder="Enter password"
                    required
                    class="login-input"
                >
                <button
                    type="button"
                    id="togglePassword"
                    class="password-toggle"
                    aria-label="Show password"
                    aria-pressed="false"
                >
                    <i class="fa-regular fa-eye" aria-hidden="true"></i>
                </button>
                </div>
            </div>

            <button type="submit" id="submitBtn" class="login-submit">
                <span id="btnText">Sign in <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></span>
                <span id="btnLoader" hidden>
                    <i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i>
                    <span>Signing in...</span>
                </span>
            </button>
        </form>

        <a href="index.php" class="login-back">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Return to portfolio</span>
        </a>
    </section>
</main>

<script>
    const passwordInput = document.getElementById('passwordInput');
    const togglePassword = document.getElementById('togglePassword');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            togglePassword.innerHTML = isHidden
                ? '<i class="fa-regular fa-eye-slash" aria-hidden="true"></i>'
                : '<i class="fa-regular fa-eye" aria-hidden="true"></i>';
            togglePassword.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            togglePassword.setAttribute('aria-pressed', String(isHidden));
            passwordInput.focus();
        });
    }

    document.getElementById('loginForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');

        btn.disabled = true;
        btnText.hidden = true;
        btnLoader.hidden = false;
    });
</script>

<script src="js/script.js"></script>

</body>
</html>