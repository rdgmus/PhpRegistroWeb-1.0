<?php

include 'functions/utilities_functions.php';
include 'functions/MySqlFunctionsClass.php';

$mySqlFunctions = new MySqlFunctionsClass();
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
//filter_input(INPUT_POST, 'var_name') instead of $_POST['var_name']
if (NULL != filter_input(INPUT_POST, 'actionRequest')) {
    if (filter_input(INPUT_POST, 'actionRequest') == 'confirmChangePassword') {
        $hash = (filter_input(INPUT_POST, 'hash'));
        $id_request = (filter_input(INPUT_POST, 'id_request'));

        echo $mySqlFunctions->setRequestConfirmedFor($hash, $id_request);
        exit();
    }
    echo FALSE;
    exit();
}

if (NULL != filter_input(INPUT_POST, 'callGetEmailSubject')) {
    if (NULL != filter_input(INPUT_POST, 'emailSubject')) {
        $subject = (filter_input(INPUT_POST, 'emailSubject'));
        $mySqlFunctions->setEmailSubject(filter_input(INPUT_COOKIE, 'emailId'), $subject);
    }
    echo $mySqlFunctions->getEmailSubject(filter_input(INPUT_COOKIE, 'emailId'));
}

if (NULL != filter_input(INPUT_POST, 'callGetEmailBody')) {//emailBody
    if (NULL != filter_input(INPUT_POST, 'emailBody')) {
        $body = filter_input(INPUT_POST, 'emailBody');
        $mySqlFunctions->setEmailBody(filter_input(INPUT_COOKIE, 'emailId'), $body);
    }
    echo $mySqlFunctions->getEmailBody(filter_input(INPUT_COOKIE, 'emailId'));
}
if (NULL != filter_input(INPUT_POST, 'callUndoToLastRecipient')) {//cancella ultmo destinatario To textarea
    $mySqlFunctions->undoLastRecipient(filter_input(INPUT_COOKIE, 'emailId'), 'to');
    echo $mySqlFunctions->getToRecipients(filter_input(INPUT_COOKIE, 'emailId'));
}
if (NULL != filter_input(INPUT_POST, 'callUndoCcLastRecipient')) {//cancella ultmo destinatario To textarea
    $mySqlFunctions->undoLastRecipient(filter_input(INPUT_COOKIE, 'emailId'), 'cc');
    echo $mySqlFunctions->getCcRecipients(filter_input(INPUT_COOKIE, 'emailId'));
}
if (NULL != filter_input(INPUT_POST, 'callUndoBccLastRecipient')) {//cancella ultmo destinatario To textarea
    $mySqlFunctions->undoLastRecipient(filter_input(INPUT_COOKIE, 'emailId'), 'bcc');
    echo $mySqlFunctions->getBccRecipients(filter_input(INPUT_COOKIE, 'emailId'));
}

/**
 * SELEZIONA LE OPERAZIONI DA SVOLGERE IN BASE AL PARAMETRO page
 * CHE VIENE FORNITO DALLA CHIAMATA $.ajax EFFETTUATA DALL'UTENTE
 */
if (NULL != filter_input(INPUT_POST, 'page')) {
    $page = filter_input(INPUT_POST, 'page');


    /**
     * $page == 'index.php'
     */
    if ($page == 'index.php') {//index.php
        setcookie('MYSQL_SERVER', trim(filter_input(INPUT_POST, 'MySqlServer')));
        echo filter_input(INPUT_SERVER, 'SERVER_NAME');
    }
    /**
     * $page == 'emailToUser.php'
     */ elseif ($page == 'emailToUser.php') {//emailToUser.php
        if (NULL != filter_input(INPUT_POST, 'action')) {
            if (filter_input(INPUT_POST, 'action') == 'selectRecipient') {
                setcookie('selectedRecipient', filter_input(INPUT_POST, 'selectedRecipient'));
                echo filter_input(INPUT_SERVER, 'SERVER_NAME');
            }
        } elseif (NULL != filter_input(INPUT_POST, 'selectedRecipient')) {
            $selectedRecipient = filter_input(INPUT_POST, 'selectedRecipient');
            if (NULL != filter_input(INPUT_POST, 'emailButton')) {
                $emailButton = filter_input(INPUT_POST, 'emailButton');
                $id_email = filter_input(INPUT_COOKIE, 'emailId');
                if ($emailButton == "To") {
                    $to = stripcslashes(filter_input(INPUT_POST, 'to')); //email destinatario da mettere nella casella TO
                    if (!$mySqlFunctions->recipientExists($id_email, $mySqlFunctions->getUserEmail($selectedRecipient), $mySqlFunctions->getUserName($selectedRecipient))) {
                        $mySqlFunctions->addRecipientToEmail($id_email, $mySqlFunctions->getUserEmail($selectedRecipient), $mySqlFunctions->getUserName($selectedRecipient), 1, 0, 0, 0);
                        echo $mySqlFunctions->getToRecipients(filter_input(INPUT_COOKIE, 'emailId'));
                    } else {
                        echo $to;
                    }
                }elseif ($emailButton == "Cc") {//email destinatario da mettere nella casella CC
                    $cc = stripcslashes(filter_input(INPUT_POST, 'cc'));
                    if (!$mySqlFunctions->recipientExists($id_email, $mySqlFunctions->getUserEmail($selectedRecipient), $mySqlFunctions->getUserName($selectedRecipient))) {
                        $mySqlFunctions->addRecipientToEmail($id_email, $mySqlFunctions->getUserEmail($selectedRecipient), $mySqlFunctions->getUserName($selectedRecipient), 0, 1, 0, 0);
                        echo $mySqlFunctions->getCcRecipients(filter_input(INPUT_COOKIE, 'emailId'));
                    } else {
                        echo $cc;
                    }
                }elseif ($emailButton == "Bcc") {//email destinatario da mettere nella casella BCC
                    $bcc = stripcslashes(filter_input(INPUT_POST, 'bcc'));
                    if (!$mySqlFunctions->recipientExists($id_email, $mySqlFunctions->getUserEmail($selectedRecipient), $mySqlFunctions->getUserName($selectedRecipient))) {
                        $mySqlFunctions->addRecipientToEmail($id_email, $mySqlFunctions->getUserEmail($selectedRecipient), $mySqlFunctions->getUserName($selectedRecipient), 0, 0, 1, 0);
                        echo $mySqlFunctions->getBccRecipients(filter_input(INPUT_COOKIE, 'emailId'));
                    } else {
                        echo $bcc;
                    }
                }
            }else {
                echo $mySqlFunctions->getUserName($selectedRecipient) . '<' . $mySqlFunctions->getUserEmail($selectedRecipient) . '>;';
            }
            setcookie('selectedRecipient', filter_input(INPUT_POST, 'selectedRecipient'));
        } else {
            echo filter_input(INPUT_SERVER, 'SERVER_NAME');
        }
    }
    /**
     * $page == 'userRegistration.php'
     */ elseif ($page == 'userRegistration.php') {//userRegistration.php
        echo filter_input(INPUT_SERVER, 'SERVER_NAME');
    }
    /**
     * $page == 'userMenu.php'
     */ elseif ($page == 'userMenu.php') {//userMenu.php
        if (NULL != filter_input(INPUT_POST, 'action')) {
            if (filter_input(INPUT_POST, 'action') == "gotochangeOthersPassword") {
                echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                //echo get_ip();
                //echo $_SERVER['SERVER_ADDR'];
            } elseif (filter_input(INPUT_POST, 'action') == "createEmail") {
                //Crea una nuova email se non ne � stata salvata una

                createEmailAndCookyes();

                echo filter_input(INPUT_SERVER, 'SERVER_NAME');
            } elseif (filter_input(INPUT_POST, 'action') == "backToUserMenu") {
                //cancella le email con data a NULL?
                //$.prompt("Hello World!");
                if (NULL != filter_input(INPUT_POST, 'cancellaEmail')) {
                    if (filter_input(INPUT_POST, 'cancellaEmail') == 'true') {
                        $mySqlFunctions->deleteNullEmail(filter_input(INPUT_COOKIE, 'id_utente'), filter_input(INPUT_COOKIE, 'emailId'));
                    } else {
                        //Salva Email
                        if (NULL != filter_input(INPUT_POST, 'subject')) {
                            $subject = filter_input(INPUT_POST, 'subject');
                        }
                        if (NULL != filter_input(INPUT_POST, 'body')) {
                            $body = filter_input(INPUT_POST, 'body');
                        }
                        $mySqlFunctions->saveEmailDraft(filter_input(INPUT_COOKIE, 'emailId'), $subject, $body);
                    }
                }
                echo filter_input(INPUT_SERVER, 'SERVER_NAME');
            } elseif (filter_input(INPUT_POST, 'action') == "testUserHasToChangePassword") {
                echo $mySqlFunctions->hasUserToChangePassword(filter_input(INPUT_COOKIE, 'id_utente'));
            } elseif (filter_input(INPUT_POST, 'action') == "logout") {
                $mySqlFunctions->registerLogEvent("LOGOUT", "LOGOUT DA REGISTRO SCOLASTICO", filter_input(INPUT_COOKIE, 'id_utente'), filter_input(INPUT_SERVER, 'REMOTE_ADDR'));
                echo filter_input(INPUT_SERVER, 'SERVER_NAME');
            }
        } elseif (NULL != filter_input(INPUT_POST, 'id_ruolo')) {
            $id_utente = filter_input(INPUT_POST, 'selectedUtente');
            $id_ruolo = filter_input(INPUT_POST, 'id_ruolo');
            $mySqlFunctions->setUnsetRuoloUtente($id_utente, $id_ruolo);
            echo filter_input(INPUT_SERVER, 'SERVER_NAME');
        } elseif (NULL != filter_input(INPUT_POST, 'selectedUtente')) {
            setcookie('selectedUtente', filter_input(INPUT_POST, 'selectedUtente'));
            echo filter_input(INPUT_SERVER, 'SERVER_NAME');
        } else {

            echo filter_input(INPUT_SERVER, 'SERVER_NAME');
        }
    }
    /**
     * $page == 'changePassword.php'
     */ elseif ($page == 'changePassword.php') {
        if (NULL != filter_input(INPUT_POST, 'action')) {
            if (filter_input(INPUT_POST, 'action') == 'changePassword') {
                $selectedRecipient = filter_input(INPUT_COOKIE, 'id_utente'); //$_POST['selectedRecipient'];
                setcookie('selectedRecipient', $selectedRecipient);

                $user_email = $mySqlFunctions->getUserEmail($selectedRecipient);

                $oldpassword = filter_input(INPUT_POST, 'oldpassword');
                $oldpasswordErr = testPasswordErr($oldpassword);
                setcookie('oldpasswordErr', $oldpasswordErr);
                if ($oldpasswordErr != '*') {
                    echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                    exit();
                }


                $password = filter_input(INPUT_POST, 'password');
                $newpasswordErr = testPasswordErr($password);
                setcookie('newpasswordErr', $newpasswordErr);
                if ($newpasswordErr != '*') {
                    echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                    exit();
                }

                $password_one = filter_input(INPUT_POST, 'password_one');
                $repeatPasswordErr = testPasswordsAreEqual($password, $password_one);
                setcookie('repeatPasswordErr', $repeatPasswordErr);
                if ($repeatPasswordErr != '*') {
                    echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                    exit();
                }

                if ($oldpasswordErr == '*' && $newpasswordErr = '*' && $repeatPasswordErr = '*') {
                    changePassword($selectedRecipient, $user_email, $oldpassword, $password);
                    $mySqlFunctions->setUserHasToChangePassword(filter_input(INPUT_COOKIE, 'id_utente'), 0);

                    echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                    exit();
                }
                echo filter_input(INPUT_SERVER, 'SERVER_NAME');
            }
        }
    }
    /**
     * $page == 'changeOthersPassword.php'
     */ elseif ($page == 'changeOthersPassword.php') {
        if (NULL != filter_input(INPUT_POST, 'action')) {
            if (filter_input(INPUT_POST, 'action') == 'changeOthersPassword') {
                //removeChangePasswordCookyes();
                $countRowPending = filter_input(INPUT_POST, 'countRowPending');
                if ($countRowPending == 0) {
                    setcookie('message', 'NESSUNA RICHIESTA PENDENTE');
                    echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                    exit();
                }
                $selectedRecipient = filter_input(INPUT_POST, 'selectedRecipient');
                setcookie('selectedRecipient', $selectedRecipient);

                $user_email = $mySqlFunctions->getUserEmail($selectedRecipient);

                $oldpassword = filter_input(INPUT_POST, 'oldpassword');
                $oldpasswordErr = testPasswordErr($oldpassword);
                setcookie('oldpasswordErr', $oldpasswordErr);
                if ($oldpasswordErr != '*') {
                    echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                    exit();
                }


                $password = filter_input(INPUT_POST, 'password');
                $newpasswordErr = testPasswordErr($password);
                setcookie('newpasswordErr', $newpasswordErr);
                if ($newpasswordErr != '*') {
                    echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                    exit();
                }

                $password_one = filter_input(INPUT_POST, 'password_one');
                $repeatPasswordErr = testPasswordsAreEqual($password, $password_one);
                setcookie('repeatPasswordErr', $repeatPasswordErr);
                if ($repeatPasswordErr != '*') {
                    echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                    exit();
                }

                if ($oldpasswordErr == '*' && $newpasswordErr = '*' && $repeatPasswordErr = '*') {
                    //CAMBIA LA PASSWORD DELL'UTENTE
                    if (changePassword($selectedRecipient, $user_email, $oldpassword, $password)) {

                        $from = getUserEmail(filter_input(INPUT_COOKIE, 'id_utente'));
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
                            $mySqlFunctions->removePendingFromUserRequest($selectedRecipient, filter_input(INPUT_COOKIE, 'id_utente'));
                            $mySqlFunctions->setUserHasToChangePassword($selectedRecipient, 1);
                        }
                    }
                    echo filter_input(INPUT_SERVER, 'SERVER_NAME');
                    exit();
                }
            } elseif (filter_input(INPUT_POST, 'action') == 'selectRecipient') {
                $selectedRecipient = filter_input(INPUT_POST, 'selectedRecipient');
                setcookie('selectedRecipient', $selectedRecipient);
                echo $mySqlFunctions->retrievePassword($selectedRecipient);
            } elseif (filter_input(INPUT_POST, 'action') == 'generatePassword') {
                if (NULL != filter_input(INPUT_POST, 'numChars')) {
                    $numChars = filter_input(INPUT_POST, 'numChars');
                    echo generate_password($numChars);
                }
            } elseif (filter_input(INPUT_POST, 'action') == 'copyPassword') {
                if (NULL != filter_input(INPUT_POST, 'password')) {
                    $generatedPassword = filter_input(INPUT_POST, 'password');
                    echo $generatedPassword;
                }
            } else {
                echo filter_input(INPUT_SERVER, 'SERVER_NAME');
            }
        }
    } else {
        setcookie('selectedUtente', filter_input(INPUT_POST, 'selectedUtente'));
    }
}


