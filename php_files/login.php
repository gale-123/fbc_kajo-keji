<?php
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if (!$email || $message === '') {
        $status = 'Enter a valid email and message.';
    } else {
        try {
            $pdo = new PDO(
                'mysql:host=localhost;dbname=fbc_kk;charset=utf8mb4',
                'fbc_kk',
                '',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $stmt = $pdo->prepare(
                'INSERT INTO enquiries (email, message) VALUES (:email, :message)'
            );
            $stmt->execute(['email' => $email, 'message' => $message]);

            $sent = mail(
                'galer04@gmail.com',
                'Website enquiry',
                "From: $email\n\n$message",
                ['From' => 'website@YOUR_DOMAIN']
            );

            $status = $sent
                ? 'Your message was sent.'
                : 'Your message was saved, but email delivery failed.';
        } catch (PDOException $e) {
            $status = 'Sorry, we could not process your message.';
            error_log($e->getMessage());
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Send us a message</title>
</head>
<body>
  <h1>Send us a message</h1>

  <?php if ($status !== ''): ?>
    <p><?= htmlspecialchars($status, ENT_QUOTES, 'UTF-8') ?></p>
  <?php endif; ?>

  <form method="post" action="login.php">
    <label>Email
      <input type="email" name="email" required>
    </label>
    <label>Message
      <textarea name="message" required></textarea>
    </label>
    <button type="submit">Send message</button>
  </form>
</body>
</html>