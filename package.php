<?php
session_start(); // Start the session

// Assuming you have a database connection setup

// Retrieve the form data
$packagemod = $_POST['pkgMod'];
$packagecount=$_POST['noPkg'];
$packagesno=$_POST['pkgSno'];

// Get the current invoice number
$currentInvoiceNumber = getCurrentInvoiceNumber();

// Generate the next invoice number
$nextInvoiceNumber = generateNextInvoiceNumber($currentInvoiceNumber);

// Store the package details in a session variable
$_SESSION['pkgMod'] = $packagemod;

// Store the invoice number in a session variable
$_SESSION['i'] = $nextInvoiceNumber;

// Redirect to the next form (Vehicle Details)
header("Location: vehicles.php");

// Function to get the current invoice number
function getCurrentInvoiceNumber() {
  // Retrieve the current invoice number from the database
  // Perform appropriate database operations to get the value

  // For example, assuming you have a database table named "invoices" with a column "invoice_number"
  // and the last updated entry represents the current invoice number
  $host = 'localhost';
  $user = 'root';
  $password = '';

  $conn = new mysqli($host, $user, $password);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $query = "SELECT invoice_number FROM invoices ORDER BY id DESC LIMIT 1";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentInvoiceNumber = $row['invoice_number'];
  } else {
    $currentInvoiceNumber = 0;
  }

  $sql= "insert into igp-pkg values('$nextInvoiceNumber','$packagemod','$packagecount','$packagesno');";
  if($conn->query($sql) === True)
  {
    echo "inserted";
  }
  else
  {
    echo "error".$conn->error;
  }

  $conn->close();

  return $currentInvoiceNumber;
}

// Function to generate the next invoice number
function generateNextInvoiceNumber($currentInvoiceNumber) {
  // Increment the current invoice number
  $nextInvoiceNumber = $currentInvoiceNumber + 1;

  return $nextInvoiceNumber;
}
?>
