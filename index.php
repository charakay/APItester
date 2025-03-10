<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["api_url"])) {
    $api_url = filter_var($_POST["api_url"], FILTER_SANITIZE_URL);
    $method = $_POST["method"] ?? "GET"; // Default to GET if no method is selected
    $bearer_token = $_POST["bearer_token"] ?? ''; // Optional Bearer token

    if (filter_var($api_url, FILTER_VALIDATE_URL)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        // Set HTTP method
        if ($method === "POST") {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST)); // If POST, send form data
        }
        
        // Add Bearer Token for Authorization if provided
        if (!empty($bearer_token)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer " . $bearer_token
            ]);
        }

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        // Log output to stdout
        if ($http_code !== 200) {
            $error_message = "Failed to fetch API response. HTTP Code: $http_code";
            error_log($error_message); // Log to stdout (or file depending on server config)
        } elseif ($response === false) {
            $error_message = "cURL Error: $error";
            error_log($error_message); // Log to stdout
        } else {
            // Log the successful response to stdout
            error_log("API Response: " . substr($response, 0, 200)); // Limit response size for readability
        }
    } else {
        $error_message = "Invalid URL.";
        error_log($error_message); // Log invalid URL to stdout
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
        <input type="text" name="api_url" placeholder="Enter API Endpoint URI" required><br><br>
        
        <label for="method">Select Method:</label>
        <select name="method" id="method">
            <option value="GET">GET</option>
            <option value="POST">POST</option>
        </select><br><br>
        
        <label for="bearer_token">Bearer Token (Optional):</label>
        <input type="text" name="bearer_token" placeholder="Enter Bearer Token"><br><br>
        
        <button type="submit">Call API</button>
    </form>
    
    <?php if (!empty($response)) : ?>
        <h3>Response:</h3>
        <pre><?php echo htmlspecialchars($response, ENT_QUOTES, 'UTF-8'); ?></pre>
    <?php elseif (!empty($error_message)) : ?>
        <p style="color: red;">Error: <?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
</body>
</html>
