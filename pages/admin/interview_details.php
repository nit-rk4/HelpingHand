<?php
$status = $_GET['status'] ?? 'pending';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Interview Details - HelpingHand Admin</title>
  <link rel="stylesheet" href="/css/style.css" />
</head>
<body>

  <!-- NAVBAR -->
  <?php include("../navbar.php") ?>

  <!-- DETAILS WRAPPER -->
  <main class="details-wrapper">
    <a class="back-link" href="admin_interviews.php">← Back to Interviews</a>

    <?php
    // Sample Interview Data
    $applicant = "Carlos Reyes";
    $address = "123 Mabini St., Quezon City";
    $phone = "0917-123-4567";
    $request = ($status === 'scheduled') ? "Help with tuition fees for 2nd semester" : "Need donation for medical assistance";
    $date = "2025-07-10";
    $time = "2:00 PM";
    $interviewer = "Ms. Santos";
    $interviewNotes = "Applicant showed great promise and is eligible for support.";
    ?>

    <h2>Interview with <?= $applicant ?></h2>

    <!-- Interviewee Info -->
    <div class="details-section">
      <h3>Interviewee Details</h3>
      <p><span class="details-label">Name:</span> <?= $applicant ?></p>
      <p><span class="details-label">Address:</span> <?= $address ?></p>
      <p><span class="details-label">Phone Number:</span> <?= $phone ?></p>
    </div>

    <!-- Request Details -->
    <div class="details-section">
      <h3>Request Details</h3>
      <p><?= $request ?></p>
    </div>

    <?php if ($status === 'pending'): ?>
      <!-- Notes -->
      <div class="details-section">
        <h3>Notes</h3>
        <p>Interview will assess eligibility for financial support program.</p>
      </div>

      <!-- Buttons -->
      <div class="details-buttons" id="pending-buttons">
        <button type="button" class="btn-accept" onclick="showScheduleForm()">SCHEDULE</button>
        <form method="post" style="display: inline;">
          <button type="submit" name="reject" class="btn-reject">CANCEL</button>
        </form>
      </div>

      <!-- Schedule Form -->
      <form method="post" id="schedule-form" class="form-container" style="display: none;">
        <h3>Schedule Interview</h3>
        <label>Date: <input type="date" name="schedule_date" required></label>
        <label>Time: <input type="time" name="schedule_time" required></label>
        <label>Interviewer: <input type="text" name="interviewer" required></label>
        <div class="details-buttons">
          <button type="submit" name="confirm_schedule" class="btn-confirm">CONFIRM SCHEDULE</button>
        </div>
      </form>

      <script>
        function showScheduleForm() {
          document.getElementById('pending-buttons').style.display = 'none';
          document.getElementById('schedule-form').style.display = 'block';
        }
      </script>

    <?php elseif ($status === 'scheduled'): ?>
      <!-- Schedule Details -->
      <div class="details-section">
        <h3>Schedule Details</h3>
        <p><span class="details-label">Date:</span> <?= $date ?></p>
        <p><span class="details-label">Time:</span> <?= $time ?></p>
        <p><span class="details-label">Interviewer:</span> <?= $interviewer ?></p>
      </div>

      <!-- Buttons -->
      <div class="details-buttons" id="scheduled-buttons">
        <form method="post">
          <button type="submit" name="mark_done" class="btn-accept">MARK AS DONE</button>
          <button type="button" class="btn-neutral" onclick="showRescheduleForm()">RESCHEDULE</button>
          <button type="submit" name="cancel" class="btn-reject">CANCEL</button>
        </form>
      </div>

      <!-- Reschedule Form -->
      <form method="post" id="reschedule-form" class="form-container" style="display: none;">
        <h3>Reschedule Interview</h3>
        <label>New Date: <input type="date" name="new_date" required></label>
        <label>New Time: <input type="time" name="new_time" required></label>
        <label>Interviewer: <input type="text" name="new_interviewer" value="<?= $interviewer ?>" required></label>
        <div class="details-buttons">
          <button type="submit" name="confirm_reschedule" class="btn-confirm">CONFIRM</button>
          <button type="button" class="btn-reject" onclick="cancelReschedule()">CANCEL</button>
        </div>
      </form>

      <script>
        function showRescheduleForm() {
          document.getElementById('scheduled-buttons').style.display = 'none';
          document.getElementById('reschedule-form').style.display = 'block';
        }
        function cancelReschedule() {
          document.getElementById('reschedule-form').style.display = 'none';
          document.getElementById('scheduled-buttons').style.display = 'flex';
        }
      </script>

    <?php elseif ($status === 'completed'): ?>
      <!-- Completed Interview -->
      <div class="details-section">
        <h3>Interview Details</h3>
        <p><span class="details-label">Date:</span> <?= $date ?></p>
        <p><span class="details-label">Time:</span> <?= $time ?></p>
        <p><span class="details-label">Interviewer:</span> <?= $interviewer ?></p>
      </div>

      <!-- Notes -->
      <div class="details-section">
        <h3>Notes</h3>
        <p><?= $interviewNotes ?></p>
      </div>

    <?php endif; ?>
  </main>
</body>
</html>
