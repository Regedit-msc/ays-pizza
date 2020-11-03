<?php 
// Include database connection 
include('config/db_connect.php');

// set initial state of text input fields to empty string value
$email = $title = $ingredients = '';

// Create errors array for storing errors
	$errors = array('email' => '', 'title' => '', 'ingredients' => '');

	if(isset($_POST['submit'])){
		
		// check if email field is empty
		if(empty($_POST['email'])){
			$errors['email'] = 'An email is required';
		} else{

			// Use inbuilt FILTER_VALIDATE EMAIL to check if it really is an email
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
		}

		// check if title field is empty
		if(empty($_POST['title'])){
			$errors['title'] = 'A title is required';

		} else{

			// Test against regex
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors['title'] = 'Title must be letters and spaces only';
			}
		}

		// check if ingredients field is empty
		if(empty($_POST['ingredients'])){
			$errors['ingredients'] = 'At least one ingredient is required';

		} else{

			// Test if it passes the regex check
			$ingredients = $_POST['ingredients'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
				$errors['ingredients'] = 'Ingredients must be a comma separated list';
			}
		}

		if(array_filter($errors)){
			
			// Test for errors if there are eval false and dont run remaining code 
			// If there isn't run rest of the code;

		} else {

			// Prepare data to prevent injection
			$email = mysqli_real_escape_string($conn,$_POST['email']);
			$title = mysqli_real_escape_string($conn,$_POST['title']);
			$ingredients = mysqli_real_escape_string($conn,$_POST['ingredients']);

			// Create sql statement to add data into the tables
			$sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email', '$ingredients') ";

				// Save to db and check 
				if(mysqli_query($conn, $sql)){
					//success
					header('Location: index.php');
				} else {
					// failure
					echo 'query error' . mysqli_error($conn);
				}


			
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
	<!-- Include header.php -->
	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Add a Pizza</h4>
		<form class="white" action="add.php" method="POST">
			<label>Your Email</label>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
			<div class="red-text"><?php echo $errors['email']; ?></div>
			<label>Pizza Title</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
			<div class="red-text"><?php echo $errors['title']; ?></div>
			<label>Ingredients (comma separated)</label>
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
			<div class="red-text"><?php echo $errors['ingredients']; ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>
<!-- Footer -->
	<?php include('templates/footer.php'); ?>

</html>
