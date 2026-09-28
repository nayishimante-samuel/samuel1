<?php

include "config/database.php";

$pageTitle = "Contact | Nayishimante Samuel";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if ($name === "" || $email === "" || $message === "") {

        $error = "Please fill in all required fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO messages
            (name, email, subject, message)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssss",
            $name,
            $email,
            $subject,
            $message
        );

        if ($stmt->execute()) {

            $success = "Your message has been sent successfully.";

        } else {

            $error = "Unable to send your message.";

        }

        $stmt->close();
    }
}

include "includes/header.php";
include "includes/navbar.php";

?>

<section class="page-banner">

    <div class="container">

        <span>GET IN TOUCH</span>

        <h1>Contact Me</h1>

        <p>
            Have a project idea? Let's talk.
        </p>

    </div>

</section>

<section class="section">

    <div class="container contact-grid">

        <div class="contact-info">

            <span class="section-label">
                CONTACT
            </span>

            <h2>
                Let's Build Something
                Great Together
            </h2>

            <p>
                Send me a message and tell me about your
                project, idea or business requirements.
            </p>

            <div class="contact-item">

                <strong>Email</strong>

                <p>
                    nayishimantesodique@gmail.com
                </p>

            </div>

        </div>

        <form method="POST"
              class="contact-form">

            <?php if ($success): ?>

                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>

            <?php endif; ?>

            <?php if ($error): ?>

                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>

            <input
                type="text"
                name="name"
                placeholder="Your Name"
                required
            >

            <input
                type="email"
                name="email"
                placeholder="Your Email"
                required
            >

            <input
                type="text"
                name="subject"
                placeholder="Subject"
            >

            <textarea
                name="message"
                rows="7"
                placeholder="Your message..."
                required
            ></textarea>

            <button type="submit"
                    class="btn">
                Send Message
            </button>

        </form>

    </div>

</section>

<?php include "includes/footer.php"; ?>