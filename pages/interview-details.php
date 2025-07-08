<?php
// Simulate passing a status through the URL
$status = $_GET['status'] ?? 'pending';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Interview Details - HelpingHand Admin</title>
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
    <a class="back-link" href="interviews.php">← Back to Interviews</a>

    <?php
    // Sample Interview Data
    $applicant = "Carlos Reyes";
    $date = "2025-07-10";
    $time = "2:00 PM";
    $type = "In-Person";
    $location = "HelpingHand Office, Quezon City";
    $notes = "Interview will assess eligibility for financial support program.";
    ?>

    <h2>Interview with <?= $applicant ?></h2>

    <!-- Applicant Info -->
    <div class="details-section">
      <h3>Interview Info</h3>
      <p><span class="details-label">Name:</span> <?= $applicant ?></p>
      <p><span class="details-label">Date:</span> <?= $date ?></p>
      <p><span class="details-label">Time:</span> <?= $time ?></p>
      <p><span class="details-label">Type:</span> <?= $type ?></p>
      <?php if ($type === 'In-Person'): ?>
        <p><span class="details-label">Location:</span> <?= $location ?></p>
      <?php endif; ?>
    </div>

    <!-- Notes -->
    <div class="details-section">
      <h3>Notes</h3>
      <p><?= $notes ?></p>
    </div>

    <!-- Action Buttons or Status Display -->
    <?php if ($status === 'pending'): ?>
      <form method="post" class="details-buttons">
        <button type="submit" name="schedule" class="btn-accept">SCHEDULE</button>
        <button type="submit" name="reject" class="btn-reject">REJECT</button>
      </form>
    <?php elseif ($status === 'scheduled'): ?>
      <div class="details-section">
        <p><strong>Status:</strong>
          <span class="status scheduled">Scheduled</span>
        </p>
      </div>
    <?php elseif ($status === 'completed'): ?>
      <div class="details-section">
        <p><strong>Status:</strong>
          <span class="status completed">Completed</span>
        </p>
      </div>
    <?php else: ?>
      <div class="details-section">
        <p><strong>Status:</strong>
          <span class="status"><?= ucfirst(htmlspecialchars($status)) ?></span>
        </p>
      </div>
    <?php endif; ?>

  </main>

</body>
</html>
