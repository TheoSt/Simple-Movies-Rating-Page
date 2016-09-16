<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="stylesheets/register.css"/>
	</head>
	<body>
		<?php 
			require('db.php');
			session_start();
			
			if(!empty($_POST['user_email']) && (!empty($_POST['first_name'])) &&(!empty($_POST['last_name'])) && 
				(!empty($_POST['pass'])) && (!empty($_POST['pass_again']))) 
			{
				
				if($_POST['pass'] === $_POST['pass_again']) {
					$user_email = $_POST['user_email'];
					$password = $_POST['pass'];
					$first_name = $_POST['first_name'];
					$last_name = $_POST['last_name'];
					
					
					$query = "SELECT * FROM users WHERE (user_mail='$user_email');";
					
					$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
					
					$rows = mysqli_num_rows($result);
					if($rows == 1) {
						echo "You are already a user";
					}
					else {
						mysqli_free_result($result);
						$query = "INSERT INTO users(user_id,user_mail,user_password,
						user_first_name,user_last_name) VALUES(NULL,'$user_email','$password',
						'$first_name','$last_name');";
						
						$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
						if($result) {
							
							$query = "SELECT user_id FROM users WHERE user_mail='$user_email';";
						
							$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
							
							$_SESSION['user_mail'] = $user_email;
							$_SESSION['user_id'] = mysqli_fetch_array($result)[0];
							$_SESSION['if_login'] = 1;
							header("Location: successful_register.php");
						}
						else {
							echo "Something happened please try again..";
						}
					}
				}
				else {
					echo "<p>Please the two passwords must be same</p>";
				}
			}
		?>
			<h2>Registration</h2>
			<div class="register">
				<p>Glat to have a new member!It will take ony less than a minute!!</p>
				<form action="" method="post">
					<p><input name="user_email" type="text" value="" placeholder="Your Email"></label></p>
					<p><input name="first_name" type="text" value="" placeholder="Your first name"></label></p>
					<p><input name="last_name" type="text" value="" placeholder="Your last name"></label></p>
					<p><input name="pass" type="password" value="" placeholder="Your password"></label></p>
					<p><input name="pass_again" type="password" value="" placeholder="Please type your password again"></label></p>
					<p><button type="submit">Register</button></p>
				</form>
			</div>
			<div class="other">
				<a href="home.php?if_login=0&user_id=0">Continue as guest</a>
			</div>
		
	</body>
</html>
		