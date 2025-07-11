<?php
    session_start();

    if(!isset($_SESSION['user'])){
        echo "<script>
            alert('You must be logged in to view the help board.');
            window.location.href = '../index.php';
        </script>";
        exit;
    }

    require "../php/config.php";
    require "../php/request_utils.php";

    $requestID = $_GET['id'] ?? null;
    if(!($requestID)){
        die("Missing request ID.");
    }

    $request = getRequestDetails($conn, $requestID);

    if (isset($_POST['submit_help'])){
        $userID = $_SESSION['user']['id'];
        $requestID = $_GET['id'];
        $proof_text = trim($_POST['help_note']) ?? null;
        $proof_file = null;

        if (isset($_FILES['help_proof']) && $_FILES['help_proof']['error'] == UPLOAD_ERR_OK){
            $filename = basename($_FILES['help_proof']['name']);
            $path = "../uploads/".$filename;

            if (move_uploaded_file($_FILES['help_proof']['tmp_name'], $path)){
                $proof_file = $filename;
            }
        }

            require_once "../php/helper_utils.php";
        $success = submitHelp($conn, $requestID, $userID, $proof_text, $proof_file);

        if ($success) {
            echo "<script>alert('Help submitted successfully!'); location.reload();</script>";
        } else {
            echo "<script>alert('You already submitted help for this request.');</script>";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request title</title>
    <link rel="stylesheet" href="../css/style.css?v=1.2">
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

        <form method="POST" enctype="multipart/form-data">
            <label class="help-toggle">
                <input type="checkbox" id="toggleHelped">
                <span class="help-button">I Helped</span>

                <div class="help-details">
                    <label for="help-note">How did you help?</label>
                    <textarea id="help-note" name="help_note" rows="4" placeholder="Add details here..."></textarea>

                    <label for="help-proof">Upload image proof:</label>
                    <input type="file" id="help-proof" name="help_proof">

                    <div class="verification-button">
                        <input type="submit" name="submit_help" value="Submit">
                    </div>
                </div>
            </label>
        </form>

        <div style="height: 100px;"></div>

        <div style="height: 100px;"></div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("toggleHelped");
        const details = document.querySelector(".help-details");

        details.style.display = "none";

        toggle.addEventListener("change", function () {
            if (toggle.checked) {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        });
        });
    </script>
        
</body>
</html>