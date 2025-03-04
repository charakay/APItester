<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["api_url"])) {
    $api_url = filter_var($_POST["api_url"], FILTER_SANITIZE_URL);
    
    if (filter_var($api_url, FILTER_VALIDATE_URL)) {
        $response = @file_get_contents($api_url);
        if ($response === FALSE) {
            $error = "Failed to fetch API response.";
        }
    } else {
        $error = "Invalid URL.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP API Caller</title>
</head>
<body>
    <h1>API Caller</h1>
    <form method="POST">
        <input type="text" name="api_url" placeholder="Enter API Endpoint URI" required>
        <button type="submit">Call API</button>
    </form>
    <?php if (!empty($response)) : ?>
        <h3>Response:</h3>
        <pre><?php echo htmlspecialchars($response, ENT_QUOTES, 'UTF-8'); ?></pre>
    <?php elseif (!empty($error)) : ?>
        <p style="color: red;">Error: <?php echo $error; ?></p>
    <?php endif; ?>
</body>
</html>
