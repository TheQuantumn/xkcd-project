<!DOCTYPE html>
<html>
<head><title>Unsubscribe</title></head>
<body>
<h2>Unsubscribe from XKCD</h2>

<form method="POST">
  <input type="email" name="unsubscribe_email" required>
  <button id="submit-unsubscribe">Unsubscribe</button>
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
    if (isset($_POST['unsubscribe_email'])) {
        $em = trim($_POST['unsubscribe_email']);
        $cd = generateVerificationCode();
        file_put_contents("$codesDir/" . md5($em) . ".txt", $cd);
        if (sendUnsubscribeCode($em, $cd)) {
            echo "<p>Verification code sent to $em</p>";
        } else {
            echo "<p>Failed to send verification email</p>";
        }
        $_SESSION['unsubscribe_email'] = $em;
    }

    if (isset($_POST['verification_code'])) {
        $vc = trim($_POST['verification_code']);
        $em = $_SESSION['unsubscribe_email'] ?? null;
        if ($em && verifyCode($em, $vc)) {
            unsubscribeEmail($em);
            unlink("$codesDir/" . md5($em) . ".txt");
            echo "<p>You have been unsubscribed.</p>";
        } else {
            echo "<p>Invalid verification code</p>";
        }
    }
}
?>
</body>
</html>
