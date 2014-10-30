<?php

include 'functions/utilities_functions.php';
//include 'functions/MySqlFunctionsClass.php';

//$mySqlFunctions = new MySqlFunctionsClass();
/**
 *
 *
 * @author Roberto Della Grotta
 * @version $Id$
 * @copyright , 18 October, 2014
 * @package default
 */
/**
 * 	CHIAMATE A FUNZIONI EFFETTUATE DA TINYMCE PLUGIN
 *
 */
if (isset($_POST['actionRequest'])) {
    if ($_POST['actionRequest'] == 'confirmChangePassword') {
        $hash = ($_POST['hash']);
        $id_request = ($_POST['id_request']);

        echo $mySqlFunctions->setRequestConfirmedFor($hash, $id_request);
        exit();
    }
    echo FALSE;
    exit();
}

if (isset($_POST['callGetEmailSubject'])) {
    if (isset($_POST['emailSubject'])) {
        $subject = ($_POST['emailSubject']);
        $mySqlFunctions->setEmailSubject($_COOKIE['emailId'], $subject);
    }
    echo $mySqlFunctions->getEmailSubject($_COOKIE['emailId']);
}
if (isset($_POST['callGetEmailBody'])) {//emailBody
    if (isset($_POST['emailBody'])) {
        $body = ($_POST['emailBody']);
        $mySqlFunctions->setEmailBody($_COOKIE['emailId'], $body);
    }
    echo $mySqlFunctions->getEmailBody($_COOKIE['emailId']);
}
if (isset($_POST['callUndoToLastRecipient'])) {//cancella ultmo destinatario To textarea
    $mySqlFunctions->undoLastRecipient($_COOKIE['emailId'], 'to');
    echo $mySqlFunctions->getToRecipients($_COOKIE['emailId']);
}
if (isset($_POST['callUndoCcLastRecipient'])) {//cancella ultmo destinatario To textarea
    $mySqlFunctions->undoLastRecipient($_COOKIE['emailId'], 'cc');
    echo $mySqlFunctions->getCcRecipients($_COOKIE['emailId']);
}
if (isset($_POST['callUndoBccLastRecipient'])) {//cancella ultmo destinatario To textarea
    $mySqlFunctions->undoLastRecipient($_COOKIE['emailId'], 'bcc');
    echo $mySqlFunctions->getBccRecipients($_COOKIE['emailId']);
}

/**
 * SELEZIONA LE OPERAZIONI DA SVOLGERE IN BASE AL PARAMETRO page
 * CHE VIENE FORNITO DALLA CHIAMATA $.ajax EFFETTUATA DALL'UTENTE
 */
if (isset($_POST['page'])) {
    $page = $_POST['page'];


    /**
     * $page == 'index.php'
     */
    if ($page == 'index.php') {//index.php
        setcookie('MYSQL_SERVER', trim($_POST['MySqlServer']));
        echo $_SERVER['SERVER_NAME'];
    }
    /**
     * $page == 'emailToUser.php'
     */ elseif ($page == 'emailToUser.php') {//emailToUser.php
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'selectRecipient') {
                setcookie('selectedRecipient', $_POST['selectedRecipient']);
                echo $_SERVER['SERVER_NAME'];
            }
        } elseif (isset($_POST['selectedRecipient'])) {
            $selectedRecipient = $_POST['selectedRecipient'];
            if (isset($_POST['emailButton'])) {
                $emailButton = $_POST['emailButton'];
                $id_email = $_COOKIE['emailId'];
                if ($emailButton == "To") {
                    $to = stripcslashes($_POST['to']); //email destinatario da mettere nella casella TO
                    if (!$mySqlFunctions->recipientExists($id_email, 
                            $mySqlFunctions->getUserEmail($selectedRecipient), 
                            $mySqlFunctions->getUserName($selectedRecipient))) {
                        $mySqlFunctions->addRecipientToEmail($id_email, 
                                $mySqlFunctions->getUserEmail($selectedRecipient), 
                                $mySqlFunctions->getUserName($selectedRecipient), 1, 0, 0, 0);
                        echo $mySqlFunctions->getToRecipients($_COOKIE['emailId']);
                    } else
                        echo $to;
                }elseif ($emailButton == "Cc") {//email destinatario da mettere nella casella CC
                    $cc = stripcslashes($_POST['cc']);
                    if (!$mySqlFunctions->recipientExists($id_email, 
                            $mySqlFunctions->getUserEmail($selectedRecipient), 
                            $mySqlFunctions->getUserName($selectedRecipient))) {
                        $mySqlFunctions->addRecipientToEmail($id_email, 
                                $mySqlFunctions->getUserEmail($selectedRecipient), 
                                $mySqlFunctions->getUserName($selectedRecipient), 0, 1, 0, 0);
                        echo $mySqlFunctions->getCcRecipients($_COOKIE['emailId']);
                    } else
                        echo $cc;
                }elseif ($emailButton == "Bcc") {//email destinatario da mettere nella casella BCC
                    $bcc = stripcslashes($_POST['bcc']);
                    if (!$mySqlFunctions->recipientExists($id_email, 
                            $mySqlFunctions->getUserEmail($selectedRecipient), 
                            $mySqlFunctions->getUserName($selectedRecipient))) {
                        $mySqlFunctions->addRecipientToEmail($id_email, 
                                $mySqlFunctions->getUserEmail($selectedRecipient), 
                                $mySqlFunctions->getUserName($selectedRecipient), 0, 0, 1, 0);
                        echo $mySqlFunctions->getBccRecipients($_COOKIE['emailId']);
                    } else
                        echo $bcc;
                }
            }else {
                echo $mySqlFunctions->getUserName($selectedRecipient) . '<' . $mySqlFunctions->getUserEmail($selectedRecipient) . '>;';
            }
            setcookie('selectedRecipient', $_POST['selectedRecipient']);
        } else {
            echo $_SERVER['SERVER_NAME'];
        }
    }
    /**
     * $page == 'userRegistration.php'
     */ elseif ($page == 'userRegistration.php') {//userRegistration.php
        echo $_SERVER['SERVER_NAME'];
    }
    /**
     * $page == 'userMenu.php'
     */ elseif ($page == 'userMenu.php') {//userMenu.php
        if (isset($_POST['action'])) {
            if ($_POST['action'] == "gotochangeOthersPassword") {
                echo $_SERVER['SERVER_NAME'];
                //echo get_ip();
                //echo $_SERVER['SERVER_ADDR'];
            } elseif ($_POST['action'] == "createEmail") {
                //Crea una nuova email se non ne � stata salvata una

                createEmailAndCookyes();

                echo $_SERVER['SERVER_NAME'];
            } elseif ($_POST['action'] == "backToUserMenu") {
                //cancella le email con data a NULL?
                //$.prompt("Hello World!");
                if (isset($_POST['cancellaEmail'])) {
                    if ($_POST['cancellaEmail'] == 'true') {
                        $mySqlFunctions->deleteNullEmail($_COOKIE['id_utente'], $_COOKIE['emailId']);
                    } else {
                        //Salva Email
                        if (isset($_POST['subject'])) {
                            $subject = $_POST['subject'];
                        }
                        if (isset($_POST['body'])) {
                            $body = $_POST['body'];
                        }
                        $mySqlFunctions->saveEmailDraft($_COOKIE['emailId'], $subject, $body);
                    }
                }
                echo $_SERVER['SERVER_NAME'];
            } elseif ($_POST['action'] == "testUserHasToChangePassword") {
                echo $mySqlFunctions->hasUserToChangePassword($_COOKIE['id_utente']);
            } elseif ($_POST['action'] == "logout") {
                $mySqlFunctions->registerLogEvent("LOGOUT", "LOGOUT DA REGISTRO SCOLASTICO", $_COOKIE['id_utente'], $_SERVER['REMOTE_ADDR']);
                echo $_SERVER['SERVER_NAME'];
            }
        } elseif (isset($_POST['id_ruolo'])) {
            $id_utente = $_POST['selectedUtente'];
            $id_ruolo = $_POST['id_ruolo'];
            $mySqlFunctions->setUnsetRuoloUtente($id_utente, $id_ruolo);
            echo $_SERVER['SERVER_NAME'];
        } elseif (isset($_POST['selectedUtente'])) {
            setcookie('selectedUtente', $_POST['selectedUtente']);
            echo $_SERVER['SERVER_NAME'];
        } else {

            echo $_SERVER['SERVER_NAME'];
        }
    }
    /**
     * $page == 'changePassword.php'
     */ elseif ($page == 'changePassword.php') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'changePassword') {
                $selectedRecipient = $_COOKIE['id_utente']; //$_POST['selectedRecipient'];
                setcookie('selectedRecipient', $selectedRecipient);

                $user_email = $mySqlFunctions->getUserEmail($selectedRecipient);

                $oldpassword = $_POST['oldpassword'];
                $oldpasswordErr = testPasswordErr($oldpassword);
                setcookie('oldpasswordErr', $oldpasswordErr);
                if ($oldpasswordErr != '*') {
                    echo $_SERVER['SERVER_NAME'];
                    exit();
                }


                $password = $_POST['password'];
                $newpasswordErr = testPasswordErr($password);
                setcookie('newpasswordErr', $newpasswordErr);
                if ($newpasswordErr != '*') {
                    echo $_SERVER['SERVER_NAME'];
                    exit();
                }

                $password_one = $_POST['password_one'];
                $repeatPasswordErr = testPasswordsAreEqual($password, $password_one);
                setcookie('repeatPasswordErr', $repeatPasswordErr);
                if ($repeatPasswordErr != '*') {
                    echo $_SERVER['SERVER_NAME'];
                    exit();
                }

                if ($oldpasswordErr == '*' && $newpasswordErr = '*' && $repeatPasswordErr = '*') {
                    changePassword($selectedRecipient, $user_email, $oldpassword, $password);
                    $mySqlFunctions->setUserHasToChangePassword($_COOKIE['id_utente'], 0);

                    echo $_SERVER['SERVER_NAME'];
                    exit();
                }
                echo $_SERVER['SERVER_NAME'];
            }
        }
    }
    /**
     * $page == 'changeOthersPassword.php'
     */ elseif ($page == 'changeOthersPassword.php') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'changeOthersPassword') {
                //removeChangePasswordCookyes();
                $countRowPending = $_POST['countRowPending'];
                if ($countRowPending == 0) {
                    setcookie('message', 'NESSUNA RICHIESTA PENDENTE');
                    echo $_SERVER['SERVER_NAME'];
                    exit();
                }
                $selectedRecipient = $_POST['selectedRecipient'];
                setcookie('selectedRecipient', $selectedRecipient);

                $user_email = $mySqlFunctions->getUserEmail($selectedRecipient);

                $oldpassword = $_POST['oldpassword'];
                $oldpasswordErr = testPasswordErr($oldpassword);
                setcookie('oldpasswordErr', $oldpasswordErr);
                if ($oldpasswordErr != '*') {
                    echo $_SERVER['SERVER_NAME'];
                    exit();
                }


                $password = $_POST['password'];
                $newpasswordErr = testPasswordErr($password);
                setcookie('newpasswordErr', $newpasswordErr);
                if ($newpasswordErr != '*') {
                    echo $_SERVER['SERVER_NAME'];
                    exit();
                }

                $password_one = $_POST['password_one'];
                $repeatPasswordErr = testPasswordsAreEqual($password, $password_one);
                setcookie('repeatPasswordErr', $repeatPasswordErr);
                if ($repeatPasswordErr != '*') {
                    echo $_SERVER['SERVER_NAME'];
                    exit();
                }

                if ($oldpasswordErr == '*' && $newpasswordErr = '*' && $repeatPasswordErr = '*') {
                    //CAMBIA LA PASSWORD DELL'UTENTE
                    if (changePassword($selectedRecipient, $user_email, $oldpassword, $password)) {

                        $from = getUserEmail($_COOKIE['id_utente']);
                        $to = $user_email;
                        $subject = 'Le sue nuove credenziali di accesso sono: <br>' .
                                "Email: " . $user_email . "<br> Password: " . $password;


                        $message_content = 'Al primo accesso con le nuove credenziali, deve cambiare <br>' .
                                "la password per ragioni di sicurezza del suo account. <br>" .
                                "Cordiali Saluti <br> Admin - PhpRegistroScuolaNetBeans ";

                        //Assigning a picture for {logo} replacement
                        $logo = "images/Cbasso1.png";
                        //INVIA IL MESSAGGIO CON LE NUOVE CREDENZIALI ALL'UTENTE
                        include_once 'phpmailer-with-templates/phpmailer-config.php';
                        $status = send_message($from, $to, $subject, $message_content, $logo);
                        if ($status) {//EMAIL INVIATA
                            //AGGIORNA il DATABASE
                            $mySqlFunctions->removePendingFromUserRequest($selectedRecipient, $_COOKIE['id_utente']);
                            $mySqlFunctions->setUserHasToChangePassword($selectedRecipient, 1);
                        }
                    }
                    echo $_SERVER['SERVER_NAME'];
                    exit();
                }
            } elseif ($_POST['action'] == 'selectRecipient') {
                $selectedRecipient = $_POST['selectedRecipient'];
                setcookie('selectedRecipient', $selectedRecipient);
                echo $mySqlFunctions->retrievePassword($selectedRecipient);
            } elseif ($_POST['action'] == 'generatePassword') {
                if (isset($_POST['numChars'])) {
                    $numChars = $_POST['numChars'];
                    echo generate_password($numChars);
                }
            } elseif ($_POST['action'] == 'copyPassword') {
                if (isset($_POST['password'])) {
                    $generatedPassword = $_POST['password'];
                    echo $generatedPassword;
                }
            } else
                echo $_SERVER['SERVER_NAME'];
        }
    }
    else {
        setcookie('selectedUtente', $_POST['selectedUtente']);
    }
}


