<?php

require_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMessage::show("No ID passed into page");  // any php code after it not executed
}

$entityId = $_GET["id"];
$entity = new Entity($connection, $entityId);

$preview = new PreviewProvider($connection, $userLoggedIn);
echo $preview->createPreviewVideo($entity);

$seasonProvider = new SeasonProvider($connection, $userLoggedIn);
echo $seasonProvider->create($entity);

$categoryContainers = new CategoryContainers($connection, $userLoggedIn);
echo $categoryContainers->showCategory($entity->getCategoryId(), "You might also like");

?>