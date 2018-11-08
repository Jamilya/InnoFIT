<html>
    <head>
        <title> Login </title>
</head>
<body>
    <?php
        echo "<p>Please enter your login credentials</p>";
    ?>
    <a href="login.php"> Login</a>
    <a href="register.php">Register </a>

    <?php
				mysql_connect("localhost", "root","") or die(mysql_error()); //Connect to server
				mysql_select_db("first_db") or die("Cannot connect to database"); //connect to database
				$query = mysql_query("Select * from list Where public='yes'"); // SQL Query
				while($row = mysql_fetch_array($query))
				{
					Print "<tr>";
						Print '<td align="center">'. $row['id'] . "</td>";
						Print '<td align="center">'. $row['details'] . "</td>";
						Print '<td align="center">'. $row['date_posted']. " - ". $row['time_posted']."</td>";
						Print '<td align="center">'. $row['date_edited']. " - ". $row['time_edited']. "</td>";
					Print "</tr>";
				}
			?>
</body>
</html>