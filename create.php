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

// SQL query to create a table
$sql = "CREATE TABLE `igp-hd-document` (
    `igp-no` char(10) NOT NULL,
    `cd` char(2) NOT NULL,
    `avl` char(1) NOT NULL
)";

/*$sql = "CREATE TABLE `igp-hd1` (
  `igp-no` char(10) NOT NULL,
  `igp-dt` date NOT NULL,
  `igp-act-dt` date NOT NULL,
  `igp-tim` char(10) NOT NULL,
  `ref-docno` char(10) NOt NULL,
  `ref-docdt` date NOT NULL,
  `ref-sec` char(3) NOT NULL default 32,
  `igp-stat` char(1) NOT NULL default 'G', 
  `migp-no` char(10)
)";*/

/*$sql = "CREATE TABLE `igp-itm` (
  `igp-no` char(10) NOT NULL,
  `dc-rec-no` char(20) NOT NULL,
  `dc-rec-dt` date NOT NULL,
  `igp-itmcd` char(23) NOT NULL,
  `vend-nam` char(40),
  `igp-au` char(2) NOT NULL,
  `igp-itmqty` decimal(14) NOT NULL,
  `rb-no` char(10), 
  `igp-itmstat` char(1) default 'G' NOT NULL,
  `send-epcd` char(10),
  `send-epdes` char(80),
  `migp-no` char(10),
  `migp-sl` smallint
)";*/

if ($conn->query($sql) === true) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close the connection
$conn->close();
?>
