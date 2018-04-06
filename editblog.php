<?php
	//Script to avoid user jump the login.
	session_start(); //starting session

  //Connect to the database.
	try {
		//connection to db
		$dbh = new PDO("mysql:host=cristiancdb.cristiancuda.com;dbname=cristiancuda_blog", "cricud", "Tropicalisima1,");
		} catch (PDOEXception $e) {
		exit('Database connection failed: ' . $e->getMessage());
		}

		//Retrieving blog text for loged in user.
		$stmt = $dbh->prepare("SELECT blogtext FROM users WHERE username = :username");
		$stmt->bindParam(':username', $_SESSION['username']); //since is the logged in user, we go to the session array and we pull out the value associated with the value associated with the username key in the session array.
		$stmt->execute() or exit ("SELECT failed.");

		//If there is no such user, then redirect to home page.
		if ($stmt->rowCount() == 0) {
			header('Location: ./');
			exit();
		}

		//Extract the blog text.
		$row = $stmt->fetch() or exit ("FETCH failed.");
		$blogtext = $row['blogtext'];
?>

<h1>Edit Blog page</h1>

<p><a href="./">Home</a></p>

<form action="saveblogtext.php" method="POST">

  <textarea name="blogtext" rows="12" cols="80">
    <?php print ($blogtext) ?>
  </textarea><br>

  <input type="submit" name="cancel" value="Cancel" size="24" />
  <input type="submit"               value="Save" size="24" />
</form>


<div id="error_message"></div>
