<?php
// Database credentials
$servername = "localhost"; // Change this to your MySQL server hostname if it's different
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password if applicable
$database = "place"; // Change this to your MySQL database name

// Create connection
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $ticket = $_POST['ticket'];
    $quantity = $_POST['quantity'];
    $destination = $_POST['destination'];

    // Prepare SQL statement to insert data into the 'order' table
    $sql = "INSERT INTO `order` (ticket, quantity, destination) VALUES (?, ?, ?)";

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $con->prepare($sql);

    if ($stmt) {
        // Bind parameters to the prepared statement as strings
        $stmt->bind_param("sis", $ticket, $quantity, $destination);
        
        // Execute the prepared statement
        $result = $stmt->execute();

        if($result){
           // Data inserted successfully
           echo "Order placed successfully.";
        } else {
            echo "Error: " . $stmt->error; // Display error if execution fails
        }
        
        // Close statement
        $stmt->close();
    } else {
        echo "Error: " . $con->error; // Display error if preparing fails
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="buy.css" />
    <title>Ticket Purchase</title>
</head>
<body>
    <h1>Buy Tickets</h1>
    <p>
        you can choose your class as business class= ticket 1, economy = ticket
        2, first class = ticket 3 during purchasing tickets just keep in mind we are here to provide you best deals for your trip
      </p>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="ticket">Ticket:</label>
        <select name="ticket" id="ticket">
            <option value="Ticket 1">Ticket 1</option>
            <option value="Ticket 2">Ticket 2</option>
            <option value="Ticket 3">Ticket 3</option>
            <!-- Add more options as needed -->
        </select><br><br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" value="1"><br><br>
        <label for="destination">Destination:</label>
        <input type="text" name="destination" id="destination"><br><br>
        <input type="submit" value="Buy Ticket">
    </form>
</body>
</html>

<?php
// Close database connection
$con->close();
?>
