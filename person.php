<?php

if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
	echo "ID is missing.";
	exit;
}

// load the db
$db = new SQLite3("databases/dbclass_02_address_book");

// make the person table sql query
$sql = "select * from person where id = :id";

// prepare the query and bind the user's input into the query
$statement = $db->prepare($sql);
$statement->bindParam(":id", $_GET['id']);
$result = $statement->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Address Book Record: <?=$row['first_name'].' '.$row['last_name']?></title>
</head>
<body>
<h3><?=$row['first_name'].' '.$row['last_name']?></h3>
<table>
	<tr>
		<th>First Name</th>
		<td><?=$row['first_name']?></td>
	</tr>
	<tr>
		<th>Last Name</th>
		<td><?=$row['last_name']?></td>
	</tr>
	<tr>
		<th>Company</th>
		<td><?=$row['company']?></td>
	</tr>
	<tr>
		<th>Job Title</th>
		<td><?=$row['job_title']?></td>
	</tr>
	<tr>
		<th>Birthday</th>
		<td><?=date("F d, Y", strtotime($row['birthday']))?></td>
	</tr>
	<tr>
		<th>Created</th>
		<td><?=date("m/d/Y g:i a", strtotime($row['created_at']))?></td>
	</tr>
</table>

<hr>
<h3>Addresses</h3>
<?php
// make the address table sql query
$sql = "select * from address where person_id = :id";

// prepare the query and bind the user's input into the query
$statement = $db->prepare($sql);
$statement->bindParam(":id", $_GET['id']);
$result = $statement->execute();
?>
<table>
	<tr>
        <th>Type</th>
		<th>Street</th>
        <th>City</th>
        <th>State</th>
        <th>Zip</th>
        <th>Created</th>
	</tr>
    <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo "<tr>
                <td>{$row['type']}</td>
                <td>{$row['street']}</td>
                <td>{$row['city']}</td>
                <td>{$row['state']}</td>
                <td>{$row['zip']}</td>
                <td>".date("m/d/Y g:i a", strtotime($row['created_at']))."</td>
            </tr>";
    } ?>
</table>

<hr>
<h3>Emails</h3>
<?php
// make the address table sql query
$sql = "select * from email where person_id = :id";

// prepare the query and bind the user's input into the query
$statement = $db->prepare($sql);
$statement->bindParam(":id", $_GET['id']);
$result = $statement->execute();
?>
<table>
    <tr>
        <th>Type</th>
        <th>Email</th>
        <th>Created</th>
    </tr>
	<?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		echo "<tr>
                <td>{$row['type']}</td>
                <td><a href='mailto:{$row['email']}'>{$row['email']}</a></td>
                <td>".date("m/d/Y g:i a", strtotime($row['created_at']))."</td>
            </tr>";
	} ?>
</table>

<hr>
<h3>Phones</h3>
<?php
// make the address table sql query
$sql = "select * from phone where person_id = :id";

// prepare the query and bind the user's input into the query
$statement = $db->prepare($sql);
$statement->bindParam(":id", $_GET['id']);
$result = $statement->execute();
?>
<table>
    <tr>
        <th>Type</th>
        <th>Phone</th>
        <th>Created</th>
    </tr>
	<?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		echo "<tr>
                <td>{$row['type']}</td>
                <td>{$row['phone']}</td>
                <td>".date("m/d/Y g:i a", strtotime($row['created_at']))."</td>
            </tr>";
	} ?>
</table>

<hr>
<h3>Social Media</h3>
<?php
// make the address table sql query
$sql = "select * from social where person_id = :id";

// prepare the query and bind the user's input into the query
$statement = $db->prepare($sql);
$statement->bindParam(":id", $_GET['id']);
$result = $statement->execute();
?>
<table>
    <tr>
        <th>Type</th>
        <th>Username</th>
				<th>Url</th>
        <th>Created</th>
    </tr>
	<?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
		echo "<tr>
                <td>{$row['type']}</td>
                <td>{$row['username']}</td>
								<td><a href=\"{$row['url']}\">{$row['url']}</a></td>
                <td>".date("m/d/Y g:i a", strtotime($row['created_at']))."</td>
            </tr>";
	} ?>
</table>

</body>
</html>
