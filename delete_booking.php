<?php

include 'include/login.php';

$display = "";

$bookid = json_decode($_POST['bookingdel']);

$sql = 'DELETE FROM booking WHERE id =' . $bookid;

if($conn->query($sql) === TRUE) {
	$display .= "Booking deleted successfully";
} else {
	$display .= "Booking couldn't be deleted";
}


$conn->close();

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/logo.jpg">

    <title>Hotel Booking</title>

    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">

    <link href="style/main.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script type="text/javascript" src="js/viewbooking.js"></script>
  </head>
  <body ng-app="AApp" ng-controller="ACtrl">

    <div class="container">
      <header class="blog-header py-3" ng-include="'layout/header.html'">
      </header>
      <div class="nav-scroller py-1 mb-2" ng-include="'layout/menu.html'">
    </div>
    <main>
      <section class="jumbotron text-center" ng-if="viewbooking">
        <div class="center-message"><?=$display ?></div>
        </section>
    </main>
  </body>
</html>