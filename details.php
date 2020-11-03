<?php 

// Connect to database
    include('config/db_connect.php');
    
    // check if a post request has been made from the hidden form submit button with name 'delete';
	if(isset($_POST['delete'])){

        // escape it to prevent users from tampering with the request to sql db
		$id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        // sql statement to delete from database by post ;
        $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";
        
        // if the query executes redirect to home 
		if(mysqli_query($conn, $sql)){
            header('Location: index.php');
            
		} else {
            // else echo the error to the user
			echo 'query error: '. mysqli_error($conn);
		}

	}



	// check GET request id param if available i.e when user clicks more info
	if(isset($_GET['id'])){
		
		// escape sql chars
		$id = mysqli_real_escape_string($conn, $_GET['id']);

		// make sql
		$sql = "SELECT * FROM pizzas WHERE id = $id";

		// get the query result
		$result = mysqli_query($conn, $sql);

		// fetch result in array format
        $pizza = mysqli_fetch_assoc($result);
        
        // free memory
        mysqli_free_result($result);

        // close connection
		mysqli_close($conn);

	}

?>

<!DOCTYPE html>
<html>
<!-- Include header.php -->
	<?php include('templates/header.php'); ?>

	<div class="container center grey-text">
    <!-- If the get request was successful and we have pizza -->
		<?php if($pizza): ?>
			<h4><?php echo $pizza['title']; ?></h4>
			<p>Created by <?php echo $pizza['email']; ?></p>
			<p><?php echo date($pizza['created_at']); ?></p>
			<h5>Ingredients:</h5>
			<p><?php echo $pizza['ingredients']; ?></p>
            
			<!-- DELETE FORM -->
			<form action="details.php" method="POST">
				<input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
			</form>
		<?php else: ?>
			<h5>No such pizza exists.</h5>
		<?php endif ?>
	</div>
<!-- Footer -->
	<?php include('templates/footer.php'); ?>

</html>