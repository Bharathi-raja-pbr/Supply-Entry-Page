<?php
session_start();
$servername = "localhost"; // Replace with your MySQL server name
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "supply"; // Replace with your MySQL database name

$insertStatus = ""; // Variable to track insertion status

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store submitted values in session variables
    $_SESSION['ref_docno'] = $_POST['ref-docno'];
    $_SESSION['ref_docdt'] = $_POST['ref-docdt'];
    $_SESSION['ref_sec'] = $_POST['ref-sec'];
    $_SESSION['dc_rec_no'] = $_POST['dc-rec-no'];
    $_SESSION['dc_rec_dt'] = $_POST['dc-rec-dt'];
    $_SESSION['igp_itmcd'] = $_POST['igp-itmcd'];
    $_SESSION['vend_name'] = $_POST['vend-name'];
    $_SESSION['igp_au'] = $_POST['igp-au'];
    $_SESSION['igp_itmqty'] = $_POST['igp-itmqty'];
    $_SESSION['rb_no'] = $_POST['rb-no'];
    $_SESSION['send_epcd'] = $_POST['send-epcd'];
    $_SESSION['send_epds'] = $_POST['send-epds'];
    $_SESSION['migp_no'] = $_POST['migp-no'];
    $_SESSION['migp_sl'] = $_POST['migp-sl'];

    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");
    $stat='G';
    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the last igp-no from the table
    $sql = "SELECT `igp-no` FROM `igp-hd1` ORDER BY `igp-no` DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastIgpNo = $row['igp-no'];
        $nextIgpNo = $lastIgpNo + 1;
    } else {
        $nextIgpNo = 0; // Set default value if no records exist
    }

// ...

// Prepare and bind the INSERT statements for each table
$stmt1 = $conn->prepare("INSERT INTO `igp-hd1`(`igp-no`, `igp-dt`, `igp-act-dt`, `igp-tim`, `ref-docno`, `ref-docdt`, `ref-sec`, `igp-stat`, `migp-no`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt1->bind_param("issssssss", $nextIgpNo, $currentDate, $currentDate, $currentTime, $_SESSION['ref_docno'], $_SESSION['ref_docdt'], $_SESSION['ref_sec'], $stat, $_SESSION['migp_no']);

$stmt2 = $conn->prepare("INSERT INTO `igp-itm1` (`igp-no`, `dc-rec-no`, `dc-rec-dt`, `igp-itmcd`, `vend-nam`, `igp-au`, `igp-itmqty`, `rb-no`, `igp-itmstat`, `send-epcd`, `send-epdes`, `migp-no`, `migp-sl`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt2->bind_param("issssssssssss", $nextIgpNo,  $_SESSION['dc_rec_no'], $_SESSION['dc_rec_dt'], $_SESSION['igp_itmcd'], $_SESSION['vend_name'], $_SESSION['igp_au'], $_SESSION['igp_itmqty'], $_SESSION['rb_no'], $stat, $_SESSION['send_epcd'], $_SESSION['send_epds'], $_SESSION['migp_no'], $_SESSION['migp_sl']);

// Execute the statements
if ($stmt1->execute() && $stmt2->execute()) {
    echo "Data inserted successfully.";
} else {
    echo "Error inserting data: " . $conn->error;
}

// Close the statements and connection
$stmt1->close();
$stmt2->close();
$conn->close();

// Redirect to pkg_details.php
header("Location: pkg_details.php");
exit;

// ...
}
?>

<html>
<head>
    <title>supply details</title>
    <style>
        h1 {
            text-align: center;
        }
        h1.headline {
            color: blue;
        }
        h2, h3 {
            color: red;
        }
        h3 {
            text-align: right;
            margin-right: 5%;
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="headline"> ENTRY PAGE FOR SUPPLY DETAILS </h1>
    <?php include "nav.php" ;?>
    <h1>DELIVERY DETAILS</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <hr>
        <label for="ref-docno">HVF Supply Order Number</label>
        <input type="text" name="ref-docno" required><br>
        <label for="ref-docdt">HVF Supply Order Date</label>
        <input type="date" name="ref-docdt" required><br>
        <label for="ref-sec">IGP Generation Section</label>
        <input type="text" name="ref-sec" required><br>
        <label for="dc-rec-no">Invoice / DC Number:</label>
        <input type="text" name="dc-rec-no" required><br>
        <label for="dc-rec-dt">Invoice / DC Date</label>
        <input type="date" name="dc-rec-dt" required><br>
        <label for="igp-itmcd">Item Code</label>
        <input type="text" name="igp-itmcd" required><br>
        <label for="vend-name">Vendor Name</label>
        <input type="text" name="vend-name"><br>
        <label for="igp-au">IGP UOM (AU)</label>
        <input type="text" name="igp-au" required><br>
        <label for="igp-itmqty">IGP Quantity</label>
        <input type="text" name="igp-itmqty" required><br>
        <label for="rb-no">DR / MIS Number</label>
        <input type="text" name="rb-no"><br>
        <label for="send-epcd">Send EPCD</label>
        <input type="text" name="send-epcd"><br>
        <label for="send-epds">Send EPDS</label>
        <input type="text" name="send-epds"><br>
        <label for="migp-no">Manual IGP Number</label>
        <input type="text" name="migp-no"><br>
        <label for="migp-sl">Manual IGP Serial Number</label>
        <input type="text" name="migp-sl"><br>
        <button class="custom-button1" type="submit">Next</button>
        <button class="custom-button" type="reset" value="Clear">Clear</button>
    </form>
    
    <?php if ($insertStatus !== ""): ?>
        <p><?php echo $insertStatus; ?></p>
    <?php endif; ?>
</body>
</html>
