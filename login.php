<?php

	//võtab ja kopeerib faili sisu
	require ("../../config.php");


	//GET ja POST muutujad
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	
	//Muutujad
	
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$gender = "male";
	// KUI Tühi
	// $gender = "";
	//($_POST["signupEmail"])
	// on üldse olemas selline muutuja
	$age = "";
	if(isset( $_POST["signupEmail"])){
		
		//jah on olemas
		// kas on tühi
		if( empty($_POST["signupEmail"])){
		
			$signupEmailError = "See väli on kohustuslik";
		
		} else{
			
			//email on õige
			$signupEmail = $_POST["signupEmail"];
		}
	
	}
		
		if(isset( $_POST["signupPassword"])){
		

			if( empty($_POST["signupPassword"])){
			
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk!";
				
			}else{
				
				//siia jõuan siis kui parool oli olemas -isset
				//parool ei olnud tühi -empty
				
				if(strlen($_POST["signupPassword"]) <8 ) {
					
					$signupPasswordError = "Parool peab olema vähemalt 8 tähemärki pikk";
				
				}
			
			}
		}
	
	if ( isset ( $_POST["gender"] ) ) {
		if ( empty ( $_POST["gender"] ) ) {
			$genderError = "See väli on kohustuslik!";
		} else {
			$gender = $_POST["gender"];
		}
	}

	
	// Kus tean, et ühtegi viga ei olenud ja saan kasutaja andmed salvestada
	if ( isset ($_POST["signupPassword"]) &&
		 isset ($_POST["signupEmail"]) &&
		 empty($signupEmailError) && 
		 empty($signupPasswordError) 
		) {
		 
		
		echo "Salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "parool ".$_POST["signupPassword"]. "<br>";
		echo "räsi ".$password."<br>";
		
		//echo $serverUsername;
		
		$database = "if16_jant";
		
		$mysqli = new mysqli ($serverHost, $serverUsername, $serverPassword, $database);
		
		//käsk
		$stmt = $mysqli->prepare("INSERT INTO user_sample(email, password)VALUES (?,?)");
		
		echo $mysqli->error;
		
		//asendan ? väärtustega
		//iga muutuja kohta 1 täht, mis muutuja on
		//s - strin
		//i - integer
		//d - double/float 
		$stmt->bind_param("ss",$signupEmail, $password);
		
		if($stmt->execute()) {
			
			echo "Salvestamine õnnestus";
		} else{
			echo "ERROR".$stmt->error;
		}
		
		
	}
	
	
?>




<!DOCTYPE html>
<html>
<head>
	<title>Logi sisse või loo kasutaja</title>
</head>
<body>

	<h1>Logi sisse</h1>
	<form method="POST">
		<label>E-post</label>
		<br>
		
		<input name="LoginEmail" type="text">
		<br><br>
		
		<input type="password" name="LoginPassword" placeholder="Parool">
		<br><br>
		
		<input type="submit" value="Logi sisse">
		
	
		
	</form>
	
	<h1>Loo kasuataja</h1>
	<form method="POST">
		<label>E-post</label>
		<br>
		
		<input name="signupEmail" type="email" value="<?php echo $signupEmailError;?>"
		<br><br>
		
		<input type="password" name="signupPassword" placeholder="Parool"> <?php echo $signupPasswordError; ?>
		<br><br>
		<?php if($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked> Male<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="male" > Male<br>
			 <?php } ?>
			 
			 <?php if($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked> Female<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="female" > Female<br>
			 <?php } ?>
			 
			 <?php if($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked> Other<br>
			 <?php } else { ?>
				<input type="radio" name="gender" value="other" > Other<br>
			 <?php } ?>
		
		<label>Vanus<label>
		<input name="vanus">
		<br><br>
		<input type="submit" value="Loo kasutaja">
		
	
		
	</form>

</body>
</html>