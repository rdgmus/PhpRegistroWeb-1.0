<?php
if (isset($_COOKIE['message'])) {
	echo("<SCRIPT LANGUAGE='JavaScript'>
                            window.confirm('".$_COOKIE['message']."') 
                            </SCRIPT>"); 
}
?>
