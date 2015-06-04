<?php	
	class form extends Core {

		function getTitle($str){
			return str_replace("%title%", "Hello", $str);
		}

		function getScript($str){
			return str_replace("%script%", "", 
								$str);
		}

		function getTop($str){
			return str_replace("%top%", "<h1>Authorization</h1>", 
								$str);
		}

		function getMain($str){
			$res = "";
			if($this->error == 1)
				$res .= "<h3> Hello, guest! </h3>".
						"<script>
						alert('No such combination of login/password found');
						</script>";
			else if($this->error == 2)
				$res .= "<h3> Hello, guest! </h3>".
						"<script>
						alert('Limit login attempts. Try after ".$this->redis->ttl($this->key)." seconds.');
						</script>";
			else if($this->error == 3)
				$res .= "<h3> Hello, guest! </h3>".
						"<script>
						alert('Login failed. You must use only a-z, A-Z, 0-9 or _.');
						</script>";
			return str_replace("%main%", $res."<form action=index.php method=POST >".
				"<p class='lead' >Name: <input type=text name=login /></p>".
				"<p class='lead' >Pass: <input type=text name=pass /></p>".
				"<p class='lead' >Registration <input type=radio name=choose value=Registration /></p>".
				"<p class='lead' >Login <input type=radio name=choose value=Login /></p>".
				"<p class='lead' ><input type=submit class='btn btn-lg btn-primary' /></p>".
				"</form>",
					$str);
		}

	}
?>