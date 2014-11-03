
<html>
    <script type="text/javascript">

        /**
         * NELLA PAGINA index.php VENGONO SELEZIONATE DELLE OPZIONI:
         * LOGIN, REGISTRAZIONE NUOVO UTENTE
         * @author Roberto Della Grotta
         * @version $Id$
         * @copyright , 15 October, 2014
         * @package default
         */

        /**
         * Define DocBlock
         */

        $(document).ready(function () {
            // Stuff to do as soon as the DOM is ready;


            /**
             *	BOTTONE VAI A REGISTRAZIONE NUOVO UTENTE
             */
            $(function () {
                $("#newUserPage").click(function ()
                {

                    var mydata = $("form#indexForm").serialize();
                    mydata = mydata + "&page=" + "index.php";
                    //alert(mydata);

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

                }
                );
            });

            /**
             *	BOTTONE VAI A LOGIN
             */
            $(function () {
                $("#loginPage").click(function ()
                {

                    var mydata = $("form#indexForm").serialize();
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

                }
                );
            });
        });
    </script>

</html>