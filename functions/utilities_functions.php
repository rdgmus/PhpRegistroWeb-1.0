<?php

/**
 * Nome dell'aplicazione
 */
define("APPLICATION_NAME", "PhpRegistroScuolaNetBeans");

/**
 * 
 * @return type
 */
function getApplicationName() {
    return APPLICATION_NAME;
}

/**
 * 
 * @return type
 */
function getBaseURL() {
    return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://'
            . $_SERVER['HTTP_HOST']
            . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\')
            . '/'
    ;
}

/**
 * Utility per settare i campi dei MsgPop
 * includendo i dati dell'utente per il messaggio di Benvenuto 
 * @param  $Icon [ Icona MsgPop ]
 * @param  $Type [ success, warning, failure ]
 * @param  $file [ json file ]
 * @param  $msg [ messaggio ]
 */
function setMsgPopContent($Icon, $Type, $file, $msg) {
    $json = json_decode(file_get_contents($file), true); //private
//    file_put_contents($file, json_encode($json));
//    return $json;
    $msgPopQueue[] = array(
        "AutoClose" => true,
        "CloseTimer" => 3000,
        "Content" => $msg,
        "Icon" => $Icon,
        "Type" => $Type,
        "displaySmall" => true,
        "position" => "bottom-right"
    );

    $msgPop = array("MsgPopQueue" => $msgPopQueue, "content" => "<div>This is new <b>text!</b></div>");
    
    file_put_contents($file, json_encode($msgPop));
}

/**
 * Imposta un array di json files da richiamare tramite ajax
 * @param unknown_type $contentsArray
 */
function setMsgPopArrayContents($contentsArray) {
    //$Icon, $Type, $file, $msg
    foreach ($contentsArray as $key => $value) {
        setMsgPopContent($value->Icon, $value->Type, $value->file, $value->msg);
    }
}

/**
 * Presa dal web dovrebbe ritornare l'ip del server???
 */
function get_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'] != '127.0.0.1')
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if ($_SERVER['HTTP_X_FORWARDED_FOR'] != '127.0.0.1')
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_X_FORWARDED'] != '127.0.0.1')
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if ($_SERVER['HTTP_FORWARDED_FOR'] != '127.0.0.1')
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_FORWARDED'] != '127.0.0.1')
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1')
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
    //Just get the headers if we can or else use the SERVER global
    if (function_exists('apache_request_headers')) {

        $headers = apache_request_headers();
    } else {

        $headers = $_SERVER;
    }

    //Get the forwarded IP if it exists
    if (array_key_exists('X-Forwarded-For', $headers) && filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {

        $the_ip = $headers['X-Forwarded-For'];
    } elseif (array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
    ) {

        $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
    } else {

        $the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    return $the_ip;
}

/**
 *
 * Rimuove le cookyes degli errori generati in fase di controllo sulla
 * validit� dei campi nel form per il cambiamento delle password propria
 * e degli altri. (queste ultime sono a disposizione solo degli amministratori.
 */
function removeChangePasswordCookyes() {
    setcookie("oldpasswordErr", "", time() - 3600);
    setcookie("newpasswordErr", "", time() - 3600);
    setcookie("repeatPasswordErr", "", time() - 3600);
}

/**
 *
 * Inposta il titolo della pagina da far comparire nel logoTitleFrame.php
 * @param unknown_type $param
 */
function setTitle($param) {
    $GLOBALS['pageTitle'] = $param;
}

/**
 *
 * Un parametro utilizzato in utentiSelectFrame.php per distinguere
 * quale pagina sta incorporando il frame suddetto, e di conseguenza
 * effettuare delle operazioni mirate alla pagina padre.
 * @param unknown_type $param
 */
function setFrameContainer($param) {
    $GLOBALS['container'] = $param;
}

/**
 * Imposta l'immagine del logo che compare ad esempio
 * in logoTitleFrame.php
 * @param  $logoHref
 * @param  $logoSrc
 * @param  $logoAlt
 */
function setLogo($logoHref, $logoSrc, $logoAlt) {
    $GLOBALS['logoHref'] = $logoHref;
    $GLOBALS['logoSrc'] = $logoSrc;
    $GLOBALS['logoAlt'] = $logoAlt;
}

/**
 *
 * Trasformazione dell'input in modo da eliminare spazi superflui,
 * escaped characters, caratteri speciali per l'html
 * @param unknown_type $data
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 *
 * Rimozione di tutte le cookyes registrate
 */
function removeAllCookyes() {
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        }
    }
}

/**
 * 
 * @param type $password
 * @return type
 */
function passwordTestStrenght($password) {
    //VALIDATE PASSWORD
    return filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,20})")));
}

/**
 *
 * Generatore di password di lunghezza definita
 * @param unknown_type $length  la lunghezza della password
 */
function generate_password($length = 20) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' .
            '0123456789``-=~!@#$%^&*()_+,./<>?;:[]{}\|';

    $str = '';
    $max = strlen($chars) - 1;

    for ($i = 0; $i < $length; $i++)
        $str .= $chars[mt_rand(0, $max)];

    return ltrim($str);
}

/**
 *
 * Enter description here ...
 */
function listCookyes() {
    if (count($_COOKIE) > 1)
        echo '<br><span class="error">Cookyes:<h2>' . print_r($_COOKIE, true) . '</h2></span>';
}

/**
 *
 * Enter description here ...
 */
function listSessionAttribute() {
    if (isset($_SESSION)) {
        print_r($_SESSION);
    }
}

/**
 * Chiama la funzione di mysql_functions.php per creare la email nuova e
 * imposta le cookyes relative
 */
function createEmailAndCookyes() {
    require_once './functions/MySqlFunctionsClass.php';

    $mySqlFunctions = new MySqlFunctionsClass();

    $mySqlFunctions->createEmail($_COOKIE['email_user'], $_COOKIE['cognome_user'] . " " . $_COOKIE['nome_user'], $_COOKIE['id_utente']);

    $result = $mySqlFunctions->getNewEmailId($_COOKIE['id_utente']);
    $row = mysql_fetch_assoc($result);
    setcookie('emailId', $row['id_email']);
}

/**
 * Invia un email con il corpo in HTML
 * @param  $to
 * @param  $subject
 * @param  $message
 * @param  $headers
 * @return boolean
 */
function sendHtmlEmail($to, $subject, $message, $headers) {
    //$to = "somebody@example.com, somebodyelse@example.com";
    $subject = "HTML email";

    $message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= 'From: <webmaster@example.com>' . "\r\n";
    $headers .= 'Cc: myboss@example.com' . "\r\n";

    return mail($to, $subject, $message, $headers);
}

/**
 * Invia un email tramite il server di posta impostato nella
 * funzione stessa. I parametri qui sono passati per array.
 * Enter description here ...
 * @param unknown_type $from
 * @param unknown_type $fromName
 * @param unknown_type $sendToArray
 * @param unknown_type $replyToArray
 * @param unknown_type $addCCArray
 * @param unknown_type $addBCCArray
 * @param unknown_type $subject
 * @param unknown_type $htmlBody
 * @param unknown_type $altBody
 */
function sendEmailArrayWithPHPMailer(
$emailId, $from, $fromName, $sendToArray, $replyToArray, $addCCArray, $addBCCArray, $subject, $htmlBody, $altBody
) {
    require 'PHPMailer-master/PHPMailerAutoload.php';

    //include_once 'functions/mysql_functions.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';         // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'rdgmus@gmail.com';                 // SMTP username
    $mail->Password = 'zftsgelnlzgivasq';                 // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->From = $from;
    $mail->FromName = $fromName;

    if (is_array($sendToArray)) {
        foreach ($sendToArray as $i) {
            list($chiave, $nome) = each($i);
            list($chiave, $email) = each($i);
            $mail->addAddress($email, $nome);
        }
    } else {
        $mail->AddAddress($sendToArray, "");
    }

    if (is_array($replyToArray)) {
        foreach ($replyToArray as $i) {
            list($chiave, $nome) = each($i);
            list($chiave, $email) = each($i);
            $mail->addReplyTo($email, $nome);
        }
    } else {
        $mail->addReplyTo($replyToArray, "");
    }

    if (is_array($addCCArray)) {
        foreach ($addCCArray as $i) {
            list($chiave, $nome) = each($i);
            list($chiave, $email) = each($i);
            $mail->addCC($email, $nome);
        }
    } else {
        $mail->addCC($addCCArray, "");
    }

    if (is_array($addBCCArray)) {
        foreach ($addBCCArray as $i) {
            list($chiave, $nome) = each($i);
            list($chiave, $email) = each($i);
            $mail->addBCC($email, $nome);
        }
    } else {
        $mail->addBCC($addBCCArray, "");
    }


    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $htmlBody;
    $mail->AltBody = $altBody;

    if (!$esito = $mail->send()) {
        $msg = '<h2>Message could not be sent.</h2> ' .
                '<h3>Mailer Error:</h3> ' . $mail->ErrorInfo;
        setcookie('status', $msg);
    } else {
        $msg = '<h2>Message has been sent</h2>';
        setcookie('status', $msg);
        //registerEmailInviata($emailId);
    }
    return $esito;
}

/**
 * Invia un email tramite il server di posta impostato nella
 * funzione stessa.
 * @param  $from
 * @param  $fromName
 * @param  $sendTo
 * @param  $sendToName
 * @param  $replyTo
 * @param  $replyToName
 * @param  $addCC
 * @param  $addCCName
 * @param  $addBCC
 * @param  $addBCCName
 * @param  $subject
 * @param  $htmlBody
 * @param  $altBody
 */
function sendEmailWithPHPMailer(
$from, $fromName, $sendTo, $sendToName, $replyTo, $replyToName, $addCC, $addCCName, $addBCC, $addBCCName, $subject, $htmlBody, $altBody
) {
    require 'PHPMailer-master/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';         // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'rdgmus@gmail.com';                 // SMTP username
    $mail->Password = 'zftsgelnlzgivasq';                 // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->From = $from;
    $mail->FromName = $fromName;
    $mail->addAddress($sendTo, $sendToName);         // Add a recipient
    $mail->addReplyTo($replyTo, $replyToName);
    $mail->addCC($addCC, $addCCName);
    $mail->addBCC($addBCC, $addBCCName);

    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $htmlBody;
    $mail->AltBody = $altBody;

    if (!$esito = $mail->send()) {
        $msg = '<h2>Message could not be sent.</h2> ' .
                '<h3>Mailer Error:</h3> ' . $mail->ErrorInfo;
        setcookie('status', $msg);
    } else {
        $msg = '<h2>Message has been sent</h2>';
        setcookie('status', $msg);
    }
    return $esito;
}
