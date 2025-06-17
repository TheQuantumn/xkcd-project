<?php

/**
 * Generate a 6-digit numeric verification code.
 */

function generateVerificationCode() {
    return rand(100000, 999999);
}

function registerEmail($email) {
    $filePath = __DIR__ . '/registered_emails.txt';
    $emails = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!in_array($email, $emails)) {
        file_put_contents($filePath, $email . PHP_EOL, FILE_APPEND);
    }
}

function unsubscribeEmail($email) {
    $filePath = __DIR__ . '/registered_emails.txt';
    $emails = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $updatedEmails = array_filter($emails, fn($e) => $e !== $email);
    file_put_contents($filePath, implode(PHP_EOL, $updatedEmails) . PHP_EOL);
}

function sendVerificationEmail($email, $code) {
    $subject = 'Your Verification Code';
    $htmlContent = "<p>Your verification code is: <strong>$code</strong></p>";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: no-reply@example.com\r\n";
    return mail($email, $subject, $htmlContent, $headers);
}

function verifyCode($email, $code) {
    $sessionFile = __DIR__ . "/codes/" . md5($email) . ".txt";
    if (file_exists($sessionFile)) {
        $storedCode = trim(file_get_contents($sessionFile));
        return $code === $storedCode;
    }
    return false;
}

function fetchAndFormatXKCDData() {
    $maxComicId = 2800;
    $randomId = rand(1, $maxComicId);
    $apiUrl = "https://xkcd.com/$randomId/info.0.json";
    $json = file_get_contents($apiUrl);
    if (!$json) return false;
    $data = json_decode($json, true);
    $imgUrl = $data['img'] ?? '';
    $html = "<h2>XKCD Comic</h2>";
    $html .= "<img src=\"$imgUrl\" alt=\"XKCD Comic\">";
    $html .= "<p><a href=\"http://localhost/xkcd-project/src/unsubscribe.php\" id=\"unsubscribe-button\">Unsubscribe</a></p>";
    return $html;
}

function sendXKCDUpdatesToSubscribers() {
    $filePath = __DIR__ . '/registered_emails.txt';
    $subscribers = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $htmlContent = fetchAndFormatXKCDData();
    if (!$htmlContent) return;
    $subject = "Your XKCD Comic";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
    $headers .= "From: no-reply@example.com\r\n";
    foreach ($subscribers as $email) {
        mail($email, $subject, $htmlContent, $headers);
    }
}
