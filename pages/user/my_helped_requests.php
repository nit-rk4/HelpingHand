<?php
require_once "../../php/auth_user.php";
require_once "../../php/config.php";
require_once "../../php/help_utils.php";
require_once "../../php/maintenance.php";
runMaintenance($conn);

$userID = $_SESSION['auth']['id'];
$requests = getHelpedRequests($conn, $userID);

$categoryCounts = [];
foreach ($requests as $req) {
    if($req['is_verified'] != 1) continue;
    $group = categorizeHelp($req['category']);
    if (!isset($categoryCounts[$group])) {
        $categoryCounts[$group] = 0;
    }
    $categoryCounts[$group]++;
}

$categoryColors = [
    'Goods & Essentials' => '#ffb347',     
    'Community Help'     => '#87cefa',     
    'Knowledge Sharing'  => '#90ee90',     
    'Medical & Legal'    => '#f67280',     
    'Financial Aid'      => '#9b59b6',     
    'Others'             => '#95a5a6',     
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Helped Requests - HelpingHand</title>
  <link rel="stylesheet" href="../../css/style.css?v=2.1">
</head>
<body>
  <?php include ("../navbar.php"); ?>

  <div class="container">
    <aside class="sidebar">
      <ul>
        <li><a href="submit_request.php">Submit a Request</a></li>
        <li class="active"><a href="user_requests.php">My Requests</a></li>
        <li><a href="my_helped_requests.php">Requests I Helped On</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <h2>Help Count Summary</h2>
      <section class="help-count-section">
        <h2>Help Count</h2>
          <?php
            $total = array_sum($categoryCounts);
            $conicGradient = '';

            if ($total > 0) {
              $start = 0;
              $segments = [];

              foreach ($categoryCounts as $group => $count) {
                $percent = $count / $total;
                $deg = $percent * 360;
                $color = $categoryColors[$group];
                $end = $start + $deg;
                $segments[] = "$color {$start}deg {$end}deg";
                $start = $end;
              }

              $conicGradient = "conic-gradient(" . implode(', ', $segments) . ")";
            } else {
              // fallback solid gray
              $conicGradient = "#eee";
            }
          ?>
          <div class="donut-chart" role="img" aria-label="Help points distribution" style="background: <?= $conicGradient ?>;">
            <div class="donut-center">
              <span class="total"><?= $total ?></span>
              <span>pts</span>
            </div>
          </div>

        <?php if ($total > 0): ?>
          <div class="donut-legend">
            <?php foreach ($categoryCounts as $group => $count): ?>
              <div>
                <span class="legend-box" style="background-color: <?= $categoryColors[$group] ?>;"></span>
                <?= htmlspecialchars($group) ?> (<?= $count ?>)
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </section>

      <h2>My Helped Requests</h2>
      <div class="my-helped-section">
        <div class="helped-requests-list">
          <?php if (count($requests) > 0): ?>
            <?php foreach ($requests as $i => $r): ?>
              <div class="request-card">
                <div class="card-row">
                  <div class="request-info">
                    <div class="request-title"><?= htmlspecialchars($r['title'])?></div>
                    <div class="request-meta">
                      <?php if ($r['is_verified']): ?>
                        <span class="status-tag fulfilled">Help Verified</span>
                      <?php elseif ($r['is_verified'] === 0 && $r['status'] === 'fulfilled'): ?>
                        <span class="status-tag unverified">Unverified Help</span>
                      <?php else: ?>
                        <span class="status-tag pending">Verification Pending</span>
                      <?php endif; ?>
                      <span class="requester">Requester: <?= htmlspecialchars($r['requester_name']) ?></span>
                    </div>
                  </div>
                  <div class="button-wrapper">
                    <button class="submit-btn" onclick="toggleDetails('details-req<?= $i ?>')">View Details</button>
                  </div>
                </div>

                <div class="request-details" id="details-req<?=$i?>" style="display: none;">
                  <p><strong>Category:</strong><?= htmlspecialchars($r['category']) ?></p>
                  <p><?= htmlspecialchars($r['description']) ?></p>
                  <p><strong>Contact:</strong><?= htmlspecialchars($r['requester_contact']) ?> | <?= htmlspecialchars($r['requester_email']) ?></p>
                  <?php if (!empty($r['proof_text'])): ?>
                    <p><strong>Your Help Note:</strong><br><em><?= htmlspecialchars($r['proof_text']) ?></em></p>
                  <?php endif; ?>

                  <?php if (!empty($r['proof_file'])): ?>
                    <p><strong>Your Proof File:</strong><br>
                      <a href="../../uploads/<?= htmlspecialchars($r['proof_file']) ?>" target="_blank">📎 View File</a>
                    </p>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>You haven't helped any requests yet.</p>
          <?php endif; ?>
        </div>
      </div>
    </main>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const cards = document.querySelectorAll('.request-card');

      cards.forEach(card => {
        const button = card.querySelector('.submit-btn');
        const details = card.querySelector('.request-details');

        if (button && details) {
          button.addEventListener('click', function () {
            const isVisible = details.style.display === 'block';
            details.style.display = isVisible ? 'none' : 'block';
          });
        }
      });
    });
  </script>

</body>
</html>