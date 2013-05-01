<?php
$query = $_POST['query'];
$query = urlencode($query);
$result = file_get_contents('http://localhost:8080?query=' . $query);
echo $result;
?>
