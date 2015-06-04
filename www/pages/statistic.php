<?php	
	class statistic extends Core {

		function getTitle($str){
			return str_replace("%title%", "Statistic", $str);
		}
		function getScript($str){
			return str_replace("%script%", "", 
								$str);
		}
		function getTop($str){
			return str_replace("%top%", 
								"<p><a href='index.php' > Back </a></p>", 
								$str);
		}
		function getMain($str, $error){
			return str_replace("%main%", $_SESSION['user']->login.", you were at the main page ".$_SESSION['times']." times!", $str);
		}

	}
?>
