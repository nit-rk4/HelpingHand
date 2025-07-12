<?php
require_once '../../php/config.php';

$interview_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$status = 'pending';
$applicant = '';
$phone = '';
$request = '';
$date = '';
$time = '';
$interviewer = '';
$interviewNotes = '';
$admins = [];

// Fetch admins for dropdown
$admin_sql = "SELECT id, name FROM admins";
$admin_result = $conn->query($admin_sql);
if ($admin_result && $admin_result->num_rows > 0) {
  while ($row = $admin_result->fetch_assoc()) {
    $admins[] = $row;
  }
}

if ($interview_id) {
  $sql = "SELECT i.*, u.name as applicant, u.contact_number, r.details as request_details, a.name as interviewer_name FROM interviews i JOIN users u ON i.user_id = u.id JOIN requests r ON i.request_id = r.id LEFT JOIN admins a ON i.conducted_by = a.id WHERE i.id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $interview_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($row = $result->fetch_assoc()) {
    $status = $row['status'];
    $applicant = $row['applicant'];
    $phone = $row['contact_number'];
    $request = $row['request_details'];
    $date = $row['scheduled_at'] ? date('Y-m-d', strtotime($row['scheduled_at'])) : '';
    $time = $row['scheduled_at'] ? date('H:i', strtotime($row['scheduled_at'])) : '';
    $interviewer = $row['conducted_by'];
    $interviewNotes = $row['notes'];
  }
  $stmt->close();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['confirm_schedule'])) {
    $schedule_date = $_POST['schedule_date'];
    $schedule_time = $_POST['schedule_time'];
    $interviewer_id = $_POST['interviewer'];
    $notes = $_POST['notes'];
    $scheduled_at = $schedule_date . ' ' . $schedule_time;
    $update_sql = "UPDATE interviews SET scheduled_at=?, conducted_by=?, notes=?, status='scheduled' WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('sisi', $scheduled_at, $interviewer_id, $notes, $interview_id);
    $stmt->execute();
    $stmt->close();
    header("Location: interview_details.php?id=$interview_id&status=scheduled");
    exit;
  }
  if (isset($_POST['confirm_reschedule'])) {
    $new_date = $_POST['new_date'];
    $new_time = $_POST['new_time'];
    $new_interviewer_id = $_POST['new_interviewer'];
    $notes = $_POST['notes'];
    $scheduled_at = $new_date . ' ' . $new_time;
    $update_sql = "UPDATE interviews SET scheduled_at=?, conducted_by=?, notes=?, status='scheduled' WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('sisi', $scheduled_at, $new_interviewer_id, $notes, $interview_id);
    $stmt->execute();
    $stmt->close();
    header("Location: interview_details.php?id=$interview_id&status=scheduled");
    exit;
  }
  if (isset($_POST['mark_done'])) {
    $notes = $_POST['notes'];
    $update_sql = "UPDATE interviews SET notes=?, status='done' WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('si', $notes, $interview_id);
    $stmt->execute();
    $stmt->close();
    header("Location: interview_details.php?id=$interview_id&status=completed");
    exit;
  }
  if (isset($_POST['cancel']) || isset($_POST['reject'])) {
    $update_sql = "UPDATE interviews SET status='pending' WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('i', $interview_id);
    $stmt->execute();
    $stmt->close();
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
        <h3>Notes</h3>
        <form method="post" id="schedule-form" class="form-container">
          <textarea name="notes" rows="3" placeholder="Enter notes here..." required><?= htmlspecialchars($interviewNotes) ?></textarea>
          <label>Date: <input type="date" name="schedule_date" required></label>
          <label>Time: <input type="time" name="schedule_time" required></label>
          <label>Interviewer:
            <select name="interviewer" required>
              <option value="">Select Admin</option>
              <?php foreach ($admins as $admin): ?>
                <option value="<?= $admin['id'] ?>" <?= ($admin['id'] == $interviewer) ? 'selected' : '' ?>><?= htmlspecialchars($admin['name']) ?></option>
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
      <!-- Schedule Details -->
      <div class="details-section">
        <h3>Schedule Details</h3>
        <p><span class="details-label">Date:</span> <?= htmlspecialchars($date) ?></p>
        <p><span class="details-label">Time:</span> <?= htmlspecialchars($time) ?></p>
        <p><span class="details-label">Interviewer:</span> <?= htmlspecialchars($interviewer) ?></p>
      </div>

      <!-- Notes -->
      <div class="details-section">
        <h3>Notes</h3>
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
              <option value="<?= $admin['id'] ?>" <?= ($admin['id'] == $interviewer) ? 'selected' : '' ?>><?= htmlspecialchars($admin['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <textarea name="notes" rows="3" required><?= htmlspecialchars($interviewNotes) ?></textarea>
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
        <p><span class="details-label">Time:</span> <?= htmlspecialchars($time) ?></p>
        <p><span class="details-label">Interviewer:</span> <?= htmlspecialchars($interviewer) ?></p>
      </div>

      <!-- Notes -->
      <div class="details-section">
        <h3>Notes</h3>
        <p><?= nl2br(htmlspecialchars($interviewNotes)) ?></p>
      </div>

    <?php endif; ?>
  </main>
</body>

</html>
