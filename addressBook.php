<?php
// was the form submitted?
if (!empty($_GET['name'])) {

	// load the db
	$db = new SQLite3("databases/dbclass_02_address_book");

	// make the sql query
	$sql = "select * from person where first_name like :firstName or last_name like :lastName order by last_name limit 30";

	// prepare the query and bind the user's input into the query
	$statement = $db->prepare($sql);
	$name = "%".$_GET['name']."%";
	$statement->bindParam(":firstName", $name);
	$statement->bindParam(":lastName", $name);
	$result = $statement->execute();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Address Book Example</title>
</head>
<body>
<h3>Address Book Example</h3>
<form action="addressBook.php" method="get">
	<p>Complete the form to search the address book</p>
	Name: <input type="text" name="name"> <input type="submit" value="Search">
</form>

<?php if (!empty($result)): ?>
<hr>
<h3>Search Results</h3>
<?php
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
	echo '<a href="person.php?id='.$row['id'].'">'.$row['last_name'].', '.$row['first_name'].'</a><br>';
}
?>
<?php endif; ?>
</body>
</html>