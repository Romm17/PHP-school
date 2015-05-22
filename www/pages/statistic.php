<?php	
	class statistic extends Core {

		function getTitle($str){
			return str_replace("%title%", "Statistic", $str);
		}
		function getTop($str){
			return str_replace("%top%", 
								"<p><a href='index.php' > Back </a></p>", 
								$str);
		}
		function getMain($str, $error){
			return str_replace("%main%", $_SESSION['login'].", you were at the main page ".$_SESSION['times']." times!", $str);
		}

	}
?>
