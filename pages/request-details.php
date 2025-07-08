<?php
$status = $_GET['status'] ?? 'pending';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Request Details - HelpingHand Admin</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar" id="nav-color">
    <div class="nav-left">
      <img class="logo" src="assets/logo.svg" alt="HelpingHand Logo" />
      <nav>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">About us</a></li>
        </ul>
      </nav>
    </div>
    <div class="searchbar">
      <input type="text" placeholder="Search..." />
    </div>
  </header>

  <!-- DETAILS WRAPPER -->
  <main class="details-wrapper">
    <a class="back-link" href="admin_requests.php">← Back to Requests</a>

    <?php
    // Sample data — can be replace this with real PHP logic or a DB.
    $title = "Need Help with Groceries";
    $applicant = "Juan Dela Cruz";
    $email = "juandelacruz@example.com";
    $phone = "0912 345 6789";
    $address = "123 Mabini St, Marikina City";
    $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
    $category = "Financial Support";
    $tier = "Tier 1";
    $amount = "₱150,000";
    ?>

    <h2><?= $title ?></h2>

    <!-- Applicant Info -->
    <div class="details-section">
      <h3>Applicant Info</h3>
      <p><span class="details-label">Name:</span><?= $applicant ?></p>
      <p><span class="details-label">Email:</span><?= $email ?></p>
      <p><span class="details-label">Phone:</span><?= $phone ?></p>
      <p><span class="details-label">Address:</span><?= $address ?></p>
    </div>

    <!-- Request Description -->
    <div class="details-section">
      <h3>Request Description</h3>
      <p><?= $description ?></p>
    </div>

    <!-- Support Info -->
    <div class="details-section">
      <h3>Requested Support</h3>
      <p><span class="details-label">Category:</span><?= $category ?></p>
      <p><span class="details-label">Tier:</span><?= $tier ?></p>
      <p><span class="details-label">Requested Amount:</span><?= $amount ?></p>
    </div>

    <!-- Action Buttons or Status Display -->
    <?php if ($status === 'pending'): ?>
      <form method="post" class="details-buttons">
        <button type="submit" name="accept" class="btn-accept">ACCEPT</button>
        <button type="submit" name="reject" class="btn-reject">REJECT</button>
      </form>
    <?php else: ?>
      <div class="details-section">
        <p><strong>Status:</strong>
          <span class="status <?= htmlspecialchars($status) ?>">
            <?= ucfirst(htmlspecialchars($status)) ?>
          </span>
        </p>
      </div>
    <?php endif; ?>

  </main>

</body>
</html>
