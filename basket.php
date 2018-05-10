<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Fruit</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">

<script language="javascript" type="text/javascript">
	function deleteItem(itemID) {
		var value = "; " + document.cookie;
		var parts = value.split("; basketIDs=");
		var IDs = "";
		if (parts.length == 2) {
			IDs = parts.pop().split(";").shift();
		}
		IDs = IDs.replace((itemID + ","), "");
		document.cookie = "basketIDs=" + IDs;
		"path=/";
		location.reload();
	}

	function payment(total) {
		if (total == 0) {
			alert("Basket is empty");
			return false;
		}
		else {
			document.cookie = "totalCost=" + total;
		}
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

	$itemIDs = $_COOKIE["basketIDs"];
	$itemIDs = explode(',', $itemIDs);
	$total = 0;

	if( $res = $mysqli->query("SELECT * FROM table1") ) {

		print "<table style='table-layout:fixed; border='1'>\n";

		while( $row = $res->fetch_assoc() ) {
			foreach ($itemIDs as $value) {
				if ($row["ID"] == $value) {
					$total += $row["price"];
					$num = $row["price"];
					$formattedNum = number_format($num, 2);
					print "<tr>\n";
					print "<td style='width:150px; height:150px; background-color:white; text-align:center; vertical-align:middle'><img src='" . $row["image"] . "' style='max-height:100%; max-width:100%''></td>\n";
					print "<td style='width:1000px'><h2>".$row["name"]."</h2><hr>";
					print $row["Quantity_desc"]." for £".$formattedNum."</b>";
					print "<input type='submit' value='Remove item' onclick=deleteItem(".$value.")>\n";
					print "</tr>\n";
				}
			}
		}
		print "</table>\n";
		$totalCost = number_format($total, 2);
		print "<h2>Total cost: £".$totalCost;
		print "<br><form action='payment.html' onSubmit='return payment(".$totalCost.")'><input type='submit' value='Payment'/></form>";
	}
?>
</body>
</html>