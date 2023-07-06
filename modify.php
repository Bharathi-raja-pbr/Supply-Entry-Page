
<?php
$servername = "localhost"; // Replace with your MySQL server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "supply"; // Replace with your MySQL database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL statement to add unique property to igp-no column
$sql = "ALTER TABLE `igp-hd-document` ADD CONSTRAINT unique_igp_no UNIQUE (`igp-no`)";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Unique property added to igp-no column successfully.";
} else {
    echo "Error adding unique property: " . $conn->error;
}

// Close the connection
$conn->close();
?>
