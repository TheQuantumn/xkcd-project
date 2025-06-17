<!DOCTYPE html>
<html>
<head><title>Email Registration</title></head>
<body>
<h2>Subscribe to XKCD</h2>

<form method="POST">
  <input type="email" name="email" required>
  <button id="submit-email">Submit</button>
</form>

<form method="POST">
  <input type="text" name="verification_code" maxlength="6" required>
  <button id="submit-verification">Verify</button>
</form>

<?php
require_once 'functions.php';

session_start();
$codesDir = __DIR__ . "/codes";
if (!is_dir($codesDir)) {
    mkdir($codesDir);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['email'])) {
        $em = trim($_POST['email']);
        $cd = generateVerificationCode();
        file_put_contents("$codesDir/" . md5($em) . ".txt", $cd);
        if (sendVerificationEmail($em, $cd)) {
            echo "<p>Verification code sent to $em</p>";
        } else {
            echo "<p>Failed to send verification email</p>";
        }
    }

    if (isset($_POST['verification_code'])) {
        $vc = trim($_POST['verification_code']);
        $em = $_SESSION['last_email'] ?? null;
        if ($em && verifyCode($em, $vc)) {
            registerEmail($em);
            unlink("$codesDir/" . md5($em) . ".txt");
            echo "<p>Successfully registered!</p>";
        } else {
            echo "<p>Invalid verification code</p>";
        }
    }
    if (isset($_POST['email'])) {
        $_SESSION['last_email'] = $_POST['email'];
    }
}
?>
</body>
</html>
