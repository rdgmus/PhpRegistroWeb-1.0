

<?php

include 'functions/utilities_functions.php';
include './functions/MySqlFunctionsClass.php';

$mySqlFunctions = new MySqlFunctionsClass();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_emailErr = $passwordErr = $repeatpasswordErr = "";
    $msg = "";
    if (isset($_POST['actionLogin'])) {

        if ($_POST['actionLogin'] == 'Login') {//Login button was pressed
            $user_email = trim($_REQUEST['user_email']);
            $password = trim($_REQUEST['password']);
            $password_one = trim($_REQUEST['password_one']);

            // Arrays to check input against
            if (empty($user_email)) {
                $user_emailErr = 'Email required';
                setcookie("user_emailErr", $user_emailErr);
                exit();
            } else {
                $user_email = test_input($user_email);
                //VALIDATE EMAIL
                if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                    $user_emailErr = "Invalid Email format";
                    setcookie("user_emailErr", $user_emailErr);
                    exit();
                }
            }

            if (empty($password)) {
                $passwordErr = 'Password required';
                setcookie("passwordErr", $passwordErr);
                exit();
            } else {
                $password = test_input($password);
                //VALIDATE PASSWORD
                if (!filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,20})")))) {
                    //da 4 a 10 caratteri, deve contenere maiuscole, minuscole e numeri
                    $passwordErr = "Invalid Password format";
                    setcookie("passwordErr", $passwordErr);
                } else {

                    if (empty($password_one)) {
                        $repeatpasswordErr = 'required';
                        setcookie("repeatpasswordErr", $repeatpasswordErr);
                    } else {
                        $password_one = test_input($password_one);

                        if ($password == $password_one) {
                            //$msg = "Passwords match! ...now searching if user '" . $user_email . "' has a valid account ?<br>";
                            //setcookie("message",$msg);
                            //QUERY FOR DATABASE CONNECTION HERE
                            if ($mySqlFunctions->connectToMySql()) {
                                //QUERY FOR USER ACCOUNT HERE
                                if ($mySqlFunctions->authenticateUser($user_email, $password, TRUE)) {
                                    $mySqlFunctions->registerLogEvent('LOGIN_SUCCESS', 'LOGIN IN REGISTRO SCOLASTICO:SUCCESS', $mySqlFunctions->getUserId($user_email, $password), $_SERVER['REMOTE_ADDR']);

                                    //SETTA LA COOKYE PER IL MESSAGE POP DI BENVENUTO ALL'UTENTE
                                    setcookie('firstLogin', 'true', time() + 10);
                                    //REINDIRIZZA ALLA PAGINA UTENTE
                                    echo ("http://" . $_SERVER['SERVER_NAME'] . "/PhpRegistroScuolaNetBeans/userMenu.php");
                                } else {
                                    $msg = "<h2>Non ho trovato nessun utente con le credenziali proposte!</h2>";
                                    setcookie("message", $msg);
                                    $mySqlFunctions->closeConnection();

                                    $ip = $_SERVER['REMOTE_ADDR'];
                                    $mySqlFunctions->registerLogEventFailure("LOGIN_FAILURE", "TENTATIVO DI ACCESSO CON CREDENZIALI ERRATE email=\"" .
                                            $user_email . "\" password=\"" . $password . "\" DA ip: \"" . $ip . "\"", NULL, $user_email, $password, $ip);
                                }
                            }
                        } else {
                            $repeatpasswordErr = 'Passwords do not match!';
                            setcookie("repeatpasswordErr", $repeatpasswordErr);
                        }
                    }
                }
            }
        } elseif ($_POST['actionLogin'] == 'sendRequestChangePassword') {
            //INOLTRA RICHIESTA INSERENDO UN RECORD NELLA TABELLA change_password_request

            $cognome = $_POST['cognome'];
            $nome = $_POST['nome'];
            $email = $_POST['email'];

            if ($mySqlFunctions->alreadyExistsPasswordRequestFor($cognome, $nome, $email)) {
//                $msg = "<h3>Esiste gi&agrave; una richiesta di cambiamento password per"
//                        . "</h3><h2> ".$cognome." ".$nome." [".$email."]";

                echo (int) 2;
                exit();
            }
            //GENERO UNA CHIAVE UNICA PER L'UTENTE
            $hash = generaHash($cognome + $nome + $email);

            $esito = $mySqlFunctions->postChangePasswordRequest($cognome, $nome, $email, $hash);


            if ($esito) {
                //echo "esito dentro";
                $id_request = $mySqlFunctions->retrieveIdRequest($hash);

                $toLink = "http://" . $_SERVER['SERVER_NAME'] .
                        "/PhpRegistroScuolaNetBeans/confirmRequestByUserPage.php?hash=" . urlencode($hash) .
                        "&id_request=" . $id_request .
                        "&cognome=" . $cognome .
                        "&nome=" . $nome .
                        "&email=" . $email;
                inviaRichiestaConfermaTo($cognome, $nome, $email, $toLink);
                echo (int) 1;
            } else {
                echo (int) 0;
            }
        } elseif ($_POST['actionLogin'] == 'generatePassword') {
            //GENERA PASSWORD
            if (isset($_POST['spinner'])) {
                $spinner = $_POST['spinner'];
                echo generate_password($spinner);
            } else
                echo generate_password();
        }elseif ($_POST['actionLogin'] == 'testPassword') {
            //GENERA PASSWORD
            if (isset($_POST['pwd'])) {
                $pwd = $_POST['pwd'];
                echo passwordTestStrenght($pwd);
            } else
                echo "Digita una password!";
        }elseif ($_POST['actionLogin'] == 'copiaPassword') {
            
        }
    }
}

/**
 * 
 * @param type $cognome
 * @param type $nome
 * @param type $email
 * @param type $toLink
 * @return boolean
 */
function inviaRichiestaConfermaTo($cognome, $nome, $email, $toLink) {
    //INVIA EMAIL PER RICHIESTA CONFERMA
    $from = 'rdgmus@live.com';
    $to = $email;
    $subject = 'Ha inoltrato una richiesta di cambio password';


    $message_content = '<h2>Conferma la richiesta di cambio password? </h2><br>' .
            "In tal caso effettui una connessione al link sottostante " .
            " cliccando su di esso o copiandolo nel suo browser, " .
            " e segua le istruzioni." .
            "Cordiali Saluti <br> Admin - PhpRegistroScuolaNetBeans <br>" .
            "<a href='" . $toLink . "'>" . $toLink . "</a>";

    //Assigning a picture for {logo} replacement
    $logo = "images/Cbasso1.png";
    //INVIA IL MESSAGGIO CON LE NUOVE CREDENZIALI ALL'UTENTE
    include_once 'phpmailer-with-templates/phpmailer-config.php';
    $status = send_message($from, $to, $subject, $message_content, $logo);
    if ($status) {//EMAIL INVIATA
        return TRUE;
    }
    return FALSE;
}

/**
 * 
 * @param type $param
 * @return type
 */
function generaHash($param) {
    return password_hash($param, PASSWORD_DEFAULT);
}
