<?php
session_start();

session_destroy();

$name = 'comicsrus';
$value = 0;
$expire = 0;
$path = '/projects/mapapp/';
$domain = '.stuartrunyan.com';

setcookie($name, $value, $expire, $path, $domain);

header('location:../index.php');

?>
<script>
	homepage = 0;
</script>