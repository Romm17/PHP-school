<?php	
	class form extends Core {

		function getTitle($str){
			return str_replace("%title%", "Hello", $str);
		}
		function getTop($str){
			return str_replace("%top%", "<h1>Authorization</h1>", 
								$str);
		}
		function getMain($str, $error){
			return str_replace("%main%", "<form action=index.php method=POST >".
				"<p>Name: <input type=text name=login /></p>".
				"<p>Pass: <input type=text name=pass /></p>".
				"<p>Registration <input type=radio name=choose value=Registration /></p>".
				"<p>Login <input type=radio name=choose value=Login /></p>".
				"<p><input type=submit /></p>".
				"</form>",
					$str);
		}

	}
?>