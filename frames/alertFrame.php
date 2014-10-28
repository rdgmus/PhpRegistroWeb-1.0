<?php
if (isset($_COOKIE['message'])) {
	echo("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('".$_COOKIE['message']."') 
                            </SCRIPT>"); 
}
?>
