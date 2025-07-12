<?php
require_once "../php/auth_shared.php";
require_once "../php/config.php";
require_once "../php/request_utils.php";
require_once "../php/maintenance.php";
runMaintenance($conn);

$requests = getVisibleRequests($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Board</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php include("navbar.php"); ?>

    <h1 class="page-header">Help board</h1>

    <main class="helpboard-grid">
        <?php foreach ($requests as $request): ?>
            <article class = "helpboard">
                <?php
                    $path = "../uploads/" . $request['attachment_path'];
                    if (!empty($request['attachment_path']) && file_exists($path)){
                        $mime = mime_content_type($path);
                        if (str_starts_with($mime, "image/")):
                ?>
                    <img src="<?= $path ?>" alt="Request Image" class = "helpboard-image">
                <?php
                        endif;
                    }
                ?>

                <div class = "helpboard-content">
                    <h2 class="helpboard-title">
                        <a class = "helpboard-title" href="helpboard_request.php?id=<?= $request['id'] ?>">
                            <?= htmlspecialchars($request['title']) ?>
                        </a>
                    </h2>

                    <p class = "author"><?= htmlspecialchars($request['requester_name']) ?></p>
                    <div class="category-tag">
                        <p><strong>Category:</strong><?= htmlspecialchars($request['category']) ?></p>
                    </div>
                    <p><?= nl2br(htmlspecialchars($request['description'])) ?></p>
                    <div class="deadline-tag">
                        <p><strong>Until:</strong><?= date("F j, Y", strtotime($request['deadline'])) ?></p>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </main>
</body>
</html>