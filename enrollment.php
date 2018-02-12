<?php
// was the form submitted?
if (!empty($_GET['name'])) {

	// load the db
	$db = new SQLite3("databases/dbclass_03_enrollment");

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
	<title>Enrollment Example</title>
</head>
<body>
<h3>Enrollment Example</h3>
<form action="enrollment.php" method="get">
	<p>Complete the form to search the enrollment database</p>
	Name: <input type="text" name="name"> <input type="submit" value="Search">
</form>

<?php if (!empty($result)): ?>
<hr>
<h3>Search Results</h3>
<?php
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
	echo '<a href="enrollment_person.php?id='.$row['id'].'">'.$row['last_name'].', '.$row['first_name'].'</a><br>';
}
?>
<?php endif; ?>
</body>
</html>
