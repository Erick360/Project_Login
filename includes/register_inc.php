<?php
	if(isset($_POST['submit'])){
		//add database connection
		require 'database.php';
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirmPass = $_POST['confirmPassword'];

		if(empty($username) || empty($password) || empty($confirmPass)){
			header("Location: ../register.php?error=emptyfields&username=".$username);
			exit();
		}else if(!preg_match("/^[a-zA-Z0-9]*/", $username)){
			header("Location: ../register.php?error=invalidusername&username=".$username);
			exit();
		}else if($password !== $confirmPass){
			header("Location: ../register.php?error=passworsdonotmatch&username=".$username);
			exit();
		}else{
			$sql = "select username from users where username = ?";
			$stmt = mysqli_stmt_init($connection);
			if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../register.php?error=sqlerror");
			exit();
			}else{ 
				mysqli_stmt_bind_param($stmt, "s", $username);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				$rowCount = mysqli_stmt_num_rows($stmt);

				if($rowCount > 0){
					header("Location: ../register.php?error=passworsdonotmatch&usernametaken");
					exit();
				}else{
					$sql = "insert into users (username,password) values(?,?)";
					$stmt = mysqli_stmt_init($connection);
					if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../register.php?error=sqlerror");
					}else{
						$hashedPass = password_hash($password, PASSWORD_DEFAULT); 

						mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPass);
						mysqli_stmt_execute($stmt);
						header("Location: ../register.php?succes=registered");
						exit();
					}
				}
			}
		}
		mysqli_stmt_close($stmt);
		mysqli_close($connection);
	}

?>