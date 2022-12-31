<?php
$bd = new PDO('mysql:host=localhost; dbname=exemple', 'root', '');
$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>