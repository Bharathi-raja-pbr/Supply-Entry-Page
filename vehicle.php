<?php
session_start();
$servername = "localhost"; // Replace with your MySQL server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "supply"; // Replace with your MySQL database name

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store submitted values in session variables
    $_SESSION['veh_no'] = $_POST['veh-no'];
    $_SESSION['lr_no'] = $_POST['lr-no'];
    $_SESSION['lr_dt'] = $_POST['lr-dt'];

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
    $stmt = $conn->prepare("INSERT INTO `ig-veh1` (`veh-no`, `lr-no`, `lr-dt`,`igp-no`) VALUES (?, ?, ?,?)");
    $stmt->bind_param("sssi", $_SESSION['veh_no'], $_SESSION['lr_no'], $_SESSION['lr_dt'],$igpNo);

    // Execute the statement
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to the next page
    header("Location: documents.php");
    exit;
}
?>
<html>
<head>
    <title>vehicle details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "nav.php" ?>
    <h1>VEHICLE DETAILS</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="veh-no">Vehicle No:</label>
        <input type="text" id="vehNo" name="veh-no" required><br>
        <label for="lr-no">Lorry Reciept number:</label>
        <input type="text" id="lrNo" name="lr-no"><br>
        <label for="lr-dt">Lorry Reciept Date:</label>
        <input type="date" id="lrDate" name="lr-dt"><br>
        <button class="custom-button1" type="button" onclick="window.location.href='escort.php'">Previous</button>
        <button class="custom-button" type="reset" value="Reset">Clear</button>
        <button class="custom-button" type="submit">Next</button>
    </form>
</body>
</html>
