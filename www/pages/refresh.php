<?php
	class refresh extends Core {

		function getTitle($str){
			return str_replace("%title%", "Main", $str);
		}
		function getScript($str){
			return str_replace("%script%", "<script src='js/refresh.js' ></script>", 
								$str);
		}
		function getTop($str){
			return str_replace("%top%", "<p><a href='logout.php' > Log out </a></p>", $str);
		}
		function getMain($str){
			$newText = "<h3> Hello, ".$_SESSION['user']->login."</h3>".
						"<form action='index.php' ><label>Enter what you want.. <input type='text' name='wish' ></input></label>".
						"<input type='submit' value='Add'></input></form>";
			foreach ($_SESSION['user']->wantList as $i => $value) {
				$db = mysqli_connect('localhost', 'admin', 'Password131', 'Test');
				$res = $db->query("SELECT value FROM wishes WHERE id='$value'")->fetch_assoc();
				$newText .= "<p>".($i + 1).". ".$res['value']."<button class='glyphicon glyphicon-remove' 
							onclick='<?php removeWish(".$i.");?>' ></button></p>";
			}
			$newText .= "<p><a href='index.php?page=statistic' > Show statistic </a></p>";
			return str_replace("%main%", $newText, 
										$str);
		}

	}
?>