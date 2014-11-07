<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
    <!-- 
/**
 * 
 *
 * @author Roberto Della Grotta
 * @version $Id$
 * @copyright , 28 October, 2014
 * @package default
 */

/**
 * Define DocBlock
 */

    -->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=MacRoman">
        <title>Login</title>


        <?php echo '<h1>PhpRegistroWeb 1.0</h1><br>'; ?>
        <?php include 'jquery/jquery.php'; ?>
        <?php
        include 'functions/utilities_functions.php';
        include 'functions/MySqlFunctionsClass.php';

        $mySqlFunctions = new MySqlFunctionsClass();
        ?>
        <link href="css/PhpRegistroWeb.css" rel="stylesheet">

        <!----------
        jqPlot 
       ---------->

        <script language="javascript" type="text/javascript" src="jquery/jqplot/jquery.jqplot.min.js"></script>
        <link rel="stylesheet" type="text/css" href="jquery/jqplot/jquery.jqplot.min.css" />

        <script type="text/javascript" src="jquery/jqplot/plugins/jqplot.barRenderer.min.js"></script>
        <script type="text/javascript" src="jquery/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="jquery/jqPlot/plugins/jqplot.pointLabels.min.js"></script>
        <script type="text/javascript" src="jquery/jqPlot/plugins/jqplot.dateAxisRenderer.min.js"></script>

        <script>
            $(document).ready(function () {
                // Stuff to do as soon as the DOM is ready;
                $(function () {
                    $("#datepicker").datepicker("setDate", "now");
                });
                 
            });

        </script>

    </head>
    <body>
        <form method="post" id="indexForm"
              action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <table id="mailUserTable">
                <tr>
                    <td>
                        <table border="0" id="mailUserTable">
                            <tr align="center">
                                <td colspan="3"><img src="images/LogoPhpRegistroWeb.png"
                                                     width="500" height="250" />
                                </td>
                            </tr>
                            <tr>

                                <?php
                                if (!isset($_COOKIE['MYSQL_SERVER'])) {
                                    $_COOKIE['MYSQL_SERVER'] = 'SOCKET:3307';
                                }
                                $MySqlServer = $_COOKIE['MYSQL_SERVER'];
                                ?>
                                <?php
                                $serverGroups = $mySqlFunctions->getMySqlServerGroups();
                                ?>
                                <td align="right"><select name="MySqlServer" id="MySqlServer"
                                                          >
                                                              <?php
                                                              while ($row = mysql_fetch_assoc($serverGroups)) {
                                                                  ?>
                                            <optgroup label="<?php echo $row['server_group']; ?>">
                                                <?php
                                                $serverParams = $mySqlFunctions->getMySqlServerParams($row['id_server_group']);
                                                while ($params = mysql_fetch_assoc($serverParams)) {
                                                    ?>
                                                    <option value="<?php echo $params['server_name']; ?>"
                                                    <?php
                                                    if ($MySqlServer == $params['server_name']) {
                                                        echo ' selected="selected" ';
                                                    }
                                                    ?>><?php echo $params['note'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                        </optgroup>
                                    </select>
                                </td>

                                <td><img name="actionRegister"
                                         title="Vai a Registrazione nuovo utente" src="images/edit_user.png"
                                         id="startNewUserPage" width="48" height="48" />
                                </td>
                                <td><img name="actionRegister" title="Vai al 'Login'"
                                         src="images/log_in.png" id="startLoginPage" width="48" height="48" />
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td>
                        <table width="100%" id="userMenuTable">
                            <tr>
                                <td>Oggi => <input type="text" id="datepicker" readonly="true"></td>                              
                            </tr>
                            <tr>
                                <td>
                                    <h1>
                                        Prova le connessioni a MySql 
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2> <!-- try -->
                                        <a href="./tryConnections.php">Try Connections</a>
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h1>
                                        Documentazione
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2><a href="apigen/" id="apigen">ApiGen</a> </h2>
                                    <h2><a href="phpdoc/output/">PhpDoc</a> </h2>
                                    <!--<h2><a href="https://github.com/rdgmus/PhpProjects/wiki">WIKI</a> </h2>-->
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php include_once 'frames/startPlotsFrame.php'; ?>
                    </td>
                </tr>
            </table>

        </form>

        <?php
        if (isset($_COOKIE['message'])) {
            ?>
            <div id="dialogEmail" title="Email Message">
                <p>
                    <?php echo $_COOKIE['message'] ?>
                </p>
            </div>
            <?php
        }
        ?>

    </body>
</html>
