<?php
	session_start();

	//Connect to the database.
	try {
		//connection to db
		$dbh = new PDO("mysql:host=cristiancdb.cristiancuda.com;dbname=cristiancuda_blog", "cricud", "Tropicalisima1,");
		} catch (PDOEXception $e) {
		exit('Database connection failed: ' . $e->getMessage());
		}

		//Retrieving blog text for loged in user.
		$stmt = $dbh->prepare("SELECT username FROM users");
		$stmt->execute() or exit ("SELECT failed.");
?>

<h2>Avaliable Blogs</h2>
<ul>
	<?php
		foreach($stmt as $row) {
			$u = $row['username'];
			echo '<li><a href="viewblog.php?u=' . $u . '">' . $u . '</a></li>';
		}
	?>
</ul>

<?php
	//If we are logged in, we show a logout button . Otherwhise we show a login form
	if(isset($_SESSION['username'])) { ?>
		<form action="logout.php" method="post">
			<input type="submit" value="Logout" />
		</form>
<?php }else { ?>
<h4>To test the edit function, login with the following credentials: <br>
	username:cristian<br>
	password:1234<br>
</h4>
<form action="login.php" method="post"> <!--login.php will get usr and pwd-->
	Username: <input type="text"	 name="username" size="36" /> <br>
	Password: <input type="password" name="password" size="36" /> <br>
	<input type="submit" value="Login" />
</form>
<?php }

?>
