<?php
require_once "config.php";
require_once "functions/request_utils.php";

$status = $_GET['status'] ?? null;
$tier = $_GET['tier'] ?? null;
$userId = $_GET['user_id'] ?? null;

if ($userId) {
    $requests = getUserRequests($conn, $userId); // You'll define this later
} else if ($status) {
    $requests = getRequestsByStatus($conn, $status, $tier);
} else {
    $requests = getVisibleRequests($conn);
}

echo "<pre>Status: $status | Tier: $tier | User ID: $userId</pre>";
print_r($requests);

// JOIN user name manually using getRequestDetails
foreach ($requests as $req) {
    $details = getRequestDetails($conn, $req['id']); // includes requester name

    $visibleMark = $req['visible_since'] ? 'Visible' : 'Hidden'; // or ❌
    
    echo "<a href='request-details.php?id={$req['id']}' class='request-row' data-status='{$req['status']}'>";
    echo "<span class='user'>" . htmlspecialchars($details['requester_name']) . "</span>";
    echo "<span class='title'>" . htmlspecialchars($req['title']) . "</span>";
    echo "<span class='desc'>" . htmlspecialchars($req['description']) . "</span>";
    echo "<span class='category'>" . htmlspecialchars($req['category']) . "</span>";
    echo "<span class='visible'>" . $visibleMark . "</span>";
    echo "</a>";
}
?>
