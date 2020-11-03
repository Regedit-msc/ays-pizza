<?php
 
// Connect to database
$conn = mysqli_connect('localhost', 'ayomide', 'ayomiposi', 'ninja_pizza');

// check connection
if (!$conn){
    echo "not connected" . mysqli_connect_error();
}

?>