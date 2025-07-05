<?php
require_once "config.php";
require_once "functions/request_utils.php";
require_once "functions/interview_utils.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $requestId = $_POST['request_id'];

        switch ($action) {
            case 'approve':
                approveRequest($conn, $requestId);
                break;
            case 'reject':
                rejectRequest($conn, $requestId);
                break;
            case 'mark_for_interview':
                $userId = $_POST['user_id']; // ID of requester
                markForInterview($conn, $requestId, $userId);
                break;
            case 'schedule_interview':
                $interviewId = $_POST['interview_id'];
                $datetime = $_POST['datetime'];
                scheduleInterview($conn, $interviewId, $datetime);
                break;
            case 'complete_interview':
                $interviewId = $_POST['interview_id'];
                $notes = $_POST['notes'] ?? null;
                completeInterview($conn, $interviewId, $notes);
                break;
            case 'cancel_interview':
                $interviewId = $_POST['interview_id'];
                cancelInterview($conn, $interviewId);
                break;
        }
    }
}



?>