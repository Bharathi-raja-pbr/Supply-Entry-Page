
<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
            margin-left:13%;
        }

        table,th, td,tr {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
        }

        h1{
            font-size:30px;
      
        }
        .custom-button1{
            margin-left:40%;
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "nav.php" ;?>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "supply";

    // Create connection
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
        
    }

    $sql = "SELECT `igp-no`, `igp-dt`, `igp-act-dt`, `igp-tim`, `ref-docno`, `ref-docdt`, `ref-sec`, `igp-stat`, `migp-no` FROM `igp-hd` where `igp-no`=$lastIgpNo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h1>IGP-HD</h1>';
        echo "<table>";
        echo "<tr><th>IGP No</th><th>IGP Date</th><th>IGP Actual Date</th><th>IGP Time</th><th>Ref Doc No</th><th>Ref Doc Date</th><th>Ref Section</th><th>IGP Status</th><th>MIGP No</th></tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["igp-no"] . "</td><td>" . $row["igp-dt"] . "</td><td>" . $row["igp-act-dt"] . "</td><td>" . $row["igp-tim"] . "</td><td>" . $row["ref-docno"] . "</td><td>" . $row["ref-docdt"] . "</td><td>" . $row["ref-sec"] . "</td><td>" . $row["igp-stat"] . "</td><td>" . $row["migp-no"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $sql = "SELECT `igp-no`, `dc-rec-no`, `dc-rec-dt`, `igp-itmcd`, `vend-nam`, `igp-au`, `igp-itmqty`, `rb-no`, `igp-itmstat`, `send-epcd`, `send-epdes`, `migp-no`, `migp-sl` FROM `igp-itm` where `igp-no`=$lastIgpNo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h1>IGP-ITM</h1>';
        echo "<table>";
        echo "<tr><th>IGP No</th><th>DC Rec No</th><th>DC Rec Date</th><th>IGP Item Code</th><th>Vendor Name</th><th>IGP AU</th><th>IGP Item Quantity</th><th>RB No</th><th>IGP Item Status</th><th>Send EPCD</th><th>Send EPDES</th><th>MIGP No</th><th>MIGP SL</th></tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["igp-no"] . "</td><td>" . $row["dc-rec-no"] . "</td><td>" . $row["dc-rec-dt"] . "</td><td>" . $row["igp-itmcd"] . "</td><td>" . $row["vend-nam"] . "</td><td>" . $row["igp-au"] . "</td><td>" . $row["igp-itmqty"] . "</td><td>" . $row["rb-no"] . "</td><td>" . $row["igp-itmstat"] . "</td><td>" . $row["send-epcd"] . "</td><td>" . $row["send-epdes"] . "</td><td>" . $row["migp-no"] . "</td><td>" . $row["migp-sl"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }


    $sql = "SELECT `igp-no`, `pkg-mod`, `no-of-pkg`, `pkg-slno` FROM `igp-pkg` where `igp-no`=$lastIgpNo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h1>IGP-PKG</h1>';
        echo "<table>";
        echo "<tr><th>IGP No</th><th>Package Model</th><th>Number of Packages</th><th>Package Serial Number</th></tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["igp-no"] . "</td><td>" . $row["pkg-mod"] . "</td><td>" . $row["no-of-pkg"] . "</td><td>" . $row["pkg-slno"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }


    $sql = "SELECT `igp-no`, `escrt-id`, `escrt-nam`, `escrt-desg` FROM `ig-escrt` where `igp-no`=$lastIgpNo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h1>IG-ESCRT</h1>';
        echo "<table>";
        echo "<tr><th>IGP No</th><th>Escort ID</th><th>Escort Name</th><th>Escort Designation</th></tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["igp-no"] . "</td><td>" . $row["escrt-id"] . "</td><td>" . $row["escrt-nam"] . "</td><td>" . $row["escrt-desg"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $sql = "SELECT `igp-no`, `veh-no`, `lr-no`, `lr-dt` FROM `ig-veh`where `igp-no`=$lastIgpNo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h1>IG-VEH</h1>';
        echo "<table>";
        echo "<tr><th>IGP No</th><th>Vehicle No</th><th>LR No</th><th>LR Date</th></tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["igp-no"] . "</td><td>" . $row["veh-no"] . "</td><td>" . $row["lr-no"] . "</td><td>" . $row["lr-dt"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    $sql = "SELECT `igp-no`, `cd`, `avl` FROM `igp-hd-document` where `igp-no`=$lastIgpNo";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<h1>IGP-HD-DOCUMENT</h1>';
        echo "<table>";
        echo "<tr><th>IGP No</th><th>CD</th><th>AVL</th></tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["igp-no"] . "</td><td>" . $row["cd"] . "</td><td>" . $row["avl"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

 


    $conn->close();
    ?>
    <br>
    <br>

        
</body>
</html>
