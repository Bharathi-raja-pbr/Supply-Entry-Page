<?php
session_start();
$servername = "localhost"; // Replace with your MySQL server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "supply"; // Replace with your MySQL database name

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store submitted values in session variables
    $_SESSION['escrt_id'] = $_POST['escrt-id'];
    $_SESSION['escrt_nam'] = $_POST['escrt-nam'];
    $_SESSION['escrt_desg'] = $_POST['escrt-desg'];

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `igp-no` FROM `igp-itm1` ORDER BY `igp-no` DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $igpNo = $row['igp-no'];
    } else {
        $igpNo = 0; // Set default value if no records exist
    }

    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO `ig-escrt1` (`escrt-id`, `escrt-nam`, `escrt-desg`,`igp-no`) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("sssi", $_SESSION['escrt_id'], $_SESSION['escrt_nam'], $_SESSION['escrt_desg'], $igpNo);
    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to the next page
    header("Location: vehicle.php");
    exit;
}
?>

<html>
<head>
    <title>escort details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "nav.php" ?>
    <h1>ESCORT DETAILS</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="escrt-id"> Escort id :</label>
        <input type="text" name="escrt-id"><br>
        <label for="escrt-nam">Escort Name:</label>
        <input type="text" name="escrt-nam"><br>
        <label for="escrt-desg">Escort Designation:</label>
        <input type="text" name="escrt-desg"><br>
        <button class="custom-button1" type="button" onclick="window.location.href='pkg_details.php'">Previous</button>
        <button class="custom-button" type="reset" value="Reset">Clear</button>
        <button class="custom-button" type="submit">Next</button>
    </form>
</body>
</html>
