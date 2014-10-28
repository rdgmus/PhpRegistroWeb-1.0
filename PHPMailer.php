<?php

include 'functions/utilities_functions.php';
include 'functions/mysql_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['actionLogout'])) {
		if ($_POST['actionLogout'] == 'Logout') {//Logout button was pressed
			header("Location: http://". $_SERVER['SERVER_NAME'] . "/PhpRegistroScuolaNetBeans/index.php");
		}
	}elseif(isset($_POST['actionEmail'])){
		if ($_POST['actionEmail'] == 'Send Email') {//Send Email button was pressed

			$from = $_COOKIE['email_user'];
			$fromName = 'PhpRegistroScuolaNetBeans:'.$_COOKIE['cognome_user'] . " " . $_COOKIE['nome_user'];

			$sendToArray = getArrayOfRecipientsInMailBox($_COOKIE['emailId'], 'to');
			//echo print_r($sendToArray);

			$replyToArray = array();
			$replyToArray[1] = array('name' => 'PhpRegistroScuolaNetBeans:'.$_COOKIE['cognome_user'] . " " . $_COOKIE['nome_user'], 'email' => $_COOKIE['email_user']);


			$addCCArray = getArrayOfRecipientsInMailBox($_COOKIE['emailId'], 'cc');

			$addBCCArray = getArrayOfRecipientsInMailBox($_COOKIE['emailId'], 'bcc');

			//echo print_r($sendToArray).' '.print_r($addCCArray).''.print_r($addBCCArray);

			$subject = trim($_POST['subject']);
			$htmlBody = trim($_POST['body']);
			$altBody = trim($_POST['body']);//'This is the body in plain text for non-HTML mail clients';

			/*
			 sendEmailWithPHPMailer(
			 $from, $fromName,
			 $sendTo, $sendToName,
			 $replyTo, $replyToName,
			 $addCC,$addCCName,
			 $addBCC,$addBCCName,
			 $subject, $htmlBody, $altBody);
			 */
			$esito = sendEmailArrayWithPHPMailer($_COOKIE['emailId'],$from, $fromName, $sendToArray, $replyToArray, $addCCArray, $addBCCArray, $subject, $htmlBody, $altBody);
			//echo $esito;
			if($esito){
				$result = registerEmailInviata($_COOKIE['emailId']);
				//echo $result;exit();
				if ($result) {
					createEmailAndCookyes();
				}
				setcookie('actionEmail');
			}
			//echo $from.','.$fromName.','.$sendTo.','.$sendToName.','.$replyTo.','.$replyToName;
			echo $_SERVER['SERVER_NAME'];
		}
	}elseif(isset($_POST['actionCreatePdf'])){
		if ($_POST['actionCreatePdf'] == 'Test Pdf'){
			header("Location: http://". $_SERVER['SERVER_NAME'] . "/PhpRegistroScuolaNetBeans/tcpdf/examples/pdf_functions.php");
		}
	}
}
if (!isset($_COOKIE['email_user'])) {
	header("Location: http://". $_SERVER['SERVER_NAME'] . "/PhpRegistroScuolaNetBeans/errorPage.php");
}

?>