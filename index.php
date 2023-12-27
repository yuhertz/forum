<?php
$log_file_path = 'log.txt';

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $text = $_POST['text'] ?? '';

    if (!empty($username) && !empty($text)) {
        // Open the file in append mode
        $log_file = fopen($log_file_path, 'a');

        if ($log_file) {
            // Sanitize user input before writing to the log file
            $username = htmlspecialchars($username);
            $text = htmlspecialchars($text);

            // Append the username and message to the file
            fwrite($log_file, "$username\n$text\n\n");

            // Close the file
            fclose($log_file);
            echo "Username and Message logged successfully.";
        } else {
            echo "Error opening log file.";
        }
    } else {
        echo "Username or message is empty.";
    }
}

// Read and display the log file
$log_lines = file($log_file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Logger</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            margin-bottom: 20px;
        }

        .message-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        h2 {
            margin-bottom: 10px;
        }

        .message-container p strong {
            font-weight: bold;
        }

        .message-container p u {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="text">Your Message:</label>
        <input type="text" id="text" name="text" required>
        <br>
        <button type="submit">Upload</button>
    </form>

    <h2 style="font-size:40px;">Messages</h2>

    <?php foreach ($log_lines as $index => $line): ?>
        <?php if ($index % 2 === 0): ?>
            <div class="message-container">
                <p><strong><u><?php echo htmlspecialchars($line); ?></u></strong></p>
        <?php else: ?>
                <p><?php echo htmlspecialchars($line); ?></p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>
