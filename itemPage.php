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

	$item_ID = $_COOKIE["ID"];

	if( $res = $mysqli->query("SELECT * FROM table1") ) {

		print "<table style='table-layout:fixed; border='1'>\n";

		while( $row = $res->fetch_assoc() ) {
			if ($row["ID"] == $item_ID) {
				$num = $row["price"];
				$formattedNum = number_format($num, 2);
				print "<tr>\n";
				print "<td style='width:400px; height:400px; background-color:white; text-align:center; vertical-align:middle'><img src='" . $row["image"] . "' style='max-height:100%; max-width:100%''></td>\n";
				print "<td style='width:1000px'><h2>".$row["name"]."</h2><hr>".$row["description"];
				print "<br>Colour: "."<font color=".$row["Colour"]."><b>".$row["Colour"]."</b></font>";
				print "<br>Peel: ";
				if ($row["Peel"] == "0") {
					print "No";
				}
				else {
					print "Yes";
				}
				print "<br>Flavor: ";
				if ($row["Sweet/sour"] == "0") {
					print "<font color=3E8F13><b>Bitter</b></font>";
				}
				else if ($row["Sweet/sour"] == "1") {
					print "<font color=629C12><b>Sharp</b></font>";
				}
				else if ($row["Sweet/sour"] == "2") {
					print "<font color=8B9C3A><b>Sour</b></font>";
				}
				else if ($row["Sweet/sour"] == "3") {
					print "<font color=A39C05><b>Fruity</b></font>";
				}
				else if ($row["Sweet/sour"] == "4") {
					print "<font color=A36B1E><b>Sweet</b></font>";
				}
				else {
					print "<font color=A94325/><b>Sugary</b></font>";
				}

				print "<hr>".$row["Quantity_desc"]." for £".$formattedNum."</b><br>";
				print "<input type='submit' value='Add to basket' onclick=addToBasket(".$item_ID.")>\n";
				print "</tr>\n";
			}
		}
		print "</table>\n";
	}
?>
<br>
<br>
</body>
</html>