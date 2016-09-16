<!doctype html>
<html>
	<head>
        <title> Welcome! </title>
		<meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="stylesheets/index.css" >
	</head>
	<body>
		<?php 
		require('db.php');
		//αν ο χρήστης έχει πληκτρολογήσει και πατήσει Sign in
		if(!empty($_POST['user']) && (!empty($_POST['pass']))) {
			$user = $_POST['user'];
			$password = $_POST['pass'];
				
			//Δες αν στην βάση υπάρχει ο χρήστης
			$query = "SELECT * FROM users WHERE (user_mail='$user' and
				user_password='$password');";
				
			$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
			$rows = mysqli_num_rows($result);
				
			if($rows == 1) {
				$row = mysqli_fetch_array($result,MYSQLI_NUM); 
				session_cache_limiter('private_no_expire');
				session_start();		
				$_SESSION['user_mail'] = $row[1];
				$_SESSION['user_id'] = $row[0];
				$_SESSION['if_login'] = 1;
					
				mysqli_free_result($result);
				
				header("Location: home.php");
			}
			else {
				echo '<h2>Please type a correct username and password</h2>';
			}
	}
?>
			<h1>Welcome!</h1>
			<div class="login">
				<h2>Login</h2>
				<form action="" method="post">
					<p><label><input name="user" type="text" value="" placeholder="User Email" required></label></p>
					<p><label><input name="pass" type="password" value="" placeholder="Your password" required></label></p>
					<p><button type="submit">Login</button></p>
				</form>
			</div>
			<div class="links">
				<p>Not registered yet? <a href="register.php">Click here to register</a><br>
					<a href="home.php?if_login=0&user_id=0">Continue as guest</a>
				</p>
			</div>
			<footer>
				©Created by Theodore Stamatiadis and Ilias Liakopoulos 2016
			</footer>
	</body>
</html>
		