<?php
require_once __DIR__ . '/../includes/config.php';

$pageTitle = "Contact SA Paycheck";
$pageDesc = "Contact SA Paycheck with corrections, feedback or suggestions for the free South African take-home pay calculator.";
$canonical = "/contact/";

$errors = [];
$sent = false;
$name = $email = $message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot: bots fill this invisible field; humans never see it.
    if (!empty($_POST['website'] ?? '')) {
        $sent = true; // pretend success, drop silently
    } else {
        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (strlen($name) < 2)                       $errors[] = "Please enter your name.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Please enter a valid email address.";
        if (strlen($message) < 10)                   $errors[] = "Please write a message of at least 10 characters.";
        if (strlen($message) > 5000)                 $errors[] = "Message is too long (max 5,000 characters).";

        if (!$errors) {
            $safeName = str_replace(["\r", "\n"], " ", $name);
            // mbstring may not be installed — fall back to strlen-safe substr.
            $shortName = function_exists('mb_substr') ? mb_substr($safeName, 0, 60) : substr($safeName, 0, 60);
            $subject = "SA Paycheck contact: " . $shortName;
            $body = "Name: $safeName\nEmail: $email\n\n$message\n";
            $headers = "From: noreply@sapaycheck.co.za\r\n" .
                       "Reply-To: " . str_replace(["\r", "\n"], "", $email) . "\r\n" .
                       "Content-Type: text/plain; charset=UTF-8";
            // Note: requires the host to route PHP mail() (sendmail). On Hostinger this works out of the box.
            if (mail($CONTACT_EMAIL, $subject, $body, $headers)) {
                $sent = true;
                $name = $email = $message = "";
            } else {
                $errors[] = "Sending failed — please email us directly at " . $CONTACT_EMAIL . ".";
            }
        }
    }
}
require __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <div class="wrap">
    <div class="kicker">Send a message</div>
    <h1 class="h2">Contact SA Paycheck</h1>
    <p class="sub">Spotted a wrong number? Suggest a feature? Tell us — calculation corrections get priority.</p>
    <div class="card" style="max-width:680px">
      <?php if ($sent): ?>
        <div class="success"><strong>Message sent.</strong> Thank you — we'll get back to you if a reply is needed.</div>
      <?php endif; ?>
      <?php foreach ($errors as $e): ?>
        <div class="error"><?php echo htmlspecialchars($e); ?></div>
      <?php endforeach; ?>
      <div class="error" id="cf-error" style="display:none"></div>
      <form method="post" action="/contact/" id="contactForm" novalidate>
        <div class="field">
          <label for="cf-name">Name</label>
          <input type="text" id="cf-name" name="name" value="<?php echo htmlspecialchars($name); ?>" autocomplete="name">
        </div>
        <div class="field">
          <label for="cf-email">Email</label>
          <input type="email" id="cf-email" name="email" value="<?php echo htmlspecialchars($email); ?>" autocomplete="email">
        </div>
        <div class="field">
          <label for="cf-message">Message</label>
          <textarea id="cf-message" name="message" rows="6" placeholder="Which page? What looks off?"><?php echo htmlspecialchars($message); ?></textarea>
        </div>
        <div class="hp" aria-hidden="true">
          <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        </div>
        <button type="submit" class="btn btn-primary">Send message</button>
      </form>
    </div>
  </div>
</section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
