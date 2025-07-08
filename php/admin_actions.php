<?php
require_once "config.php";
require_once "functions/request_utils.php";
require_once "functions/interview_utils.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = 'fail'; 

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $requestID = $_POST['request_id'];

        switch ($action) {
            case 'approve':
                $status = approveRequest($conn, $requestID);
                break;
            case 'reject':
                $status = rejectRequest($conn, $requestID);
                break;
            case 'mark_for_interview':
                if (isset($_POST['user_id'])){
                    $userID = $_POST['user_id'];
                    $status = markForInterview($conn, $requestID, $requestID);
                }
                break;
            default:
                $status = 'fail';
                break;
        }
    }

    header("Location: admin_requests.php?status=$status");
    exit;
}


?>