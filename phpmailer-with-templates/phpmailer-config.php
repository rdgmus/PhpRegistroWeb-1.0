<?php
/**
 * phpmailer-config.php
 * Provides assistive function to use PHPMailer class
 *
 * @author Bennett Stone
 * @link phpdevtips.com
 * @version 1.0
 * @date 10-Jul-2014
 * @package PHPMailer Demo
 **/

/**
 * Send messages using phpmailer
 * For SMTP, define user, pass, location, and port in global index.php or config.php
 *
 * @access public
 * @param string sender email
 * @param string receiver email
 * @param string subject
 * @param string message
 * @return string error
 * @return bool success
 */
function send_message( $from, $to, $subject, $message_content, $logo )
{
	//Include the phpmailer files
	require_once( 'phpmailer/PHPMailerAutoload.php' );

	//Initiate the mailer class
	$mail = new PHPMailer();

	//Check to see if SMTP creds have been defined
	if( defined( 'SMTP_USER' ) && defined( 'SMTP_PASS' ) && defined( 'SMTP_LOCATION' ) && defined( 'SMTP_PORT' ) )
	{
		$mail->IsSMTP();
		$mail->Host = SMTP_LOCATION;
		$mail->SMTPAuth = true;
		$mail->Port = SMTP_PORT;
		$mail->Username = SMTP_USER;
		$mail->Password = SMTP_PASS;

		if( defined( 'DEBUG' ) && DEBUG )
		{
			$mail->SMTPDebug  = 1;
		}
	}else{
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  					  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'rdgmus@gmail.com';                 // SMTP username
		$mail->Password = 'zftsgelnlzgivasq';                 // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to
			
	}

	//Set the sender and receiver email addresses
	$mail->SetFrom( $from, "" );

	//We 'can' send to an array, in which case you'll want to explode at comma or line break
	if( is_array( $to ) )
	{
		foreach( $to as $i )
		{
			$mail->addAddress( $i );
		}
	}
	else
	{
		$mail->AddAddress( $to, "" );
	}

	$mail->addReplyTo($from, "");
	$mail->addBCC($from, "");

	//Set the message subject
	$mail->Subject = strip_tags( stripslashes( $subject ));

	//Add the message header
	$message = file_get_contents( 'email-templates/email-header.php' );

	//Add the message body
	$message .= file_get_contents( 'email-templates/email-body.php' );

	//Add the message footer content
	$message .= file_get_contents( 'email-templates/email-footer.php' );

	//Replace the codetags with the message contents
	$replacements = array(
        '({logo})' => $logo, 
        '({message_subject})' => $subject, 
        '({organization})' => 'Key Orchestra', 
		'({sitename})' => 'PhpRegistroWeb 1.0', 
		'({admin_email})' => 'rdgmus@live.com', 
		'({admin_phone})' => '335-8422012', 
		'({message_body})' => nl2br( stripslashes( $message_content ) )
	);
	$message = preg_replace( array_keys( $replacements ), array_values( $replacements ), $message );

	//Make the generic plaintext separately due to lots of css and tables
	$plaintext = $message_content;
	$plaintext = strip_tags( stripslashes( $plaintext ), '<p><br><h2><h3><h1><h4>' );
	$plaintext = str_replace( array( '<p>', '<br />', '<br>', '<h1>', '<h2>', '<h3>', '<h4>' ), PHP_EOL, $plaintext );
	$plaintext = str_replace( array( '</p>', '</h1>', '</h2>', '</h3>', '</h4>' ), '', $plaintext );
	$plaintext = html_entity_decode( stripslashes( $plaintext ) );

	//Send the message as HTML
	$mail->MsgHTML( stripslashes( $message ) );
	//Set the plain text version just in case
	$mail->AltBody = $plaintext;

	//Display success or error messages
	if( !$mail->Send() )
	{
		$status = 'Errore nell\'invio del messaggio: ' . $mail->ErrorInfo;
		setcookie('status', $status);
		return FALSE;
	}
	else
	{
		//You'll usually want to just return true, but for the purposes of this
		//Example I'm returning the message contents
		$status = 'Messaggio inviato con successo a: '.$to;
		setcookie('status', $status);
		return TRUE;
	}
}

/* End of file phpmailer-config.php */