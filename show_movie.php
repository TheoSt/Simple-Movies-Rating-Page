<!doctype html>
<html>
<head>
	<link rel="stylesheet" href="stylesheets/star.css"/>
	<link rel="stylesheet" href="stylesheets/show_movie.css"/>
</head>
<body>
<?php
	require('movieClass.php');
	require('db.php');
	session_start();
	
	$results = $_SESSION['results'];
	$login = $_SESSION['if_login'];
	$movie_id = $_GET['movie'];
	$user_id = $_SESSION['user_id'];
	
	//Η τιμή του Movie_id περιέχει ενα / στο τέλος,οπότε παίρνουμε την τιμή μέχρι να βρει /
	$arr = explode("/",$movie_id);
	$i = $arr[0];
	
	//χρησιμοποιούμε την k για να πάρουμε το id της ταινίας που θέλουμε
	$k = $results[$i]->getId();
	//Εδω ενημερωνόμαστε για τυχόν αλλαγές στην βάση για να έχουμε σωστα αποτελέσματα στην βαθμολογία
	//Ενημερώνει την συγκεκριμένη ταινια που βλέπουμε
	if($login == 0) {
			$query = "SELECT movie_id,avg(rating) as average FROM movies_rating where movie_id=$k;";
	}
	else {
		$query = "SELECT movie_id,rating FROM movies_rating where(user_id=$user_id and movie_id=$k)";
	}
	
	$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
	$rows = mysqli_num_rows($result);
				
	if($rows == 1) {
		$row = mysqli_fetch_array($result,MYSQLI_NUM); 
		$rate = $row[1];
		$results[$i]->setAverageRating($rate);
	}
	else {
		$results[$i]->setAverageRating(0);
	}
				
	mysqli_free_result($result);
	
	//ποσοι χρηστες εχουν βαθμολογησει την ταινια
	$query = "SELECT count(user_id) FROM movies_rating where movie_id=$k;";
	$result = mysqli_query($dbc,$query);
	$count = mysqli_fetch_array($result,MYSQLI_NUM)[0];
	mysqli_free_result($result);
?>
	<h1 class="movie-header"><?php echo $results[$i]->getTitle();?><br></h1>
	
	<img class="img" src="<?php echo $results[$i]->getPoster();?>"/>
	
	<div class="details">
		<p>
			<?php echo "Release Year:".$results[$i]->getReleaseYear();?>
		</p>
		
		<p>
			<?php echo "Category:".$results[$i]->getCategory();?>
		</p>
		
		<p>
			<?php echo "Scenario:<br/>".$results[$i]->getScenario();?>
		</p>
				
		<div id=<?php echo "movie_id".$results[$i]->getId();?>>
			<?php
				//το q αντιπροσωπεύει ενα αστέρι
				for($q=5; $q>0; $q--) {
					/*αν η βαθμολογια στρογγυλοποιημένη ισουται με q τότε κάνε αυτο το input checked/
					αρα αν εχω βαθμολογησει με 5 τοτε κανει checked το input και μέσω του css 
					δείχνει τσεκαρισμενα και τα 5 αστερακια
					
					αν ειναι χρήστης τότε δωστου τν δυνατοτητα να ξαναβαθμολογησει
					
					το τελευταιο script τρέχει οταν φορτώσει η σελίδα και ελέγχει αν 
					το login είναι 0 τοτε κανει τα input disabled
					*/					
					if(round($results[$i]->getAverageRating()) == $q) {
					
						if($login == 1) { 
			?>
							<input onClick="rates(this.value,<?php echo $results[$i]->getId();?>)" type="radio" id=<?php echo"1"."star".$q;?> name=<?php echo"1"."rating";?> value=<?php echo $q;?> checked/>
							<label for=<?php echo"1"."star".$q;?>><?php echo $q;?>stars</label>
				<?php		
						}
						else {
				?>			
							<input type="radio" id=<?php echo"1"."star".$q;?> name=<?php echo"1"."rating";?> value=<?php echo $q;?> checked/>
							<label for=<?php echo"1"."star".$q;?>><?php echo $q;?>stars</label>
				<?php		
						}
					}
					else {
						if($login == 1) {
				?>
							<input onClick="rates(this.value,<?php echo $results[$i]->getId();?>)" type="radio" id=<?php echo"1"."star".$q;?> name=<?php echo"1"."rating";?> value=<?php echo $q;?>/>
							<label for=<?php echo"1"."star".$q;?>><?php echo $q;?>stars</label>
				<?php		
						}
						else {
						
				?>
							<input type="radio" id=<?php echo"1"."star".$q;?> name=<?php echo"1"."rating";?> value=<?php echo $q;?> />
							<label for=<?php echo"1"."star".$q;?>><?php echo $q;?>stars</label>
				<?php		
						}
					}
				}
				
				//αν το rating είναι 0 και είναι χρήστης εμφάνισε του οτι δεν έχει βαθμολογήσει ακόμη
				if($results[$i]->getAverageRating()==0 && $login == 1) {
				?>
					<p id=<?php echo "rating".$results[$i]->getId();?>>You have not rated this movie yet!!</p>
				<?php		
				}
				//Αν το rating είναι 0 και είναι χρήστης δείξτου 0/5
				elseif($results[$i]->getAverageRating()==0 && $login ==0) {
				?>
					<p id=<?php echo "rating".$results[$i]->getId();?>>Rating: 0 to 5 <br/>0 votes</p>
				<?php		
				}
				else {
				?>
					<p id=<?php echo "rating".$results[$i]->getId();?>>Rating: <?php echo $results[$i]->getAverageRating()." ";?>to 5 <br/><?php echo $count;?> votes</p>
				<?php
				}
				?>
		</div>
	
	<script type="text/javascript" src="scripts/rate.js"></script>
	<script type="text/javascript"> 
		var login = <?php echo $login; ?>;
		if(login == 0) {
			var ins = document.querySelectorAll('[id*=star');
			for(var i=0; i<ins.length; i++) {
				ins[i].disabled = true;
			}
		}
	</script>
	<footer>
		©Created by Theodore Stamatiadis and Ilias Liakopoulos 2016
	</footer>
</body>
</html>	