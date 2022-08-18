<?php 
require_once("includes/header.php");


$preview = new PreviewProvider($connection, $userLoggedIn);
echo $preview->createPreviewVideo(null);

$containers = new CategoryContainers($connection, $userLoggedIn);
echo $containers->showAllCategories(null);

?>