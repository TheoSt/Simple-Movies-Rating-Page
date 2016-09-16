<!DOCTYPE html>
<html>
	<head>
	</head>
	
	<body>
		<?php
			require('db.php');
			session_start();
			
			$value = intval($_GET['value']);
			$movie_id = intval($_GET['movie_id']);
			$user = $_SESSION['user_id'];
			
			$query = "SELECT * FROM movies_rating
						WHERE user_id=$user and movie_id=$movie_id;";
			
			$result = mysqli_query($dbc,$query);
			$rows = mysqli_num_rows($result);
				
			if($rows>=1) {
				mysqli_free_result($result);
				$query = "UPDATE movies_rating SET user_id=$user,movie_id=$movie_id,rating=$value
							WHERE user_id=$user and movie_id=$movie_id";
							
				$result = mysqli_query($dbc,$query);
				if(!$result) {
					mysqli_free_result($result);
				}
			}
			else {
				mysqli_free_result($result);
				$query = "INSERT INTO movies_rating 
						(rating_id, user_id, movie_id, rating) VALUES (NULL, $user, $movie_id, $value);";
				
				$result = mysqli_query($dbc,$query);
			}
				
			$query = "SELECT count(user_id) FROM movies_rating where movie_id=$movie_id;";
			$result2 = mysqli_query($dbc,$query);
			$count = mysqli_fetch_array($result2,MYSQLI_NUM)[0];
			mysqli_free_result($result2);
			
			echo "Rating: $value to 5"."<br/>$count votes";
		?>
	</body>
</html>