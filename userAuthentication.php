<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=MacRoman">
<title>User Authentication</title>

<?php echo '<h1>Login</h1><br>';?>
<?php include 'frames/homeFrame.php';?>
<link href="css/PhpRegistroWeb.css" rel="stylesheet">
<script>
    $(function(){
    	pwd = 'passwordAuthenticate';
    	pwd_repeat = 'password_one';
    	
    });
 </script>

</head>
<body>
	<form method="post" id="userAuthenticationForm"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table border="0">
			<tr align="center">
				<td colspan="4"><img src="images/LogoPhpRegistroWeb.png" width="283"
					height="100" />
				</td>
			</tr>
			<tr>
				<td><strong>Email:</strong></td>
				<td><input name="user_email" type="text" id="user_email" />
				</td>
				<td colspan="2"><span class="error"> <?php 
				if(isset($_COOKIE['user_emailErr'])){
					echo $_COOKIE['user_emailErr'];
					
				}else
				echo '*';
				?> </span>
				</td>
			</tr>
			<tr>
				<td><strong>Password:</strong></td>
				<td><input name="password" type="password" id="passwordAuthenticate" />
				</td>
				<td colspan="2"><span class="error"> <?php 
				if(isset($_COOKIE['passwordErr'])){
					echo $_COOKIE['passwordErr'];
				}else
				echo '*';
				?> </span>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<div id="passwordStrengthAuth"></div> <script language="javascript"
						type="text/javascript">
			        jQuery(function(){
			            jQuery("#passwordAuthenticate").passwordStrength({
			                targetDiv:'passwordStrengthAuth',
			                text:{
			                    year:'year|years'           
			                }
			            });
			        });
    			</script>
				</td>
			</tr>
			<tr>
				<td><strong>Repeat Password:</strong></td>
				<td><input name="password_one" type="password" id="password_one" />
				</td>
				<td colspan="2"><span class="error"> <?php 
				if(isset($_COOKIE['repeatpasswordErr'])){
					echo $_COOKIE['repeatpasswordErr'];
				}else
				echo '*';
				?> </span>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right"><img name="actionLogin" title="Login"
					id="loginButton" src="images/log_in.png" width="48" height="48" />
					<img name="actionLogin" title="Vai a 'Registrazione nuovo utente'"
					id="gotoNewUserPage" src="images/edit_user.png" width="48"
					height="48" />
				</td>
			</tr>
			<tr>
				<td colspan="4"><span class="error"><?php 
				//if (isset($_COOKIE['message'])) {
				//echo $_COOKIE['message'];
				//setcookie("message", "", time()-3600);
				//}
				?> </span>
				</td>
			</tr>
			<tr>
				<td colspan="4"><img src="images/Help.png" width="32" height="32"
					id="passwordInfo" title="Formato Password">Genera Passwords</td>
			</tr>
			<tr>
				<td colspan="4"><img src="images/key_red.png" width="32" height="32"
					id="requestPasswordChange" title="Password dimenticata">Password
					dimenticata?</td>
				<td>
					<div id="results"></div>
				</td>
			</tr>
		</table>
		
		
	</form>
	<?php //if (isset($_COOKIE['actionEmail'])) {
	//setcookie('actionEmail',"",time()-3600);
	if (isset( $_COOKIE['message'])) {
		?>
	<div id="dialogEmail" title="Info">
		<p>
		<?php if (isset($_COOKIE['message'])) {
			echo $_COOKIE['message'];
		}?>
		</p>
	</div>
	<?php
	}
	//}?>

</body>
</html>
