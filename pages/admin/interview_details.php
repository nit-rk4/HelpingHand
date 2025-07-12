<?php
require_once "../../php/auth_admin.php";
require_once "../../php/config.php";
require_once "../../php/interview_utils.php";

$interview_id = $_GET['id'] ?? null;

if (!$interview_id) {
  die("Missing interview ID.");
}

// Get interview details
$details = getInterviewDetails($conn, $interview_id);
if (!$details) {
  die("Interview not found.");
}

$status = $details['status'];
$applicant = $details['applicant'];
$phone = $details['contact_number'];
$request = $details['request_details'];
$date = $details['date'];
$time = $details['time'];
$interviewer = $details['interviewer_name'];
$interviewNotes = $details['notes'];
$admins = getAllAdmins($conn);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $notes = $_POST['notes'] ?? '';

  if (isset($_POST['confirm_schedule'])) {
    $schedule_date = $_POST['schedule_date'] ?? null;
    $schedule_time = $_POST['schedule_time'] ?? null;
    $interviewer_id = $_POST['interviewer'] ?? null;

    if ($schedule_date && $schedule_time && $interviewer_id) {
      scheduleInterview($conn, $interview_id, $schedule_date, $schedule_time, $interviewer_id);
      header("Location: interview_details.php?id=$interview_id&status=scheduled");
      exit;
    }
  }

  if (isset($_POST['confirm_reschedule'])) {
    $new_date = $_POST['new_date'] ?? null;
    $new_time = $_POST['new_time'] ?? null;
    $new_interviewer_id = $_POST['new_interviewer'] ?? null;

    if ($new_date && $new_time && $new_interviewer_id) {
      scheduleInterview($conn, $interview_id, $new_date, $new_time, $new_interviewer_id);
      header("Location: interview_details.php?id=$interview_id&status=scheduled");
      exit;
    }
  }

  if (isset($_POST['mark_done'])) {
    completeInterview($conn, $interview_id, $notes);
    header("Location: interview_details.php?id=$interview_id&status=completed");
    exit;
  }

  if (isset($_POST['cancel']) || isset($_POST['reject'])) {
    cancelInterview($conn, $interview_id);
    header("Location: admin_interviews.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Interview Details - HelpingHand Admin</title>
  <link rel="stylesheet" href="../../css/style.css" />
</head>

<body>

  <!-- NAVBAR -->
  <?php include("../navbar.php") ?>

  <!-- DETAILS WRAPPER -->
  <main class="details-wrapper">
    <a class="back-link" href="admin_interviews.php">← Back to Interviews</a>

    <?php
    echo '<h2>Interview with ' . htmlspecialchars($applicant) . '</h2>';
    ?>

    <!-- Interviewee Info -->
    <div class="details-section">
      <h3>Interviewee Details</h3>
      <p><span class="details-label">Name:</span> <?= htmlspecialchars($applicant) ?></p>
      <p><span class="details-label">Phone Number:</span> <?= htmlspecialchars($phone) ?></p>
    </div>

    <!-- Request Details -->
    <div class="details-section">
      <h3>Request Details</h3>
      <p><?= $request ?></p>
    </div>

    <?php if ($status === 'pending'): ?>
      <!-- Notes -->
      <div class="details-section">
        <h3>Schedule Interview</h3>
        <form method="post" class="form-container">
          <label>Date: <input type="date" name="schedule_date" required></label>
          <label>Time: <input type="time" name="schedule_time" required></label>
          <label>Interviewer:
            <select name="interviewer" required>
              <option value="">Select Admin</option>
              <?php foreach ($admins as $admin): ?>
                <option value="<?= $admin['id'] ?>"><?= htmlspecialchars($admin['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </label>
          <div class="details-buttons">
            <button type="submit" name="confirm_schedule" class="btn-confirm">CONFIRM SCHEDULE</button>
            <button type="submit" name="reject" class="btn-reject">CANCEL</button>
          </div>
        </form>
      </div>

      <?php elseif ($status === 'scheduled'): ?>
        <!-- Scheduled: View schedule + reschedule + mark done -->
        <div class="details-section">
          <h3>Schedule Details</h3>
          <p><span class="details-label">Date:</span> <?= htmlspecialchars($date) ?></p>
          <p><span class="details-label">Time:</span> <?= date("g:i A", strtotime($time)) ?></p>
          <p><span class="details-label">Interviewer:</span> <?= htmlspecialchars($interviewer) ?></p>
        </div>

      <!-- Notes -->
      <div class="details-section">
        <h3>Interview Notes</h3>
        <form method="post">
          <textarea name="notes" rows="3" required><?= htmlspecialchars($interviewNotes) ?></textarea>
          <div class="details-buttons">
            <button type="submit" name="mark_done" class="btn-accept">MARK AS DONE</button>
            <button type="button" class="btn-neutral" onclick="showRescheduleForm()">RESCHEDULE</button>
            <button type="submit" name="cancel" class="btn-reject">CANCEL</button>
          </div>
        </form>
      </div>

      <!-- Reschedule Form -->
      <form method="post" id="reschedule-form" class="form-container" style="display: none;">
        <h3>Reschedule Interview</h3>
        <label>New Date: <input type="date" name="new_date" required></label>
        <label>New Time: <input type="time" name="new_time" required></label>
        <label>Interviewer:
          <select name="new_interviewer" required>
            <option value="">Select Admin</option>
            <?php foreach ($admins as $admin): ?>
              <option value="<?= $admin['id'] ?>" <?= ($admin['name'] == $interviewer) ? 'selected' : '' ?>>
                <?= htmlspecialchars($admin['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </label>
        <div class="details-buttons">
          <button type="submit" name="confirm_reschedule" class="btn-confirm">CONFIRM</button>
          <button type="button" class="btn-reject" onclick="cancelReschedule()">CANCEL</button>
        </div>
      </form>

      <script>
        function showRescheduleForm() {
          document.getElementById('reschedule-form').style.display = 'block';
        }

        function cancelReschedule() {
          document.getElementById('reschedule-form').style.display = 'none';
        }
      </script>

      <?php elseif ($status === 'completed'): ?>
        <!-- Completed Interview -->
        <div class="details-section">
          <h3>Interview Details</h3>
          <p><span class="details-label">Date:</span> <?= htmlspecialchars($date) ?></p>
          <p><span class="details-label">Time:</span> <?= date("g:i A", strtotime($time)) ?></p>
          <p><span class="details-label">Interviewer:</span> <?= htmlspecialchars($interviewer) ?></p>
        </div>

        <div class="details-section">
          <h3>Notes</h3>
          <p><?= nl2br(htmlspecialchars($interviewNotes)) ?></p>
        </div>
      <?php endif; ?>
  </main>
</body>

</html>
