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


$sql = "SELECT `igp-no` FROM `igp-hd` ORDER BY `igp-no` DESC LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastIgpNo = $row['igp-no'];
    $nextIgpNo = $lastIgpNo + 1;
} else {
    $nextIgpNo = 2311000001; // Set default value if no records exist
}
//igp-HD
// Select values from igp-hd1 table
$sql = "SELECT `igp-no`, `igp-dt`, `igp-act-dt`, `igp-tim`, `ref-docno`, `ref-docdt`, `ref-sec`, `igp-stat`, `migp-no` FROM `igp-hd1`";
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Iterate through each row
    while ($row = $result->fetch_assoc()) {
        // Extract values from the row
        $igpNo = $nextIgpNo;
        $igpDt = $row['igp-dt'];
        $igpActDt = $row['igp-act-dt'];
        $igpTim = $row['igp-tim'];
        $refDocNo = $row['ref-docno'];
        $refDocDt = $row['ref-docdt'];
        $refSec = $row['ref-sec'];
        $igpStat = 'P';
        $migpNo = $row['migp-no'];

        // Insert values into igp-hd table
        $insertSql = "INSERT INTO `igp-hd`(`igp-no`, `igp-dt`, `igp-act-dt`, `igp-tim`, `ref-docno`, `ref-docdt`, `ref-sec`, `igp-stat`, `migp-no`) 
                      VALUES ('$igpNo','$igpDt','$igpActDt','$igpTim','$refDocNo','$refDocDt','$refSec','$igpStat','$migpNo')";
                      
        // Execute the insert query
        if ($conn->query($insertSql) === TRUE) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
} else {
    echo "No rows found in the igp-hd1 table.";
}

// Select values from igp-itm1 table
$sql = "SELECT `igp-no`, `dc-rec-no`, `dc-rec-dt`, `igp-itmcd`, `vend-nam`, `igp-au`, `igp-itmqty`, `rb-no`, `igp-itmstat`, `send-epcd`, `send-epdes`, `migp-no`, `migp-sl` FROM `igp-itm1`";
$result = $conn->query($sql);


//igp-itm
// Check if there are rows returned
if ($result->num_rows > 0) {
    // Iterate through each row
    while ($row = $result->fetch_assoc()) {
        // Extract values from the row
        $igpNo = $nextIgpNo;
        $dcRecNo = $row['dc-rec-no'];
        $dcRecDt = $row['dc-rec-dt'];
        $igpItmCd = $row['igp-itmcd'];
        $vendNam = $row['vend-nam'];
        $igpAu = $row['igp-au'];
        $igpItmQty = $row['igp-itmqty'];
        $rbNo = $row['rb-no'];
        $igpItmStat = 'P';
        $sendEpcd = $row['send-epcd'];
        $sendEpdes = $row['send-epdes'];
        $migpNo = $row['migp-no'];
        $migpSl = $row['migp-sl'];

        // Insert values into igp-itm table
        $insertSql = "INSERT INTO `igp-itm`(`igp-no`, `dc-rec-no`, `dc-rec-dt`, `igp-itmcd`, `vend-nam`, `igp-au`, `igp-itmqty`, `rb-no`, `igp-itmstat`, `send-epcd`, `send-epdes`, `migp-no`, `migp-sl`) 
                      VALUES ('$igpNo','$dcRecNo','$dcRecDt','$igpItmCd','$vendNam','$igpAu','$igpItmQty','$rbNo','$igpItmStat','$sendEpcd','$sendEpdes','$migpNo','$migpSl')";
                      
        // Execute the insert query
        if ($conn->query($insertSql) === TRUE) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
} else {
    echo "No rows found in the igp-itm1 table.";
}

//package table
// Select values from igp-pkg1 table
$sql = "SELECT `igp-no`, `pkg-mod`, `no-of-pkg`, `pkg-slno` FROM `igp-pkg1`";
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Iterate through each row
    while ($row = $result->fetch_assoc()) {
        // Extract values from the row
        $igpNo = $nextIgpNo;
        $pkgMod = $row['pkg-mod'];
        $noOfPkg = $row['no-of-pkg'];
        $pkgSlno = $row['pkg-slno'];

        // Insert values into igp-pkg table
        $insertSql = "INSERT INTO `igp-pkg`(`igp-no`, `pkg-mod`, `no-of-pkg`, `pkg-slno`) 
                      VALUES ('$igpNo','$pkgMod','$noOfPkg','$pkgSlno')";
                      
        // Execute the insert query
        if ($conn->query($insertSql) === TRUE) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
} else {
    echo "No rows found in the igp-pkg1 table.";
}



//escort table
// Select values from ig-escrt1 table
$sql = "SELECT `escrt-id`, `escrt-nam`, `escrt-desg` FROM `ig-escrt1`";
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Iterate through each row
    while ($row = $result->fetch_assoc()) {
        // Extract values from the row
        $escrtId = $row['escrt-id'];
        $escrtName = $row['escrt-nam'];
        $escrtDesig = $row['escrt-desg'];
        $igpNo = $nextIgpNo;

        // Insert values into ig-escrt table
        $insertSql = "INSERT INTO `ig-escrt`(`escrt-id`, `escrt-nam`, `escrt-desg`,`igp-no`) 
                      VALUES ('$escrtId','$escrtName','$escrtDesig','$igpNo')";
                      
        // Execute the insert query
        if ($conn->query($insertSql) === TRUE) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
} else {
    echo "No rows found in the ig-escrt1 table.";
}

//VEHICLE TABLE

$sql = "SELECT `veh-no`, `lr-no`, `lr-dt` FROM `ig-veh1`";
$result = $conn->query($sql);
// Check if there are rows returned
if ($result->num_rows > 0) {
    // Iterate through each row
    while ($row = $result->fetch_assoc()) {
        // Extract values from the row
        $igpNo = $nextIgpNo;
        $vehNo = $row['veh-no'];
        $lrNo = $row['lr-no'];
        $lrDt = $row['lr-dt'];

        // Insert values into ig-veh table
        $insertSql = "INSERT INTO `ig-veh`(`igp-no`, `veh-no`, `lr-no`, `lr-dt`) 
                      VALUES ('$igpNo','$vehNo','$lrNo','$lrDt')";
                      
        // Execute the insert query
        if ($conn->query($insertSql) === TRUE) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
} else {
    echo "No rows found in the ig-veh1 table.";
}

//DOCUMENT TABLE
// Select values from igp-hd-document1 table
$sql = "SELECT `igp-no`, `cd`, `avl` FROM `igp-hd-document1`";
$result = $conn->query($sql);

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Iterate through each row
    while ($row = $result->fetch_assoc()) {
        // Extract values from the row
        $igpNo = $nextIgpNo;
        $cd = $row['cd'];
        $avl = $row['avl'];

        // Insert values into igp-hd-document table
        $insertSql = "INSERT INTO `igp-hd-document`(`igp-no`, `cd`, `avl`) 
                      VALUES ('$igpNo','$cd','$avl')";
                      
        // Execute the insert query
        if ($conn->query($insertSql) === TRUE) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
} else {
    echo "No rows found in the igp-hd-document1 table.";
}
header("Location: display.php");
    exit;

// Close the connection
$conn->close();
?>

