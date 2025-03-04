<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["api_url"])) {
    $api_url = filter_var($_POST["api_url"], FILTER_SANITIZE_URL);
    
    if (filter_var($api_url, FILTER_VALIDATE_URL)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($http_code !== 200) {
            $error = "Failed to fetch API response. HTTP Code: $http_code";
        } elseif ($response === false) {
            $error = "cURL Error: $error";
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
        <p style="color: red;">Error: <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
</body>
</html>
