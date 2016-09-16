<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="stylesheets/results.css">
   </head>
	<body>
		<h1>Results</h1>
		<!-- Selections για φθίνουσα αύξουσα σειρά και για κατηγορίες -->
		
		<div class="forms">
			<div id="sort-form">
				<form action="" method="post">
					<label>Sort by:
						<select id="sort" name="sort">
							<option value="asc_ranking">Ascenting order</option>
							<option value="desc_ranking">Descenting order</option>
						</select>
						
						<button type="submit">Sort</button>
					</label>
				</form>	
			</div>
			
			<div id="category-form">
				<form method="post" action="">
					<label>
						Category:
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
					</label>
					
					<button type="submit">Show</button>
				</form>
			</div>
		</div>
		
		<br/>
		<h2>Click the title of the movie you like to see more information!!</h2>
		
		<?php
			require('movieClass.php');
			require('db.php');
			session_cache_limiter('private_no_expire');
			session_start();
				
			$login = $_SESSION['if_login'];
			$user_id = $_SESSION['user_id'];
			$results_array = array();
			
			//1=Descenting 0=Ascenting
			$if_sort = 0;
			
			//αν έχεις επιλέξει κατηγορία
			if(isset($_POST['categories'])) {
				$_SESSION['category'] = $_POST['categories'];
			}
			
			//αν έχεις διαλέξει Ascenting ή Descenting order
			if(isset($_POST['sort'])) {
				if($_POST['sort'] == 'desc_ranking') {
					$if_sort=1;
			?>
				<!-- Θέσε την τιμή του select σε αυτην που πάτησε ο χρήστης γιατι η σελίδα θα κάνει refresh -->
				<script type="text/javascript">
					document.getElementById('sort').value = 'desc_ranking';
				</script>
			<?php
				}
				else {
					$if_sort = 0;
			?>
					<script type="text/javascript">
						document.getElementById('sort').value = 'asc_ranking';
					</script>
			<?php
				}
			}
			
			$category = $_SESSION['category'];
			
				
			if($if_sort == 0) {
				$query = "SELECT movies.movie_id,movie_title,movie_release_year,movie_category,movie_poster,movie_scenario,average_rating 
							FROM movies ORDER BY movie_title ASC;";
			}
			else {
				$query = "SELECT movies.movie_id,movie_title,movie_release_year,movie_category,movie_poster,movie_scenario,average_rating 
							FROM movies ORDER BY movie_title DESC;";
			}
				
			$result = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
			$rows = mysqli_num_rows($result);
				if($rows >= 1) {
					//αν η κατηγορία είναι All εμφάνισε όλες τις ταινίες
					if($category == 'All') {
						while($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
							$movie = new Movie();
							$movie->setId($row[0]);
							$movie->setTitle($row[1]);
							$movie->setReleaseYear($row[2]);
							$movie->setCategory($row[3]);
							$movie->setPoster($row[4]);
							$movie->setScenario($row[5]);
							// αν είναι απλός επισκέπτης πάρε την τιμή(average_rating) που τράβηξες απο την βάση
							if($login == 0) {
								$movie->setAverageRating($row[6]);
							}
							//Αλλιώς βρές την βαθμολογία ου έχει ο βάλει ο χρήστης
							else {
								$query = "SELECT rating 
											FROM movies,movies_rating 
											WHERE movies_rating.user_id ='$user_id' and movies_rating.movie_id =$row[0];";
								$result2 = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
								$rows = mysqli_num_rows($result2);		
								
								if($rows>=1) {
									$movie->setAverageRating(mysqli_fetch_array($result2,MYSQLI_NUM)[0]);
								}
								else {
									$movie->setAverageRating(0);
								}
							}
							array_push($results_array,$movie);
						}
					}
					else {
						//απο τις ταινίες που τράβηξες παρε την στήλη category και δες αν περιέχει την κατηγορία
						//που επέλεξες
						//Μια άλλη εναλλακτική είναι η εντολή LIKE της MYSQL αλλά σε πολλά δεδομένα είναι αργή
						//(Με προοπτική οτι στην βαση μπορει να μπουν περισσότερες ταινίες)
						while($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
								if(strpos($row[3],$category) !== false) {
									$movie = new Movie();
									$movie->setId($row[0]);
									$movie->setTitle($row[1]);
									$movie->setReleaseYear($row[2]);
									$movie->setCategory($row[3]);
									$movie->setPoster($row[4]);
									$movie->setScenario($row[5]);
									if($login == 0) {
										$movie->setAverageRating($row[6]);
									}
									else {
										$query = "SELECT rating 
													FROM movies,movies_rating 
													WHERE movies_rating.user_id ='$user_id' and movies_rating.movie_id =$row[0];";
										$result2 = mysqli_query($dbc,$query) or die(mysqli_error($dbc));
										$rows = mysqli_num_rows($result2);		
										
										if($rows>=1) {
											$movie->setAverageRating(mysqli_fetch_array($result2,MYSQLI_NUM)[0]);
										}
										else {
											$movie->setAverageRating(0);
										}
									}
									array_push($results_array,$movie);
								}
							}
						}
					$_SESSION['results'] = $results_array;
					mysqli_free_result($result);
					showMovies();
				}
				else {
					echo "Didnt find any movie in this category..";
				}
			
			//εμφάνισε τις ταινίες
			//Χρησιμοποιούμε την τιμή της μεταβλητης k για να ξεχωρίσουμε τις φόρμες
			function showMovies() {
				global $results_array;
				global $count;
				global $dbc;
				
				if($results_array!=null) {
					$k = 1;
					?>
					<ul>
					<?php
						foreach($results_array as $movie) {
					?>	
							<li>
								<fieldset>
									<form id=<?php echo "$k"."form";?> name=<?php echo $k."form";?> action="show_movie.php" method="GET">
										
										<input type="hidden" name="movie" value=<?php echo $k-1;?>/>
										<input type="hidden" name="count" value=<?php echo $count;?>/>
										
										<div class="movie-header">
											<a href="#" onClick="document.getElementById('<?php echo"$k"."form"?>').submit();"><h1><?php echo $movie->getTitle();?><br></h1></a>
										</div>
									</form>
									
									<img class="img" src="<?php echo $movie->getPoster();?>"/>
									<div class="details">
										<p>
											<?php echo "Release Year: ".$movie->getReleaseYear();?>
										</p>
										<p>
											<?php echo "Category: ".$movie->getCategory();?>
										</p>
									</div>		
								</fieldset>
							</li>
					<?php
							$k++;
						}
					?>
					</ul>
					<?php
				}
			}
			?>
			<p id="footer">
				©Created by Theodore Stamatiadis and Ilias Liakopoulos 2016
			</p>
	</body>
</html>