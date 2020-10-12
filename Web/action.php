<?php
 $servername = "sample-mysql-service";
 $username = "DemoUser";
 $password = "DemoUserPassw0rd";
 $dbname = "demo";
 if (isset($_POST['fname']) && isset($_POST['lname'])) {
     // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "INSERT INTO MyGuests(firstname, lastname) VALUES ('{$_POST['fname']}', '{$_POST['lname']}')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
      
    mysqli_close($conn);
 }
?>
