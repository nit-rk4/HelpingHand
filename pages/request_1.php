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
        <h1 class="req-title">Request title</h1>
        <div class="container">
            <div class="content">
                <div class="req-info">
                    <h2>Posted by: Requester Name</h2>
                    <div class="category-tag">
                        <p><strong>Category:</strong> Home and Tech help</p>
                    </div> 
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusamus blanditiis at quia quo molestiae fugiat. Neque quod qui similique id consectetur excepturi! Maxime iure magnam rerum incidunt! Minus, deserunt soluta?</p>

                </div>

                <div class="contact-info">
                    <h2>Support Requester!</h2>
                    <p>Contact information: +639 123 456 789</p>
                    <p>Email: juandelacruz@gmail.com</p>
                    <div class="deadline-tag">
                        <p><strong>Until:</strong> December 25, 2025</p>
                    </div> 
                    
                </div>
            </div>

            <div class="image-container">
                <img src="../assets/image.jpg" alt="Request">
            </div>
        </div>

        <label class="help-toggle">
            <input type="checkbox" id="toggleHelped">
            <span class="help-button">I Helped</span>
        </label>

    </main>

    
</body>
</html>