<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
    <head>
        <link href="css/PhpRegistroWeb.css" rel="stylesheet">

        <meta http-equiv="Content-Type" content="text/html; charset=MacRoman">
        <title>User Menu</title>
        <?php
        include 'functions/utilities_functions.php';
        include './functions/MySqlFunctionsClass.php';


        $mySqlFunctions = new MySqlFunctionsClass();
        ?>
        <?php
        setTitle($mySqlFunctions->userIsAdministrator($_COOKIE['id_utente']) ? 'Men&ugrave Amministratore' : 'Men&ugrave Utente');
        include 'frames/logoTitleFrame.php';
        ?>
        <script>
            $(document).ready(function () {

                $(function () {
//                    $.toast("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic, consequuntur doloremque eveniet eius eaque dicta repudiandae illo ullam. Minima itaque sint magnam dolorum asperiores repudiandae dignissimos expedita, voluptatum vitae velit.");

                    if ($.cookie('firstLogin')) {
                        if ($.cookie('firstLogin') == 'true') {
                            if ($.cookie('id_utente')) {
                                createBenvenutoUserContent();

                            }
                        }
                    }

                });
            });
        </script>
    </head>
    <body>
        <form method="post" id="userMenuForm"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table id="userMenuTable">
                <tr>
                    <th>Logout</th>
                    <th>Invia Email</th>
                    <th colspan="2">Cambia Password</th>
                    <?php echo $mySqlFunctions->userIsAdministrator($_COOKIE['id_utente']) ? '<th>Gestisci Ruoli Utenti</th>' : '' ?>

                </tr>
                <tr>
                    <td align="center" valign="top"><img name="actionLogout"
                                                         id="logoutButton" src="images/exit.png" width="48" height="48"
                                                         title="Logout" />
                    </td>

                    <td align="center" valign="top"><h3>

                            <img id="emailButton" src="images/send_email_user_letter.png"
                                 width="48" height="48" title="Invia Email" />
                        </h3></td>
                    <td align="center" valign="top"><img name="actionChangePassword"
                                                         src="images/psp/myPasswordChange.png" width="48" height="48"
                                                         id="changePassword" title="Cambia tua Password" />
                    </td>
                    <?php
                    /**
                     * Menu che compaiono solo per l'amministratore
                     */
                    if ($mySqlFunctions->userIsAdministrator($_COOKIE['id_utente'])) {
                        include 'frames/othersPasswordFrame.php';
                        include 'frames/ruoliUtenteFrame.php';
                    }
                    ?>

                </tr>
            </table>
        </form>
        <?php
        if (isset($_COOKIE['message'])) {
            ?>
            <div id="dialogEmail" title="Change Password">
                <p>


                <h2>
                    <?php echo $_COOKIE['message'] ?>
                </h2>
            </div>
            <?php
        }
        ?>

    </body>
</html>
