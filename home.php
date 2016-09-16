<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="stylesheets/home.css">
	</head>
	<body>
		<?php 
			require('db.php');
			require('movieClass.php');
			session_start();
			
			if(isset($_GET['if_login'])) {
				$login = $_GET['if_login'];
				$_SESSION['if_login'] = $login;
			}
			else {
				$login = $_SESSION['if_login'];
			}
			
			if(isset($_GET['user_id'])) {
				$_SESSION['user_id'] = $_GET['user_id'];
			}
			
			if($login == 0) {
				echo "<h3>Hello Guest</h3>";
			}
			else {
				$user = $_SESSION['user_mail'];
				echo "<h3>Hello $user</h3>";
			}
		?>
		<div class="form">
			<form method="post" action="results.php">
				<h1>Please choose a category</h1>
                <div class="list">
				<select name="categories">
                    <option value="All">All</option>
					<option value="Action">Action</option>
					<option value="Adventure">Adventure</option>
					<option value="Biography">Biography</option>
					<option value="Comedy">Comedy</option>
					<option value="Crime">Crime</option>
					<option value="Drama">Drama</option>
					<option value="SciFi">SciFi</option>
					<option value="Mystery">Mystery</option>
					<option value="Music">Music</option>
					<option value="Horror">Horror</option>
					<option value="Romance">Romance</option>
                    <option value="Western">Western</option>
				</select>
                
				<button type="submit">Go</button>
				</div>
			</form>
        </div>
		<footer>
			©Created by Theodore Stamatiadis and Ilias Liakopoulos 2016
		</footer>
	</body>
</html>