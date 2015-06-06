<?php

	class User {
		public $login;
		public $pass;
		public $wantList;

		public function __construct($login, $pass){
			$this->login = $login;
			$this->pass = $pass;
			$this->wantList = array();
		}
	}

	session_start();
	require_once("functions.php");

	$page = "start";

	if(!isset($redis)){
		$redis = new Redis();
		$redis->connect('127.0.0.1');
	}

	if(!isset($key))
		$key = 'unset';

	if(isset($_GET['wish'])){
		addWish();
	}

	$error = 0;

	if(isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['choose'])){

		$user = new User($_POST['login'], $_POST['pass']);

		if($_POST['choose'] == 'Registration'){
			$error = makeUser($user);
		}
		else{
			$error = checkUser($user);
		}		
	}

	$tmp = file_get_contents("template.html");
	
	if(isset($_GET['page'])){
		if(file_exists("./pages/".$_GET['page'].".php")){
			$page = $_GET['page'];
		}
	}

	if(isset($_SESSION['user'])){
		if($page == 'start') 
			$page = 'refresh';
		if($page == 'refresh') 
			$_SESSION['times']++;
	}

	//resetTable("user");

	require("core.php");
	require("./pages/".$page.".php");
	$core = new $page($error, $redis, $key);

	echo $core->getPage($tmp, $error, $redis, $key);
?>