<html>
<body>
<h1>
<?php
// we connect to MySql on socket or on local server instance 
$socket = ':/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';
$socket_user = "root";
$socket_passwd = "myzconun";

$server = '127.0.0.1';
$server_user = "root";
$server_passwd = "iw3072ylA";

$link = mysql_connect($socket, $socket_user, $socket_passwd);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo "Connected successfully to ".$socket ;

//LISTA DEI DATABASE
$db_list = mysql_list_dbs($link);
?>
</h1>
<h2>
	<a href="index.php">Home</a>
</h2>

<?php 
while ($database = mysql_fetch_object($db_list)) {?>
<?php 
     //if($database->Database == 'mysql'){

     	$tables_list = mysql_list_tables($database->Database,$link);
     	while($table = mysql_fetch_object($tables_list)){?>
     		<h2>
			Schema:<?php      echo $database->Database."\n"; ?>  
			</h2>
     			<h3>
     			Table:
     			<?php 
	     			
			     	$class_vars = get_object_vars($table);
	
					foreach ($class_vars as $name => $value) {
					    echo "$value\n";
     			?>
     			</h3>
     			<?php 
				    $columns = mysql_list_fields($database->Database, $table->$name,$link);
       			?>
     			<h4>
     			Columns:</h4>
     			<?php 
     			while($column=mysql_fetch_field($columns)){?>
     			<ul>
     			<li>
     			<?php 	print_r($column->name."(".$column->type.")");?>
     			</ul>
     			<?php 
     			}
     	}
    }  
}
?>
<h1>
<?php if(mysql_close($link)){
			echo "Successfully disconnected!"."\n" ;
}?>
</h1>

</body>
</html>