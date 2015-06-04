<?php
	abstract class Core{

		protected $error;
		protected $redis;
		protected $key;

		public function __construct($error, $redis, $key){
			$this->error = $error;
			$this->redis = $redis;
			$this->key = $key;
		}

		public function getPage($str){
			$str = $this->getTitle($str);
			$str = $this->getScript($str);
			$str = $this->getTop($str);
			$str = $this->getMain($str);
			return $str;
		}

		abstract function getTitle($str);
		abstract function getScript($str);
		abstract function getTop($str);
		abstract function getMain($str);

	}
?>