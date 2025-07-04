<?php

//Get requests from database
function getRequests($conn, $status, $tier = null){
    //No tier filter
    if ($tier === null){
        $sql = "SELECT * FROM requests where status = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $status);
    } else { //Yes tier filter 
        $sql = "SELECT * FROM requests WHERE status = ? AND tier = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $status, $tier);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result ($stmt);

    $requests = []; //Creates an associative array of the requests.
    while ($row = mysqli_fetch_assoc($result)){
        $requests[] = $row;
    }

    return $requests;
}

//Updates the status of request to 'approved'
function approveRequest($conn, $requestID){
    //Gets tier, for_interview, and interview_completed from specific request
    $sql = "SELECT tier, for_interview, interview_completed FROM requests WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $requestID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)){ //If request ID exists
        //Assigns fetched data into variables
        $tier = $row['tier'];
        $forInterview = $row['for_interview'];
        $interviewDone = $row['interview_completed'];

        //Checks if tier 3 requests are eligible to be approved
        if ($tier === '3'){
            if (!$interviewDone){
                //Not approved because interview must be done before approving request
                return "[X] Interview must be completed before approving the request.";
            }
        }

        //Checks if tier 2 requests are eligible to be approved
        if ($tier === '2' && $forInterview && !$interviewDone){
            //Approves request but sends a warning that the interveiw is not yet done
            error_log("[!] Approving tier 2 request with interview not completed.");
        }

        $updateSQL = "UPDATE requests SET status = 'approved', is_visible = 1 WHERE id = ?";
        $update_stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($update_stmt, "i", $requestID);

        if (mysqli_stmt_execute($update_stmt)){
            return true; //Updating status of request is a success
        } else {
            return "[X] Database error: could not approve request.";
        }
    } else {
        return "[!] Request not found.";
    }
}



?>