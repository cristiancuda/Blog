<?php
	session_start();
  //If username is not logged in, redirect to home page
  if(!isset($_SESSION['username'])) {
    header('Location: ./');
    exit();
  }

  //If the user clicked Cancel, then redirect to viewblog page.
  if(isset($_POST['cancel'])) {
    header('Location: viewblog.php?u=' . $_SESSION['username']);
    exit();
  }

  //Check for valid data. User will be sent to homepage if submitted data is not valid.
  if(!isset($_POST['blogtext'])) {
    header('Location: ./');
    exit();
  }

	//Extracting the submitted blogtext.
	$blogtext = $_POST['blogtext'];

	//Connect to DB
	try {
	 //connection to db
	 $dbh = new PDO("mysql:host=cristiancdb.cristiancuda.com;dbname=cristiancuda_blog", "cricud", "Tropicalisima1,");
    } catch (PDOException $e) {
	 exit('Database connection failed: ' . $e->getMessage());
	 }

   //Retrieve the actual password for given user
	 $stmt = $dbh->prepare("UPDATE users SET blogtext = :blogtext WHERE username = :username");
	 $stmt->bindParam(':blogtext', $blogtext);
   $stmt->bindParam(':username', $_SESSION['username']);
	 $stmt->execute() or exit ("UPDATE failed.");

	//Redirecting to viewblog page (after they edited) so the user can see the changes.
	header('Location: viewblog.php?u=' . $_SESSION['username']);
?>
