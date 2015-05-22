<?php
	session_start();

	class User {
		public $login;
		public $pass;

		public function __construct($login, $pass){
			$this->login = $login;
			$this->pass = $pass;
		}
	}

	function checkUser(){
		$file = fopen("/var/www/dev.school-server/www/base.txt", "rt");
		while(!feof($file)){
			$str = fgets($file, 1000);
			$data = unserialize(substr_replace($str, "", strlen($str) - 2));
			if($data && $_POST['login'] == $data->login && $_POST['pass'] == $data->pass){
				$_SESSION['login'] = $_POST['login'];
				$_SESSION['times'] = 0;
				fclose($file);
				return 0;
			}
		}
		fclose($file);
		return 1;
	}

	function makeUser($user){
		$file = fopen("/var/www/dev.school-server/www/base.txt", "at");
		$ser = serialize($user);
		fputs($file, $ser."\r\n");
		$_SESSION['login'] = $_POST['login'];
		fclose($file);
		return true;
	}

	$error = 0;

	if(isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['choose'])){

		$user = new User($_POST['login'], $_POST['pass']);

		if($_POST['choose'] == 'Registration'){
			makeUser($user);
		}
		else{
			$error = checkUser($user);
		}
		
	}

	$tmp = file_get_contents("template.html");
	$page = "start";
	if(isset($_GET['page'])){
		if(file_exists("./pages/".$_GET['page'].".php")){
			$page = $_GET['page'];
		}
	}

	if(isset($_SESSION['login'])){
		if($page == 'start') 
			$page = 'refresh';
		if($page == 'refresh') 
			$_SESSION['times']++;
	}

	require("core.php");
	require("./pages/".$page.".php");
	$core = new $page();

	echo $core->getPage($tmp, $error); 
?>