<?php
session_start();
$servername = "localhost"; // Replace with your MySQL server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "supply"; // Replace with your MySQL database name

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store submitted values in session variables
    $_SESSION['pkg_mod'] = $_POST['pkg-mod'];
    $_SESSION['no_of_pkg'] = $_POST['no-of-pkg'];
    $_SESSION['pkg_slno'] = $_POST['pkg-slno'];

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the igp_no from the igp-item table
    $sql = "SELECT `igp-no` FROM `igp-itm1` ORDER BY `igp-no` DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $igpNo = $row['igp-no'];
    } else {
        $igpNo = 0; // Set default value if no records exist
    }

    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO `igp-pkg1` (`pkg-mod`, `no-of-pkg`, `pkg-slno`, `igp-no`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $_SESSION['pkg_mod'], $_SESSION['no_of_pkg'], $_SESSION['pkg_slno'], $igpNo);

    // Execute the statement
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to the next page
    header("Location: escort.php");
    exit;
}
?>
<html>
<head>
    <title>package details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "nav.php"?>
    <h1>PACKAGE DETAILS</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="pkg-mod"> Package Mod</label>
        <input type="text" name="pkg-mod"><br>
        <label for="no-of-pkg">No of packages:</label>
        <input type="text" name="no-of-pkg"><br>
        <label for="pkg-slno">Package SNO:</label>
        <input type="text" name="pkg-slno"><br>
        <button class="custom-button1" type="button" onclick="window.location.href='details.php'">Previous</button>
        <button class="custom-button" type="reset" value="Reset">Clear</button>
        <button class="custom-button" type="submit">Next</button>
    </form>
</body>
</html>
