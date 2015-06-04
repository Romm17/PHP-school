<?php

	include("vendor/autoload.php");

	class User {
		public $login;
		public $pass;
		public $wantList;

		public function __construct($login, $pass){
			$this->login = $login;
			$this->pass = $pass;
			$this->wantList = array();
		}
	}

	function selectAll(){
		$db = mysqli_connect("localhost", "admin", "Password131", "Test");
		$result = $db->query("SELECT * FROM user");
		while($res = $result->fetch_assoc()){
			$str = "";
			foreach ($res as $key => $value) {
				$str .= $value." ";
			}
			echo $str."\r\n";
		}
	}

	function addUsers(){

	}

	function resetTable($table){
		$db = mysqli_connect('localhost', 'admin', 'Password131', 'Test');
		$db->query("DELETE FROM $table");
		$db->query("ALTER TABLE $table AUTO_INCREMENT = 1");
	}

	function addNames(){
		$db = mysqli_connect("localhost", "admin", "Password131", "Test");
		//$db->query("CREATE TABLE `Test`.`femaleNames` ( `id` INT NOT NULL AUTO_INCREMENT, `name` VARCHAR(30) NOT NULL, PRIMARY KEY (`id`))")

		$file = file_get_contents("femaleNames.txt");
		$data = split("\n", $file);
		foreach ($data as $key => $value) {
			//$value = substr($value, 0, strpos($value, " "));
			$db->query("INSERT INTO wishes (value) VALUES ('$value')");
		}
	}

	function generateUsers($argv){
		$db = mysqli_connect("localhost", "admin", "Password131", "Test");
		$i = 0;
		$portion = 1000;
		$nameOffset = $argv[1] / 10;
		while($i < $argv[1]){
			$insertion = "INSERT INTO user (login, pass, wantList) VALUES ";
			for($j = 0; $j < $portion; $j++){
				if($i >= $argv[1])
					break;
				$sex = rand(0, 1);
				$pos = $sex == 0 ? rand(1, 4275) : rand(1, 1219);
				$table = $sex == 0 ? "femaleNames" : "maleNames";
				$res = $db->query("SELECT * FROM $table WHERE id=$pos")->fetch_assoc();
				$name = $res['name'].rand(20, $nameOffset);
				$password = "Password".rand(100, 999);
				$user = new User($name, $password);
				$listSize = rand(1, 10);
				for($x = 0; $x < $listSize; $x++)
					array_push($user->wantList, rand(1, 2328));
				$ser = serialize($user->wantList);
				$insertion .= "('".$user->login."', '".$user->pass."', '$ser'".")";
				if($j != $portion - 1 && $i != $argv[1] - 1)
					$insertion .= ", ";
				$i++;
			}
			$db->query($insertion);
			$newQ = $db->query("SELECT login FROM user");
			if(isset($prevQ)){
				if($prevQ->num_rows == $newQ->num_rows)
					$i -= $portion;
			}
			$prevQ = $newQ;
		}
	}

	//addNames();

	if($argv[2] == 1)
		resetTable("user");
	else
		generateUsers($argv);

	echo "Good\n";

	/*$faker = Faker\Factory::create();

	echo $faker->name;*/

?>