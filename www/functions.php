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
			$db->query("INSERT INTO wishes (value) VALUES ('X')");
			$res = $wishes;
			$result = $res['id']; 
		}
		array_push($_SESSION['user']->wantList, $result);
		updateUser();
		header("Location: index.php?page=refresh");
	}

	function removeWish($id){
		/*unset($_SESSION['user']->wantList[$id]);
		var_dump($_SESSION['user']->wantList);*/
		$_SESSION['user'] = 'sdfsdfsdfsdfsdfsdfsd';
		updateUser();
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
		$res = $db->query("SELECT * FROM user");
		while($data = $res->fetch_assoc()){
			$user = new User($data['login'], $data['pass']);
			$user->wantList = unserialize($data['wantList']);
			if($data && $_POST['login'] == $user->login && $_POST['pass'] == $user->pass){
				$_SESSION['user'] = $user;
				$_SESSION['id'] = $data['id'];
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
		$ser = serialize($user->wantList);
		$db->query("INSERT INTO user (login, pass, wantList) VALUES ('$user->login', '$user->pass', '$ser')");
		$id = $db->query("SELECT id FROM user WHERE login='$user->login' ")->fetch_assoc();
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
		$currUser = $_SESSION['user'];
		$wl = serialize($currUser->wantList);
		$id = $_SESSION['id'];
		$db->query("UPDATE user SET login='$currUser->login', pass='$currUser->pass', wantlist='$wl' WHERE id='$id'");
	}
?>