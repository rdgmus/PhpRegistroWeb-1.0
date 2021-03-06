<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=MacRoman">
        <title>Change Password</title>
        <?php
        include 'functions/utilities_functions.php';
        include './functions/MySqlFunctionsClass.php';

        $mySqlFunctions = new MySqlFunctionsClass();
        ?>
        <?php setTitle('Cambia Password');
        include 'frames/logoTitleFrame.php'; ?>

        <link href="css/PhpRegistroWeb.css" rel="stylesheet">
        <script>
            $(function () {
                pwd = 'passwordChangeMine';
                pwd_repeat = 'passwordChangeMineRepeat';
            });
        </script>
    </head>
    <body>


        <form method="post" id="changePasswordForm"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table border="0" id="userMenuTable">
                <tr align="center">
                    <td colspan="4"><img src="images/LogoPhpRegistroWeb.png"
                                         width="283" height="100" />
                    </td>
                </tr>
                <tr>

                    <?php
                    if (isset($_COOKIE['email_user'])) {
                        $email_value = $_COOKIE['email_user'];
                    } else {
                        $email_value = "";
                    }
                    ?>
                    <td><strong>Email:</strong></td>
                    <td><input name="user_email" type="text"
                               value="<?php echo $email_value; ?>" readonly="readonly" />
                    </td>
                    <td colspan="2"><span class="error"> <?php
                            if (!empty($user_emailErr)) {
                                echo $user_emailErr;
                            } else
                                echo '*';
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Old Password:</strong></td>
                    <td><input name="oldpassword" type="password" id="oldpasswordId" />
                    </td>
                    <td colspan="2"><span class="error"> <?php
                            $oldpasswordErr = isset($_COOKIE['oldpasswordErr']) ? $_COOKIE['oldpasswordErr'] : '*';
                            echo $oldpasswordErr;
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td><strong>New Password:</strong></td>
                    <td><input name="password" type="password" id="passwordChangeMine"/></td>
                    <td colspan="2"><span class="error"> <?php
                            $passwordErr = isset($_COOKIE['newpasswordErr']) ? $_COOKIE['newpasswordErr'] : '*';
                            echo $passwordErr;
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div id="passwordStrengthMine"></div> 
                        <script language="javascript"
                                type="text/javascript">
                                    jQuery(function () {
                                        jQuery("#passwordChangeMine").passwordStrength({
                                            targetDiv: 'passwordStrengthMine',
                                            text: {
                                                year: 'year|years'
                                            }
                                        });
                                    });
                        </script>
                    </td>
                </tr>			
                <tr>
                    <td><strong>Repeat New Password:</strong></td>
                    <td><input name="password_one" type="password" id="passwordChangeMineRepeat" /></td>
                    <td colspan="2"><span class="error"> <?php
                            $repeatPasswordErr = isset($_COOKIE['repeatPasswordErr']) ? $_COOKIE['repeatPasswordErr'] : '*';
                            echo $repeatPasswordErr;
                            ?> </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><img name="actionChangePassword"
                                                       src="images/key_green.png" width="64" height="64"
                                                       title="Esegui cambio Password" id="actionChangePasswordId" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><img src="images/Help.png" width="32" height="32"
                                         id="passwordInfo" title="Formato Password">Genera Passwords</td>
                </tr>
            </table>
        </form>
        <?php
        if (isset($_COOKIE['message'])) {
            ?>
            <div id="dialogEmail" title="Change Password Message">
                <p>
    <?php echo $_COOKIE['message'] ?>
                </p>
            </div>
            <?php
        }
        ?>
    </body>
</html>
