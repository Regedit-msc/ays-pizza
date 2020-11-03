<?php

//  Include db connection
include('config/db_connect.php');

// write query for all pizzas 
$sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

// make query and get result 
$result = mysqli_query($conn, $sql);

//fetch the resulting record / row as an array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free the result from memory
mysqli_free_result($result);

// Close the connection
mysqli_close($conn);


?>


<!DOCTYPE html>
<html>
	<!-- Include header.php -->
	<?php include('templates/header.php'); ?>

	<h4 class="center grey-text">Pizzas!</h4>

	<div class="container">
		<div class="row">
<!-- Loop through the associative arrays in pizzas -->
			<?php foreach($pizzas as $pizza){ ?>

				<div class="col s6 md3">
					<div class="card z-depth-0">
					<img src="img/pizza.svg"class="pizza">
						<div class="card-content center">
							<h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
							<div><ul class="grey-text">
							<!-- Explode the ingredient string into an array -->
                            <?php foreach(explode(',', $pizza['ingredients']) as $ing){ ?>
									<li><?php echo htmlspecialchars($ing); ?></li>
								<?php } ?>
                            </ul></div>
						</div>
						<div class="card-action right-align">
							<a class="brand-text" href="details.php?id=<?php echo $pizza['id']?>">more info</a>
						</div>
					</div>
				</div>

			<?php } ?>

		</div>
	</div>
<!-- Include footer.php -->
	<?php include('templates/footer.php'); ?>

</html>