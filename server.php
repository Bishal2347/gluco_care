		<?php
		session_start();
		
			$username = "";
			$email = "";
			$errors = array();
			//connect to database
			$db = mysqli_connect('localhost', 'root','','registration');

		// if the register button is clicked
			if(isset($_POST['register']))
			{
				$username = mysqli_real_escape_string($_POST['username']);
				$email = mysqli_real_escape_string($_POST['email']);
				$password_1 = mysqli_real_escape_string($_POST['password_1']);
				$password_2 = mysqli_real_escape_string($_POST['password_2']);

			//ensure fieilds are filled properly

			if(empty($username))
			{
				array_push($errors, "username is needed");
			}
			if(empty($email))
			{
				array_push($errors, "email is needed");
			}
			if(empty($password_1))
			{
				array_push($errors, "password is needed");
			}

			if($password_1 != $password_2)
			{
				array_push($errors, "the two password do not match");
			}

			//if there are no erros save user to database
			if(count($errors) == 0)
			{
				$password = md5($password_1); // encrytp pass
				$sql = "INSERT INTO users (username,email,password) 
				VALUES ('$username', '$email','$password')";
				mysqli_query($db, $sql);
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "you are now logged in";
				header('location: index.php');


			}


			}

		// log user in from login
			if (isset($_POST['login'])) 
			{
				$username = mysqli_real_escape_string($_POST['username']);
				$password = mysqli_real_escape_string($_POST['password']);

			//ensure fieilds are filled properly

			if(empty($username))
			{
				array_push($errors, "username is needed");
			}
			if(empty($password))
			{
				array_push($errors, "password is needed");
			}
			if (count($errors) == 0)
			{
				$password = md5($password); //encrpyt
				$query = "SELECT * FROM users WHERE username= '$username' AND password='$password'";
				$result = mysqli_query($db,$query);
				
				if (mysqli_num_rows($result) == 1){
				
					$_SESSION['username'] = $username;
					$_SESSION['success'] = "you are now logged in";
					header('location: index.php');
			
				}
				else{
					array_push($errors, "wrong username/password combination");
					
				}		
		}

		}
		// logout
			if (isset($_GET['logout'])) {
				session_destroy();
				unset($_SESSION['username']);
				header('location: index.php');
			}

		?>