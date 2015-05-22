<?php	
	class start extends Core {

		function getTitle($str){
			return str_replace("%title%", "Hello", $str);
		}
		function getTop($str){
			return str_replace("%top%", 
								"<p><a href='index.php?page=form' > Log in </a></p><p><a href='index.php?page=form' > Sign up </a></p>", 
								$str);
		}
		function getMain($str, $error){
			if($error == 1)
				return str_replace("%main%", "<h3> Hello, guest! </h3>".
										"<script>
											alert('No such combination of login/password found');
										</script>", $str);
			else
				return str_replace("%main%", "<h3> Hello, guest! </h3>", $str);
		}

	}
?>
