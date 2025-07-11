<?php
    require "../php/config.php";
    require "../php/request_utils.php";

    $requestID = $_GET['id'] ?? null;
    if(!($requestID)){
        die("Missing request ID.");
    }

    $request = getRequestDetails($conn, $requestID);
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

        <label class="help-toggle">
            <input type="checkbox" id="toggleHelped">
            <span class="help-button">I Helped</span>

              <div class="help-details">
                <!-- <form> -->
                    <label for="help-note">How did you help?</label>
                    <textarea id="help-note" name="help-note" rows="4" placeholder="Add details here..."></textarea>

                    <label for="help-proof">Upload image proof:</label>
                    <input type="file" id="help-proof" name="help-proof">

                    <div class="verification-button">
                        <input type="submit" value="Submit">
                    </div>
                <!-- </form> -->
            </div>
        </label>

        <div style="height: 100px;"></div>

        <div style="height: 100px;"></div>
    </main>

    
</body>
</html>