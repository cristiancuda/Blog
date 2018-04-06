<?php
	session_start();

	//Extracting form data (submitted data) from HTTP request message.
	$username = $_POST['username'];
	$submitted_password = $_POST['password'];
	//checking invalid data.
	if(!isset($username) or !isset($submitted_password)) {
		header('Location: ./');
		exit();
	}

	try {
	 //connection to db
	 $dbh = new PDO("mysql:host=cristiancdb.cristiancuda.com;dbname=cristiancuda_blog", "cricud", "Tropicalisima1,");
 } catch (PDOException $e) {
	 exit('Database connection failed: ' . $e->getMessage());
	 }

	 $stmt = $dbh->prepare("SELECT password FROM users WHERE username = :username");
	 $stmt->bindParam(':username', $username);
	 $stmt->execute() or exit ("SELECT failed.");

	 //If there is no such user, then redirect to login page.
	 if ($stmt->rowCount() == 0) {
		 header('Location: ./');
		 exit();
	 }

	 //Extract the actual password.
	 $row = $stmt->fetch() or exit ("FETCH failed.");
	 $actual_password = $row['password'];

	 //If submitted password != from the actual password, then redirect to login page
	 if ($submitted_password != $actual_password) {
	 	header('Location: ./');
	 	exit();
	}

	$_SESSION['username'] = $username;
	//Redirecting to clickme page.
	header('Location: ./');
?>
