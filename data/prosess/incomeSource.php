<?php
require '../components/creds.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["incomesource"])) {
        $sourceName = $_POST["incomesource"];

        // Check if $sourceName is not empty
        if (!empty($sourceName)) {
            // Insert the source into the 'incomesource' table
            $insertSourceSQL = "INSERT INTO incomesource (incomesource_name) VALUES (:incomesourceName)";
            $stmt = $conn->prepare($insertSourceSQL);
            $stmt->bindParam(':incomesourceName', $sourceName);
            $stmt->execute();

            // Redirect back to the referring page
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
            header("Location: $referer");
            exit();
        } else {
            // Handle the case where $sourceName is empty
            echo "Source name cannot be empty.";
        }
    } else {
        // Handle the case where "source" key is not set in $_POST
        echo "Source key is not set in the POST data.";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$conn = null;
?>
