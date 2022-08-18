<?php 
require_once("includes/header.php");


$preview = new PreviewProvider($connection, $userLoggedIn);
echo $preview->createMoviesPreviewVideo();

$containers = new CategoryContainers($connection, $userLoggedIn);
echo $containers->showMoviesCategories();

?>