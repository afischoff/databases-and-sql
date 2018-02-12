<?php

if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
	echo "ID is missing.";
	exit;
}

// load the db
$db = new SQLite3("databases/dbclass_03_enrollment");

// join the person, class and person_class tables to find all classes which a person is registered for
$sql = "select person.first_name, person.last_name, class.name, class.id
from person
inner join person_class on person_class.person_id = person.id
inner join class on class.id = person_class.class_id
where person.id = :id
order by class.name";

// prepare the query and bind the user's input into the query
$statement = $db->prepare($sql);
$statement->bindParam(":id", $_GET['id']);
$result = $statement->execute();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Enrollment Database Search</title>
</head>
<body>
  <h3>Enrollment Database Search</h3>
  <table>
    <tr>
      <td>First Name</td>
      <td>Last Name</td>
      <td>Class Name</td>
    </tr>
    <?php
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      echo "<tr>
        <td>{$row['first_name']}</td>
        <td>{$row['last_name']}</td>
        <td><a href=\"enrollment_class.php?class_id={$row['id']}\">{$row['name']}</a></td>
      </tr>";
    }
    ?>
  </table>
</body>
</html>
