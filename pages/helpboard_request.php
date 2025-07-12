<?php
require_once "../php/auth_shared.php";
require_once "../php/config.php";
require_once "../php/request_utils.php";
require_once "../php/help_utils.php";

$requestID = $_GET['id'] ?? null;
if(!($requestID)){
    die("Missing request ID.");
}

$userID = $_SESSION['auth']['id']?? null;
$hasHelped = false;

if ($userID && $requestID){
    $hasHelped = hasHelped($conn, $requestID, $userID);
}

$request = getRequestDetails($conn, $requestID);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_help_action'])) {
    $userID = $_SESSION['auth']['id'];
    $action = $_POST['toggle_help_action'];

    if ($action === "submit") {
        $proof_text = trim($_POST['help_note']) ?? null;
        $proof_file = null;

        if (isset($_FILES['help_proof']) && $_FILES['help_proof']['error'] === UPLOAD_ERR_OK) {
            $filename = basename($_FILES['help_proof']['name']);
            $upload_path = "/uploads/" . $filename;
            if (move_uploaded_file($_FILES['help_proof']['tmp_name'], $upload_path)) {
                $proof_file = $filename;
            }
        }

        $success = submitHelp($conn, $requestID, $userID, $proof_text, $proof_file);
    } elseif ($action === "remove") {
        removeHelp($conn, $requestID, $userID);
    }

    header("Location: helpboard_request.php?id=" . $requestID);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($request['title'])?></title>
    <link rel="stylesheet" href="/css/style.css?v=1.3">
</head>

<body>
    <?php include("navbar.php"); ?>

    <main class="req-page">
        <h1 class="req-title"><?= htmlspecialchars($request['title']) ?></h1>
        <div class="container">
            <div class="content">
                <div class="req-info">
                    <h2>Posted by: <?= htmlspecialchars($request['requester_name'])?></h2>
                    <div class="category-tag">
                        <p><strong>Category:</strong> <?= htmlspecialchars($request['category'])?></p>
                    </div> 
                    <p><?= htmlspecialchars($request['description'])?></p>

                </div>

                <div class="contact-info">
                    <h2>Support Requester!</h2>
                    <p>Contact information: <?= htmlspecialchars($request['requester_contact'])?></p>
                    <p>Email: <?= $request['requester_email']?></p>
                    <div class="deadline-tag">
                        <p><strong>Until:</strong><?= date("F j, Y", strtotime($request['deadline'])) ?></p>
                    </div> 
                    
                </div>
            </div>

            <div class="image-container">
                <?php
                    $path = "../uploads/" . $request['attachment_path'];
                    if (!empty($request['attachment_path']) && file_exists($path)){
                        $mime = mime_content_type($path);
                        if (str_starts_with($mime, "image/")):
                ?>
                    <img src="<?= $path ?>" alt="<?= htmlspecialchars($request['title'])?> Image" class = "helpboard-image">
                <?php
                        endif;
                    }
                ?>
            </div>
        </div>

        <!-- Only show "I Helped" button to users(not admins) that don't own the request -->
        <?php if (($_SESSION['auth']['type']) === 'user' && $_SESSION['auth']['id'] !== $request['user_id']):?> 
            <form method="POST" enctype="multipart/form-data" id="helpForm">
                <input type="hidden" name="toggle_help_action" value="<?= $hasHelped ? 'remove' : 'submit' ?>">

                <label class="help-toggle <?= $hasHelped ? 'active' : '' ?>" id="helpToggle">
                    <span class="help-button"><?= $hasHelped ? 'Helped!' : 'I Helped' ?></span>
                </label>

                <?php if (!$hasHelped): ?>
                <div class="help-details" id="helpDetails" style="display:none;">
                    <label for="help-note">How did you help?</label>
                    <textarea id="help-note" name="help_note" rows="4" placeholder="Add details here..."></textarea>

                    <label for="help-proof">Upload image proof:</label>
                    <input type="file" id="help-proof" name="help_proof">

                    <div class="verification-button">
                        <input type="submit" value="Submit">
                    </div>
                </div>
                <?php endif; ?>
            </form>
        <?php endif; ?>

        <div style="height: 100px;"></div>

        <div style="height: 100px;"></div>
    </main>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const toggle = document.getElementById("helpToggle");
        const form = document.getElementById("helpForm");
        const actionInput = form.querySelector("input[name='toggle_help_action']");
        const details = document.getElementById("helpDetails");
        const helped = toggle.classList.contains("active");

        toggle.addEventListener("click", (e) => {
            if (e.target.closest(".verification-button")) return;

            e.preventDefault();

            if (helped) {
                actionInput.value = "remove";
                form.submit();
            } else {
                if (details) {
                    details.style.display = "flex";
                }
            }
        });

        form.addEventListener("submit", () => {
            actionInput.value = "submit";
        });
    });
    </script>

</body>
</html>