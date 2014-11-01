

<meta
    http-equiv="Content-Type" content="text/html; charset=MacRoman">
<title>Insert title here</title>
<link
    rel="stylesheet"
    href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script
src="//code.jquery.com/jquery-1.10.2.js"></script>
<script
src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<!--

//

<link
    rel="stylesheet" href="/resources/demos/style.css">
-->
<!-- ---------------------- -->
<!-- JQUERY COOKYES ENABLED -->
<script
src="jquery/jquery.cookie.js"></script>
<!-- ---------------------- -->

<?php
/**
 * jQuery-Impromptu-master
 */
?>

<link
    href="jquery/jQuery-Impromptu-master/dist/jquery-impromptu.css"
    rel="stylesheet" />
<script
src="jquery/jQuery-Impromptu-master/dist/jquery-impromptu.js"></script>

<?php
/**
 * jQuery-datepicker
 */
?>
<!--
<script
        src="jquery/js/jquery-1.7.1.min.js"></script>
<script
        src="jquery/js/jquery-ui-1.8.18.custom.min.js"></script>

<link href="css/normalize.css"
        rel="stylesheet" type="text/css" />


<link href="css/datepicker.css"
        rel="stylesheet" type="text/css" />
-->

<?php
/**
 * MarkItUp
 * http://markitup.jaysalvat.com/home/
 */
?>
<!-- 
<link rel="stylesheet" type="text/css" href="jquery/markitup/markitup/skins/markitup/style.css" />
<link rel="stylesheet" type="text/css" href="jquery/markitup/markitup/sets/default/style.css" />

<script type="text/javascript" src="jquery/markitup/markitup/jquery.markitup.js"></script>
<script type="text/javascript" src="jquery/markitup/markitup/sets/default/set.js"></script>
-->
<?php
/**
 *
 *
 * @author Roberto Della Grotta
 * @version $1.0$
 * @copyright , 10 October, 2014
 * @package default
 */
/**
 * Select2 3.5.1
 * Select2 is a jQuery based replacement for select boxes.
 * It supports searching, remote data sets, and infinite scrolling of results.
 */
?>
<link
    href="jquery/select2-3.5.1/select2.css" rel="stylesheet" />
<script
src="jquery/select2-3.5.1/select2.js"></script>
<?php
/**
 * jQuery-TE_v.1.4.0
 */
?>
<link
    href="jquery/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet" />
<script
src="jquery/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js"></script>

<link href="css/example.css"
      rel="stylesheet" />


<?php
/**
 * tinymce
 */
?>

<script
src="jquery/tinymce/js/tinymce/tinymce.min.js"></script>

<?php
/**
 * PasswordStrength-master
 */
?>

<link
    href="jquery/PasswordStrength/css/passwordStrength.css"
    rel="stylesheet" />
<script
src="jquery/PasswordStrength/js/passwordStrength.jquery.min.js"></script>

<script
type="application/javascript" src="jquery/jquery.passstrength.min.js"></script>

<!---------------->
<!-- MESSAGEPOP -->
<!---------------->

<!-- <link href="jquery/MsgPop-3.1/css/site.css" rel="stylesheet"> -->
<link
    rel="stylesheet" href="jquery/MsgPop-3.1/css/msgPop.css" />


<!-- <script src="jquery/MsgPop-3.1/js/site.js"></script> -->

<script
    language="javascript" type="text/javascript"
src="jquery/MsgPop-3.1/js/jquery.msgPop.js"></script>

<!-------------------->
<!-- Magnific-Popup -->
<!-------------------->

<!-- Magnific Popup core CSS file -->
<link
    rel="stylesheet" href="jquery/Magnific-Popup/dist/magnific-popup.css">

<!-- Magnific Popup core JS file -->
<script
src="jquery/Magnific-Popup/dist/jquery.magnific-popup.js"></script>


<?php
include 'jquery/jq_ruoli_utente.php';
include 'jquery/jq_index.php';
include 'jquery/jq_dialogs.php';
include 'jquery/jq_emails.php';
?>

<script>
    var pwd, pwd_repeat;

    function passwordCopiata() {
        MsgPop.closeAll();
        $.ajax({
            dataType: "json",
            url: "json/passwordCopiata.json",
            success: function (data) {
                $("#liveDemo").html(data.content);
            }
        });
    }

    function benvenutoUserAjax() {
        MsgPop.closeAll();
        var urData = {Content: 'Moscow'};
        $.ajax({
            url: "json/benvenutoUser.json",
            type: 'POST',
            cache: false,
            data: JSON.stringify(urData),
            dataType: "json",
            responseType: "json",
            success: function (data) {
                //alert('success: '+data.MsgPopQueue[0].Content);

                //$.cookie('firstLogin', false);
                $("#liveDemo").html(data.content);
            },
            error: function (data) {
                alert('fails');
                $("#liveDemo").html(data.content);
            }
        });
    }

    function generaPassword(e) {

        var arg1 = e.data.arg1;
        var arg2 = e.data.arg2;



        $.prompt({
            state0: {
                title: "<h1>Info formato password</h1>",
                html: '<h2>La password deve essere almeno di quattro caratteri e ' +
                        'contenere lettere maiuscole, minuscole e numeri.</h2>' +
                        '<h3>Se vuoi generare una password \'Continua\'',
                buttons: {Esci: false, Continua: true},
                focus: 1,
                submit: function (e, v, m, f) {
                    if (v) {
                        e.preventDefault();
                        $.prompt.goToState('state1');
                    } else {
                        e.preventDefault();
                        $.prompt.close();
                    }
                }
            },
            state1: {
                title: '<h1>Generatore password</h1>',
                html: '<h2>Password:</h2><input type="text" name="password" id="password" size="40">' +
                        '<div id="passwordStrength"></div>' + '<div id="passwordFormatTest"></div>' +
                        '<script language="javascript" type="text/javascript">' +
                        'jQuery(function(){' +
                        'jQuery("#password").passwordStrength({' +
                        '				                targetDiv:"passwordStrength",' +
                        '				                text:{' +
                        '				                    year:"year|years"' +
                        '				                }' +
                        '});' +
                        '});<\/script>' +
                        '<h3><label>Digita la Password oppure \'Genera\'</label></h3>' +
                        '<h2>Size:</h2><INPUT TYPE="NUMBER" MIN="4" MAX="20" STEP="1" VALUE="8" SIZE="6" id="spinner"><br>',
                buttons: {Termina: 0, Genera: 1, Test: 2, Copia: 3},
                focus: 1,
                submit: function (e, v, m, f) {
                    e.preventDefault();
                    if (v == 0) {
                        $.prompt.close();
                    } else if (v == 1) {
                        mydata = "actionLogin=generatePassword" + "&spinner=" + $("#spinner").val();
                        //$.each(f,function(i,obj){
                        //mydata = mydata+"&"+i+"="+obj;
                        //});  	  							
                        $.ajax({
                            type: "POST",
                            url: 'login.php',
                            data: mydata,
                            success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                //alert(response);
                                $("#password").val(response);
                                $("#password").focus(100);
                                $.prompt.goToState('state1');
                            }
                        });
                    } else if (v == 2) {
                        mydata = "actionLogin=testPassword" + "&" + "pwd=" + $("#password").val();
                        $.ajax({
                            type: "POST",
                            url: 'login.php',
                            data: mydata,
                            success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                //alert(response);

                                var html = '';
                                if (response != false) {
                                    html = "<h2>Password is valid!</h2>";
                                }
                                else {
                                    html = "<h2>Invalid Password format!</h2>";
                                }
                                $("#passwordFormatTest").html(html);
                                $.prompt.goToState('state1');
                            }
                        });
                    } else if (v == 3) {
                        //alert(v);
                        mydata = "actionLogin=copiaPassword" + "&" + "pwd=" + $("#password").val();
                        //alert(arg1);
                        //alert(arg2);
                        $("#" + arg1).val(f.password);
                        $("#" + arg1).focus(1000);

                        $("#" + arg2).val(f.password);
                        //benvenutoUserAjax();
                        passwordCopiata();
                        $.prompt.close();
                    }
                }
            }

        });
    }

    function benvenutoUser() {
        MsgPop.closeAll();
<?php
if (isset($_COOKIE['firstLogin'])) {
    if ($_COOKIE['firstLogin'] == 'true') {
        ?>

                MsgPop.open({
                    displaySmall: true,
                    Type: "success",
                    "AutoClose": true,
                    "CloseTimer": 3000,
                    "Icon": "<img  src='images/accept_icon.png'  width='32' height='32'>",
                    Content: "<h1>Benvenuto! " +
                            "<?php
        if (isset($_COOKIE['id_utente'])) {
            $mySqlFunctions = new MySqlFunctionsClass();
            echo $mySqlFunctions->userIsAdministrator($_COOKIE['id_utente']) ? 'Administrator:</h1><h2> ' : 'User:</h1><h2> ';
            echo $_COOKIE['cognome_user'] . " " . $_COOKIE['nome_user'] .
            "(" . $_COOKIE['id_utente'] . ")</h2>";
        }
        ?>"
                });

        <?php
    }
}
?>
    }

    var mydata;


    $(document).ready(function () {
        // Stuff to do as soon as the DOM is ready;
        MsgPop.live(); // Attaches listener to current page.

        $(function () {
            $("#user_email").focus();
            $("#name").focus();
            $("#oldpasswordId").focus();
        });

        $(function () {
            $("#generatedPassword").button();
            $("#passwordNumCharSpinner").spinner({
                min: 4,
                max: 20
            });
            $("#passwordNumCharSpinner").spinner("value", 8);

            $("#actionPasswordCopy").button();
            $("#actionPasswordCopy").click(function () {
                var password = $("#generatedPassword").val();

                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {"page": "changeOthersPassword.php",
                        "action": "copyPassword",
                        "password": password},
                    success: function (response) {//response is value returned from php (for your example it's "bye bye"
                        //alert(response);
                        $("#repeatPassword").val(response);
                        $("#newPassword").val(response);
                    }
                });
            });


            $("#actionPasswordGenerate").button();
            $("#actionPasswordGenerate").click(function () {
                var numChars = $("#passwordNumCharSpinner").val();

                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {"page": "changeOthersPassword.php",
                        "action": "generatePassword",
                        "numChars": numChars},
                    success: function (response) {//response is value returned from php (for your example it's "bye bye"
                        //alert(response);
                        $("#generatedPassword").val(response);
                    }
                });
            });
        });


        $(function () {
            $("#actionChangePasswordId").button();

            //DEFAULT BUTTON
            $('#changePasswordForm').keypress(function (event) {
                if (event.keyCode == 13) {
                    //alert('changePasswordForm');
                    $('#actionChangePasswordId').click();
                }
            });

            $("#actionChangePasswordId").click(function ()
            {
                //alert('actionChangePasswordId');
                //var selectedRecipient = $.cookye('id_utente');
                var oldpassword = $('input[name=oldpassword]').val();
                var password = $('input[name=password]').val();
                var password_one = $('input[name=password_one]').val();
                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {"page": "changePassword.php",
                        "action": "changePassword",
                        "oldpassword": oldpassword,
                        "password": password,
                        "password_one": password_one},
                    success: function (response) {//response is value returned from php (for your example it's "bye bye"
                        //alert(response);
                        location.reload();
//                        window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/changePassword.php";
                    }
                });
            });

            $("#actionChangeOthersPasswordId").button();

            //DEFAULT BUTTON
            $('#changeOthersPasswordForm').keypress(function (event) {
                if (event.keyCode == 13) {
                    $('#actionChangeOthersPasswordId').click();
                }
            });

            $("#actionChangeOthersPasswordId").click(function ()
            {
                var countRowPending = $('input[name=countRowPending]').val();
                //alert(countRowPending);
                if (countRowPending == 0) {
                    alert('NESSUNA RICHIESTA PENDENTE PER LE PASSWORD!');
                    blink(5000, 1000, '#actionChangeOthersPasswordId');
                    return false;
                }
                var selectedRecipient = $('select[name=selectedRecipient]').val();
                var oldpassword = $('input[name=oldpassword]').val();
                var password = $('input[name=password]').val();
                var password_one = $('input[name=password_one]').val();

                $("#actionChangeOthersPasswordId").button("disable");
                $.removeCookie('status');
                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    data: {"page": "changeOthersPassword.php",
                        "action": "changeOthersPassword",
                        "selectedRecipient": selectedRecipient,
                        "oldpassword": oldpassword,
                        "password": password,
                        "password_one": password_one,
                        "countRowPending": countRowPending},
                    success: function (response) {//response is value returned from php (for your example it's "bye bye"
                        //alert(response);
                        $("#actionChangeOthersPasswordId").button("enable");
                        window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/changeOthersPassword.php";
                    }
                });
            });
        });


        function blink(time, interval, selector) {
            var timer = window.setInterval(function () {
                $(selector).css("opacity", "0.1");
                window.setTimeout(function () {
                    $(selector).css("opacity", "1");
                }, 100);
            }, interval);
            window.setTimeout(function () {
                clearInterval(timer);
            }, time);
        }

        function blinkContinuous(time, interval) {
            window.setInterval("$('#actionChangeOthersPasswordId').toggle();", 2000);
        }

        $(function () {

            $("#datepicker").datepicker({
                inline: true,
                showOtherMonths: false,
                dateFormat: 'dd MM yy',
                selectOtherMonths: false,
                dayNames: ["Domenica", "Luned", "Marted", "Mercoled", "Gioved", "Venerd", "Sabato"],
                dayNamesMin: ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab"],
                firstDay: 1,
                minDate: "now",
                maxDate: "now",
                monthNames: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
                monthNamesShort: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"]
            });
            $("#datepicker").change(function ()
            {
                //alert('datepicker');
                $("#datepicker").datepicker("setDate", "now");
            });
        });

        $(function () {
            $("#backToUserMenu").button();
        });
        $(function () {
            $("#backToUserMenu").click(function ()
            { //alert('firstLogin');



                page = $(location).attr('pathname');
                if (page.indexOf("emailToUser.php") >= 0) {
                    //alert(page.indexOf("emailToUser.php"));
                    $.prompt("<h3>Vuoi mantenere l'Email o cancellarla?</h3>", {
                        title: "<h2>Uscita da PhpMailer</h2>",
                        buttons: {"Cancella Email": true, "Salva Email": false},
                        submit: function (e, v, m, f) {
                            // use e.preventDefault() to prevent closing when needed or return false. 
                            //e.preventDefault(); 

                            //alert("Value clicked was: "+ v);

                            mydata = $("form#mailUserForm").serialize();
                            mydata = mydata + "&page=" + "userMenu.php" + "&action=" + "backToUserMenu" +
                                    "&cancellaEmail=" + v;
                            //alert(mydata);
                            $.ajax({
                                type: "POST",
                                url: 'ajax.php',
                                data: mydata,
                                success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                    //alert(response);
                                    //if(e.isDefaultPrevented()){
                                    //alert('event.isDefaultPrevented');
                                    //}
                                    window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/userMenu.php";

                                }
                            });
                        }
                    });

                } else {//per le altre pagine dalle quali viene richiamata questra funzione backToUserMenu 
                    mydata = $("form#mailUserForm").serialize();
                    mydata = mydata + "&page=" + "userMenu.php" + "&action=" + "backToUserMenu";
                    //alert(mydata);
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            /**
                             * Disabilita la cookye per impedire la ricomparsa dei popup relativi
                             * al messaggio di benvenuto
                             */
                            //$.cookie('firstLogin', 'false');
                            window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/userMenu.php";
                        }
                    });
                }
            }
            );
        });

        $(function () {
            $(document).tooltip({
                position: {my: "left+15 center", at: "right center"},
                open: function (e, ui) {
                    var el = e.originalEvent.target;
                    if (el.offsetWidth === el.scrollWidth) {
                        ui.tooltip.hide();
                    }
                },
                show: {
                    effect: "bounce",
                    delay: 1000
                },
                hide: {
                    effect: "puff",
                    delay: 150
                },
                tooltipClass: "customTooltip",
                track: true,
                click: function (e) {
                    setTimeout(function () {
                        $(e.target).tooltip('close');
                    }, 1000);
                }
            });
        });



        $(function () {//GESTIONE DEGLI UTENTI: RUOLI, EMAIL, PASSWORD



            $(function () {

                $("#selectUserEmailId").select2();
            });

            $(function () {
                $("#emailButton").button();

            });
            $(function () {
                $("#emailButton").click(function ()
                {

                    mydata = $("form#userMenuForm").serialize();
                    mydata = mydata + "&page=" + "userMenu.php" + "&action=" + "createEmail";
                    //alert(mydata);
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: mydata,
                        success: function (response) {
                            alert(response);
                            window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/emailToUser.php";
                        }
                    });

                }
                );
            });

            $(function () {
                $("#changePassword").button();

            });
            $(function () {
                $("#changePassword").mouseover(function ()
                {
                    //alert('mouseover');
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: {"action": "testUserHasToChangePassword",
                            "page": "userMenu.php"},
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            //window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/changePassword.php";	
                            if (response == 1) {
                                //alert('TRUE'); 
                                blink(5000, 1000, '#changePassword');
                                message_content = 'Al primo accesso con le nuove credenziali, devi cambiare <br>' +
                                        "la password del tuo account per ragioni di sicurezza. <br>" +
                                        "Cordiali Saluti <br><h2> Admin - PhpRegistroScuolaNetBeans </h2>";
                                $.prompt("Vuoi andare alla pagina per cambiare la tua password? " + message_content, {
                                    title: "<h1>Richiesta di cambio Password!</h1>",
                                    buttons: {"Yes, I'm Ready": true, "No, Lets Wait": false},
                                    submit: function (e, v, m, f) {
                                        // use e.preventDefault() to prevent closing when needed or return false. 
                                        //e.preventDefault(); 
                                        if (v) {
                                            window.location = "./changePassword.php";

                                        } else {

                                            window.location = "./userMenu.php";

                                        }

                                    }
                                });
                            } else {
                                //alert('FALSE');   	   

                            }
                        }
                    });
                });

                $("#changePassword").click(function ()
                {

                    mydata = $("form#userMenuForm").serialize();
                    mydata = mydata + "&page=" + "userMenu.php";
                    //alert(mydata);
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/changePassword.php";
                        }
                    });

                }
                );
            });


            $(function () {
                $("#logoutButton").button();
            });
            $(function () {
                $("#logoutButton").click(function ()
                {

                    page = $(location).attr('pathname');
                    //alert(page);
                    if (page.indexOf("userMenu.php") >= 0) {

                        $.prompt("<h3>Vuoi uscire da PhpRegistroScuolaNetBeans?</h3>", {
                            title: "<h2>Uscita da PhpRegistroScuolaNetBeans</h2>",
                            buttons: {"Esci": true, "Rimani": false},
                            submit: function (e, v, m, f) {
                                // use e.preventDefault() to prevent closing when needed or return false. 
                                //e.preventDefault(); 
                                if (v) {

                                    mydata = $("form#userMenuForm").serialize();
                                    mydata = mydata + "&page=" + "userMenu.php" + "&action=" + "logout";
                                    //alert(mydata);
                                    $.ajax({
                                        type: "POST",
                                        url: 'ajax.php',
                                        data: mydata,
                                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                            //alert(response);

                                            removeAllCookyes();
                                            window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/index.php";
                                        }
                                    });
                                }
                            }
                        });
                    }
                });
            });

            function removeAllCookyes() {
                //REMOVE COOKYES
                var cookies = $.cookie();
                for (var cookie in cookies) {
                    $.removeCookie(cookie);
                }
            }



            $(function () {
                $("#gotoNewUserPage").button();
            });
            $(function () {
                $("#gotoNewUserPage").click(function ()
                {
                    mydata = $("form#userAuthenticationForm").serialize();
                    mydata = mydata + "&page=" + "userRegistration.php";
                    //alert("gotoNewUserPage:"+mydata);
                    removeNewUserCookyes();
                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/userRegistration.php";
                        }
                    });
                });
            });

            $(function () {
                $("#selectedRecipientId1").select2();
                /**
                 *	BOTTONE SELEZIONA USER PER changeOthersPassword.php
                 */
                $("#selectedRecipientId1").click(function ()
                {

                    var selectedRecipient = $('select[name=selectedRecipient]').val();
                    //alert('selectedRecipient'+selectedRecipient);

                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: {"selectedRecipient": selectedRecipient,
                            "page": "changeOthersPassword.php",
                            "action": "selectRecipient"},
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            $("#oldpasswordId").val(response);
                        }
                    });

                }
                );
            });
            $(function () {
                $("#selectedRecipientId2").select2();
                /**
                 *	BOTTONE SELEZIONA USER PER emailToUser.php
                 */
                $(function () {
                    $("#selectedRecipientId2").click(function ()
                    {

                        var selectedRecipient = $('select[name=selectedRecipient]').val();
                        //alert('selectedRecipient'+selectedRecipient);

                        $.ajax({
                            type: "POST",
                            url: 'ajax.php',
                            data: {"selectedRecipient": selectedRecipient,
                                "page": "emailToUser.php",
                                "action": "selectRecipient"},
                            success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                //alert(response);
                                //window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/emailToUser.php";
                            }
                        });

                    }
                    );
                });
            });

            $(function () {

                $("#MySqlServer").select2();
                $("#MySqlServer").click(function () {
                    //alert("Selected value is: "+$("#MySqlServer").select2("val"));
                    mydata = $("form#indexForm").serialize();
                    mydata = mydata + "&page=" + "index.php";
                    //alert(mydata);

                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            //window.location = "http://"+response+"/PhpRegistroScuolaNetBeans/index.php";
                        }
                    });
                });
            });

            $(function () {
                $("#startNewUserPage").button();
            });
            $(function () {
                $("#startNewUserPage").click(function ()
                {
                    mydata = $("form#indexForm").serialize();
                    mydata = mydata + "&page=" + "index.php";
                    //alert(mydata);

                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/userRegistration.php";
                        }
                    });
                });
            });

            $(function () {
                $("#startLoginPage").button();
            });
            $(function () {
                $("#startLoginPage").click(function ()
                {
                    mydata = $("form#indexForm").serialize();
                    mydata = mydata + "&page=" + "index.php";
                    //alert(mydata);

                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/userAuthentication.php";
                        }
                    });
                });
            });

            $(function () {
                $("#gotoLoginPage").button();
            });
            $(function () {
                $("#gotoLoginPage").click(function ()
                {
                    mydata = $("form#userRegistrationForm").serialize();
                    mydata = mydata + "&page=" + "userRegistration.php";
                    //alert(mydata);

                    $.ajax({
                        type: "POST",
                        url: 'ajax.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            window.location = "http://" + response + "/PhpRegistroScuolaNetBeans/userAuthentication.php";
                        }
                    });
                });
            });



            $(function () {

                $("#lanciaConfermaRichiesta").button({focus: true});
                $("#lanciaConfermaRichiesta").click(function ()
                {
                    var cognome = $('input[name=cognome]').val();
                    var nome = $('input[name=nome]').val();
                    var email = $('input[name=email]').val();
                    var hash = $('input[name=hash]').val();
                    var id_request = $('input[name=id_request]').val();

                    //alert('lanciaConfermaRichiesta:'+cognome+nome+email+hash+id_request);
                    var statesLanciaConfermaRichiesta = {
                        state0: {
                            html: '<h2>Benvenuto! <hr>' + cognome + ' ' + nome + ' [' + email + ']<hr></h2>' +
                                    '<h3>Se sei arrivata/o a questo link, hai inoltrato una\n\
                                    richiesta di cambiamento password e hai ricevuto una\n\
                                    email dal nostro sistema.\n\
                                    Se vuoi confermare la tua richiesta' +
                                    ' all\'amministratore per la riattivazione clicca \'Prosegui\'\n\
                                    Se clicchi \'Esci\', la presente richiesta verr&agrave; cancellata!</h3>',
                            buttons: {Esci: false, Prosegui: true},
                            focus: 1,
                            submit: function (e, v, m, f) {
                                //alert(v);
                                if (v) {
                                    //ESEGUE LA CONFERMA SUL DATABASE
                                    e.preventDefault();
                                    $.ajax({
                                        type: "POST",
                                        url: 'ajax.php',
                                        data: {"actionRequest": "confirmChangePassword",
                                            "hash": hash,
                                            "id_request": id_request},
                                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                            //alert(response);
                                            if (response) {
                                                $.prompt.goToState('state1');
                                            }
                                            else {
                                                e.preventDefault();
                                                $.prompt.goToState('state2');
                                            }
                                        }
                                    });

                                } else {
                                    e.preventDefault();
                                    $.prompt.goToState('state3');
                                }
                            }
                        },
                        state1: {
                            html: '<img  src="images/accept_icon.png"  width="32" height="32"><h2>La nuova password le verr&agrave; inviata per email a:</h2> <hr>' +
                                    '<h2>' + cognome + ' ' + nome + ' <br>[' + email + ']</h2><hr>' +
                                    '<h3>Cordiali saluti!</h3>' +
                                    ' <h2>Admin - PhpRegistroWeb 1.0</h2>',
                            buttons: {Esci: false},
                            focus: 0,
                            submit: function (e, v, m, f) {
                                $.prompt.close();

                                window.location = "./confirmRequestByUserPage.php";
                            }
                        },
                        state2: {
                            html: '<img  src="images/dialog_close_icon.png"  width="32" height="32"><h2>Non &egrave; stato possibile confermare</h2> <hr>' +
                                    '<h2>riprovi pi&ugrave; tardi</h2><hr>' +
                                    '<h3>Cordiali saluti!</h3>' +
                                    ' <h2>Admin - PhpRegistroWeb 1.0</h2>',
                            buttons: {Esci: false},
                            focus: 0,
                            submit: function (e, v, m, f) {
                                $.prompt.close();
                            }
                        },
                        state3: {
                            html: '<img  src="images/dialog_close_icon.png"  width="32" height="32"><h2>La richiesta sta per essere\n\
                                    cancellata!</h2><hr>' +
                                    '<h3>Cordiali saluti!</h3>' +
                                    ' <h2>Admin - PhpRegistroWeb 1.0</h2>',
                            buttons: {"Prosegui": false, "Annulla": true},
                            focus: 0,
                            submit: function (e, v, m, f) {
                                if (v) {
                                    $.prompt.close();
                                } else {
                                    e.preventDefault();
                                    $.ajax({
                                        type: "POST",
                                        url: 'ajax.php',
                                        data: {"actionRequest": "confirmCancelRequest",
                                            "hash": hash,
                                            "id_request": id_request},
                                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                            //alert(response);
                                            $.prompt.close();
                                            location.reload();
                                        }
                                    });
                                }
                            }
                        }

                    };
                    $.prompt(statesLanciaConfermaRichiesta);

                });

                $("#requestPasswordChange").button();
                $("#requestPasswordChange").click(function ()
                {
                    var statesRequestPasswordChange = {
                        state0: {
                            title: '<h1>Hai dimenticato la password?</h1>',
                            html: 'Se vuoi inoltrare una richiesta' +
                                    ' all\'amministratore per la riattivazione prosegui...',
                            buttons: {Esci: false, Continua: true},
                            focus: 1,
                            submit: function (e, v, m, f) {
                                if (v) {
                                    e.preventDefault();
                                    $.prompt.goToState('state1');
                                    return false;
                                }
                                $.prompt.close();
                            }
                        },
                        state1: {
                            title: '<h1>Le tue credenziali</h1>',
                            html: '<h3>Cognome:</h3><input type="text" name="cognome" id="cognome">' +
                                    '<h3>Nome:</h3><input type="text" name="nome" id="nome">' +
                                    '<h3>Email:</h3><input type="text" name="email" id="email"><br>',
                            buttons: {Esci: 0, "Invia": 1},
                            focus: 1,
                            submit: function (e, v, m, f) {
                                e.preventDefault();

                                if (v == 0)
                                    $.prompt.close();
                                else if (v == 1) {
//                                    $.prompt.goToState('state4');
                                    mydata = "actionLogin=sendRequestChangePassword";
                                    $.each(f, function (i, obj) {
                                        mydata = mydata + "&" + i + "=" + obj;
//                                        alert(mydata);
                                    });
                                    //ELABORA LA RICHIESTA DI CAMBIO PASSWORD CON ajax???
                                    //alert(mydata);

                                    $.ajax({
                                        type: "POST",
                                        url: 'login.php',
                                        data: mydata,
                                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                                            //alert(response);
                                            if (response == 1) {
                                                //e.preventDefault();
                                                $.prompt.goToState('state2');//RICHIESTA INOLTRATA
                                            }else if (response == 0) {
                                                e.preventDefault();
                                                $.prompt.goToState('state3');//RICHIESTA FALLITA
                                            }else if (response == 2) {
                                                e.preventDefault();
                                                $.prompt.goToState('state4');//RICHIESTA ESISTENTE
                                            }
                                        }
                                    });//FINE
                                }
                            }
                        },
                        state2: {
                            html: '<img  src="images/accept_icon.png"  width="32" height="32"><h1>Richiesta inoltrata!</h1><h2>Riceverai una email per l\'attivazione della nuova password, da parte del sistema' +
                                    ' del </h2><h1>PhpRegistroWeb 1.0</h1>',
                            buttons: {Fine: true},
                            focus: 0,
                            submit: function (e, v, m, f) {
                                $.prompt.close();
                            }
                        },
                        state3: {
                            html: '<img  src="images/dialog_close_icon.png"  width="32" height="32"><h1>Richiesta fallita!</h1><h2>Le credenziali fornite non corrispondono a nessun utente registrato.</h2>',
                            buttons: {Riprova: false, Fine: true},
                            focus: 1,
                            submit: function (e, v, m, f) {
                                if (v) {

                                    $.prompt.close();
                                }
                                else {

                                    e.preventDefault();
                                    $.prompt.goToState('state1');
                                }
                            }
                        },
                        state4: {
                            html: '<img  src="images/dialog_close_icon.png"  width="32" height="32"><h1>Richiesta gi&agrave; inoltrata!</h1>' +
                                    ' <h2>PhpRegistroWeb 1.0</h2>',                          
                            submit: function (e, v, m, f) {
                                 e.preventDefault();
                                    $.prompt.goToState('state1');
                            }
                        }
                    };
                    $.prompt(statesRequestPasswordChange);

                });

                $("#loginButton").button();

                //DEFAULT BUTTON
                $('#userAuthenticationForm').keypress(function (event) {
                    if (event.keyCode == 13) {
                        //$('#loginButton').click();
                    }
                });
                $("#loginButton").click(function ()
                {
                    mydata = $("form#userAuthenticationForm").serialize();
                    mydata = mydata + "&actionLogin=" + "Login";
                    //alert(mydata);

                    //REMOVE COOKYES

                    $.removeCookie('user_emailErr');
                    $.removeCookie('passwordErr');
                    $.removeCookie('repeatpasswordErr');

                    $.ajax({
                        type: "POST",
                        url: 'login.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);

                            window.location = response;

                        }
                    });
                });
            });


            $(function () {

                $(function () {
                    //$('#passwordAuthenticate').passStrengthify();
                    //$('#passwordRegistrate').passStrengthify();
                    $("#passwordInfo").button();

                    $("#passwordInfo").on('click', {arg1: pwd, arg2: pwd_repeat}, generaPassword);

                });


            });





            $(function () {//register button
                $(function () {
                    $("#registerButton").button();
                });

                //DEFAULT BUTTON
                $('#userRegistrationForm').keypress(function (event) {
                    if (event.keyCode == 13) {
                        //$('#registerButton').click();
                    }
                });
                $("#registerButton").click(function ()
                {
                    mydata = $("form#userRegistrationForm").serialize();
                    mydata = mydata + "&actionRegister=" + "Register";
                    //alert(mydata);

                    removeNewUserCookyes();

                    $.ajax({
                        type: "POST",
                        url: 'register.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            window.location = response;
                        }
                    });
                });
            });

            function removeNewUserCookyes() {
                //REMOVE COOKYES
                $.removeCookie('nameErr');
                $.removeCookie('surnameErr');
                $.removeCookie('user_emailErr');
                $.removeCookie('passwordErr');
                $.removeCookie('repeatpasswordErr');

                $.removeCookie('newUserName');
                $.removeCookie('newUserSurname');
                $.removeCookie('newUserEmail');
                $.removeCookie('newUserPassword');
                $.removeCookie('newUserRepeatPassword');
            }

            $(function () {
                $("#clearNewUserFields").button();
            });
            $(function () {
                $("#clearNewUserFields").click(function ()
                {
                    mydata = $("form#userRegistrationForm").serialize();
                    mydata = mydata + "&actionRegister=" + "clearNewUserFields";
                    //alert(mydata);

                    removeNewUserCookyes();

                    $.ajax({
                        type: "POST",
                        url: 'register.php',
                        data: mydata,
                        success: function (response) {//response is value returned from php (for your example it's "bye bye"
                            //alert(response);
                            window.location = response;
                        }
                    });
                });
            });
        });
    });


</script>
