<?php
session_start();
$servername = "localhost"; // Replace with your MySQL server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "supply"; // Replace with your MySQL database name

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store submitted values in session variables
    $_SESSION['cd'] = $_POST['cd'];
    $_SESSION['avl'] = $_POST['avl'];

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
    $stmt = $conn->prepare("INSERT INTO `igp-hd-document1` (cd, avl,`igp-no`) VALUES (?, ?,?)");
    
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ssi", $_SESSION['cd'], $_SESSION['avl'],$igpNo);

    // Execute the statement
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to the next page
    header("Location: preview.php");
    exit;
}
?>
<html>
<head>
    <title>document details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "nav.php" ?>
    <h1>DOCUMENT DETAILS</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="cd"> cd:</label>
        <input type="text" name="cd" required><br>
        <label for="avl"> AVL:</label>
        <input type="text" name="avl" required><br>
        <button class="custom-button1" type="button" onclick="window.location.href='vehicle.php'">Previous</button>
        <button class="custom-button" type="reset" value="Reset">Clear</button>
        <button class="custom-button" type="submit">Submit</button>
    </form>
</body>
</html>
