<?php
require_once("functions.php");
$colors=["red","blue","green","brown","chocolate","indigo","midnightblue","black"];
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <title>
        Moosisahver!
    </title>
<style>
    h1 {
        color:<?php echo($colors[rand(0,count($colors)-1)]); ?>;
    }
</style>
</head>
<body>
    <h1>Moosisahver!</h1>
<?php echo(links($_SERVER['REQUEST_URI']));?>
<hr>