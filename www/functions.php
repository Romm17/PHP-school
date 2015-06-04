<?php

	function addWish(){
		$db = mysqli_connect('localhost', 'admin', 'Password131', 'Test');
		$wish = $_GET['wish'];
		$wishes = $db->query("SELECT * FROM wishes WHERE value='$wish'")->fetch_assoc();
		if(!$wishes){
			$db->query("INSERT INTO wishes (value) VALUES ('$wish')");
			$res = $db->query("SELECT id FROM wishes WHERE value='$wish'")->fetch_assoc();
			$result = $res['id'];
		}
		else{
			$db->query("INSERT INTO wishes (value) VALUES ('XepHya')");
			$res = $wishes;
			$result = $res['id']; 
		}
		array_push($_SESSION['user']->wantList, $result);
		updateUser();
		header("Location: index.php?page=refresh");
	}

	function removeWish($wish){
		$db = mysqli_connect('localhost', 'admin', 'Password131', 'Test');
		$currUser = serialize($_SESSION['user']);
	}

	function checkUser($user){
		global $redis;
		global $key;
		global $page;
		$key = 'fail_'.$_POST['login'];
		if($redis->get($key) != 'false' && $redis->get($key) > 2){
			$page = 'form';
			return 2;
		}
		$db = mysqli_connect('localhost', 'admin', 'Password131', 'Test');
		$res = $db->query("SELECT value FROM user");
		while($str = $res->fetch_assoc()){
			$data = unserialize($str['value']);
			if($data && $_POST['login'] == $data->login && $_POST['pass'] == $data->pass){
				$req = $str['value'];
				$id = $db->query("SELECT id FROM user WHERE value='$req' ")->fetch_assoc();
				$_SESSION['user'] = $data;
				$_SESSION['id'] = $id['id'];
				$_SESSION['times'] = 0;
				return 0;
			}
		}
		$page = 'form';
		if(!$redis->exists($key)){
			$redis->set($key, '1');
			$redis->setTimeout($key, '20');
		}
		else{
			$redis->incr($key);
		}
		return 1;
	}

	function makeUser($user){
		if(!preg_match("/^[a-zA-Z0-9_]{6,20}$/", $user->login)){
			return 3;
		}
		$db = mysqli_connect('localhost', 'admin', 'Password131', 'Test');
		$ser = serialize($user);
		$db->query("INSERT INTO user (value) VALUES ('$ser')");
		$id = $db->query("SELECT id FROM user WHERE value='$ser' ")->fetch_assoc();
		$_SESSION['user'] = $user;
		$_SESSION['id'] = $id['id'];
		return 0;
	}

	function resetTable($table){
		$db = mysqli_connect('localhost', 'admin', 'Password131', 'Test');
		$db->query("DELETE FROM $table");
		$db->query("ALTER TABLE $table AUTO_INCREMENT = 1");
	}

	function updateUser(){
		$db = mysqli_connect('localhost', 'admin', 'Password131', 'Test');
		$currUser = serialize($_SESSION['user']);
		$id = $_SESSION['id'];
		$db->query("UPDATE user SET value='$currUser' WHERE id='$id'");
	}
?>