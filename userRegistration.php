<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=MacRoman">
        <title>User registration</title>
        <?php
        include 'functions/utilities_functions.php';
        include './functions/MySqlFunctionsClass.php';

        $mySqlFunctions = new MySqlFunctionsClass();
        ?>

        <?php echo '<h1>Registrazione Nuovo Utente</h1><br>'; ?>
        <?php include 'jquery/jquery.php'; ?>

        <?php include 'frames/homeFrame.php';?>
        <link href="css/PhpRegistroWeb.css" rel="stylesheet">
        <script>
            $(function () {
                pwd = 'passwordRegistrate';
                pwd_repeat = 'password_two';
            });
        </script>

    </head>
    <body>



        <form method="post" id="userRegistrationForm"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table border="0">
                <tr align="center">
                    <td colspan="2"><img src="images/LogoPhpRegistroWeb.png"
                                         width="283" height="100" />
                    </td>
                </tr>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td><input name="name" type="text" id="name"
                        <?php if (isset($_COOKIE['newUserName'])) { ?>
                                   value="<?php echo trim($_COOKIE['newUserName']); ?>" <?php } ?> /></td>
                    <td colspan="2"><span class="error"> <?php
                            if (isset($_COOKIE['nameErr'])) {
                                echo $_COOKIE['nameErr'];
                            } else
                                echo '*';
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Surname:</strong></td>
                    <td><input name="surname" type="text"
                        <?php if (isset($_COOKIE['newUserSurname'])) { ?>
                                   value="<?php echo trim($_COOKIE['newUserSurname']); ?>" <?php } ?> />
                    </td>
                    <td colspan="2"><span class="error"> <?php
                            if (isset($_COOKIE['surnameErr'])) {
                                echo $_COOKIE['surnameErr'];
                            } else
                                echo '*';
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td><input name="user_email" type="text"
                               value="<?php
                               if (isset($_COOKIE['newUserEmail'])) {
                                   echo $_COOKIE['newUserEmail'];
                               } else {
                                   echo "";
                               }
                               ?>" /></td>
                    <td colspan="2"><span class="error"> <?php
                            if (isset($_COOKIE['user_emailErr'])) {
                                echo $_COOKIE['user_emailErr'];
                            } else
                                echo '*';
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Password:</strong>
                    </td>
                    <td><input name="password" type="password" id="passwordRegistrate"
                               value="<?php
                               if (isset($_COOKIE['newUserPassword'])) {
                                   echo $_COOKIE['newUserPassword'];
                               } else {
                                   echo "";
                               }
                               ?>" /></td>

                    <td colspan="2"><span class="error"> <?php
                            if (isset($_COOKIE['passwordErr'])) {
                                echo $_COOKIE['passwordErr'];
                            } else
                                echo '*';
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div id="passwordStrengthRegister"></div> 
                        <script language="javascript"
                                type="text/javascript">
                                    jQuery(function () {
                                        jQuery("#passwordRegistrate").passwordStrength({
                                            targetDiv: 'passwordStrengthRegister',
                                            text: {
                                                year: 'year|years'
                                            }
                                        });
                                    });
                        </script>
                    </td>
                </tr>			
                <tr>
                    <td><strong>Repeat Password:</strong>
                    </td>
                    <td><input name="password_one" type="password" id="password_two"
                               value="<?php
                               if (isset($_COOKIE['newUserRepeatPassword'])) {
                                   echo $_COOKIE['newUserRepeatPassword'];
                               } else {
                                   echo "";
                               }
                               ?>" /></td>
                    <td colspan="2"><span class="error"> <?php
                            if (isset($_COOKIE['repeatpasswordErr'])) {
                                echo $_COOKIE['repeatpasswordErr'];
                            } else
                                echo '*';
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><img name="actionRegister"
                                                       src="images/add_user.png" width="48" height="48"
                                                       title="Registra Nuovo Utente" id="registerButton" /> <img
                                                       name="actionRegister" title="Pulisci"
                                                       src="images/Clear-64.png" id="clearNewUserFields"
                                                       width="48" height="48" /> <img name="actionRegister"
                                                       title="Vai al 'Login'" src="images/log_in.png" id="gotoLoginPage"
                                                       width="48" height="48" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><img src="images/Help.png" width="32" height="32" id="passwordInfo" 
                                         title="Formato Password">Genera Passwords				
                    </td>
                </tr>
            </table>
        </form>
        <?php
        //if (isset($_COOKIE['actionEmail'])) {
        //setcookie('actionEmail',"",time()-3600);
        if (isset($_COOKIE['message'])) {
            ?>
            <div id="dialogEmail" title="Formato Password">
                <p>
                    <?php
                    if (isset($_COOKIE['message'])) {
                        echo $_COOKIE['message'];
                    }
                    ?>
                </p>
            </div>
            <?php
        }
//}
        ?>

    </body>
</html>
