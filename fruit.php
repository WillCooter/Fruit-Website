<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Fruit</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">

<script language="javascript" type="text/javascript">
	function addToBasket(itemID) {
		var value = "; " + document.cookie;
		var parts = value.split("; basketIDs=");
		var IDs = "";
		if (parts.length == 2) {
			IDs = parts.pop().split(";").shift();
		}
		document.cookie = "basketIDs=" + (IDs + itemID + ",");
		"path=/";
		alert("Item added to basket");
	}

	function linkID(itemID) {
		document.cookie = "ID=" + itemID;
		"path=/";
	}
</script>

</head>

<body style="background-color: powderblue;">
<h1>FreshFruits.com</h1>
<ul>
	<li><a href="fruit.php">Home</a></li>
	<li><a href="basket.php">Basket</a></li>
</ul>
</nav>
<?php

	$url = "csmysql.cs.cf.ac.uk";
	$user = "c1535277";
	$pass = "bartitsu97";
	$db = "c1535277";
	$mysqli = new mysqli($url,$user,$pass,$db);

	if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}

	$orderBy = array("Peel", "price", "ID");
	$order = "ID";
	if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
    	$order = $_GET['orderBy'];
	}

	if( $res = $mysqli->query("SELECT * FROM table1 ORDER BY ".$order) ) {

		print "<h2>Sort by:</h2>";
		print "<form action='?orderBy=Peel' method='post'><input type='submit' value='Peelable'/></form>";
		print "<form action='?orderBy=price' method='post'><input type='submit' value='Price'/></form>";
		print "<table style='table-layout:fixed; border='1'>\n";

		while( $row = $res->fetch_assoc() ) {
			$num = $row["price"];
			$formattedNum = number_format($num, 2);
			print "<tr>\n";
			print "<td style='width:250px; height:250px; background-color:white; text-align:center; vertical-align:middle'><img src='" . $row["image"] . "' style='max-height:100%; max-width:100%''></td>\n";
			print "<td><h2><a href=itemPage.php onclick=linkID(".$row["ID"].")>".$row["name"]."</a></h2><hr><b>".$row["Quantity_value"];
			if (strpos($row["Quantity_unit"], 'g') !== false) {
				print "g";
			}
			print " for £".$formattedNum."</b>\n";
			print "<input type='submit' value='Add to basket' onclick=addToBasket(".$row["ID"].")>\n";
			print "</tr>\n";
			}
		print "</table>\n";
	}
?>
<br>
<br>
</body>
</html>