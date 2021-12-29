<?php

require "init.php";
unset($_SESSION['user']); //delete user from session
go('login.php');

?>