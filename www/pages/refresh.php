<?php
	class refresh extends Core {

		function getTitle($str){
			return str_replace("%title%", "Main", $str);
		}
		function getTop($str){
			return str_replace("%top%", "<p><a href='logout.php' > Log out </a></p>", $str);
		}
		function getMain($str, $error){
			return str_replace("%main%", "<h3> Hello, ".$_SESSION['login']."</h3>".
										"<p><a href='index.php?page=statistic' > Show statistic </a></p>", 
										$str);
		}

	}
?>