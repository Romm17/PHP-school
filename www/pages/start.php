<?php	
	class start extends Core {

		function getTitle($str){
			return str_replace("%title%", "Hello", $str);
		}
		function getScript($str){
			return str_replace("%script%", "", 
								$str);
		}
		function getTop($str){
			$res = "<p><a  class='lead' href='index.php?page=form' > Log in </a></p>".
					"<p><a  class='lead' href='index.php?page=form' > Sign up </a></p>";
			return str_replace("%top%", $res, $str);
		}
		function getMain($str){
			if($this->error == 1)
				return str_replace("%main%", "<h3> Hello, guest! </h3>".
										"<script>
											alert('No such combination of login/password found');
										</script>", $str);
			else if($this->error == 2)
				return str_replace("%main%", "<h3> Hello, guest! </h3>".
										"<script>
											alert('Limit login attempts. Try after ".$this->redis->ttl($this->key)." seconds.');
										</script>", $str);
			else if($this->error == 3)
				return str_replace("%main%", "<h3> Hello, guest! </h3>".
										"<script>
											alert('Login failed. You must use only a-z, A-Z, 0-9 or _.');
										</script>", $str);
			else
				return str_replace("%main%", "<h3> Hello, guest! </h3>", $str);
		}

	}
?>
