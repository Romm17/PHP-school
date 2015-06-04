<?php
	session_start();
	if(isset($_GET['wish'])){
		array_push($_SESSION['user']->wantList, $_GET['wish']);
	}
	print_r($_SESSION['user']->wantList);
	//header("Location: index.php?page=refresh");