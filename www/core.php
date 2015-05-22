<?php
	abstract class Core{

		public function getPage($str, $error){
			$str = $this->getTitle($str);
			$str = $this->getTop($str);
			$str = $this->getMain($str, $error);
			return $str;
		}

		abstract function getTitle($str);
		abstract function getTop($str);
		abstract function getMain($str, $error);

	}
?>