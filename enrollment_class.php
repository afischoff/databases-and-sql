<?php

if (empty($_GET['class_id']) || !is_numeric($_GET['class_id'])) {
	echo "ID is missing.";
	exit;
}

// load the db
$db = new SQLite3("databases/dbclass_03_enrollment");

// join the person, class and person_class tables to find all classes which a person is registered for
$sql = "select person.first_name, person.last_name, person.id, class.name
from person
inner join person_class on person_class.person_id = person.id
inner join class on class.id = person_class.class_id
where class.id = :id
order by person.last_name, person.first_name";

// prepare the query and bind the user's input into the query
$statement = $db->prepare($sql);
$statement->bindParam(":id", $_GET['class_id']);
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
        <td><a href=\"enrollment_person.php?id={$row['id']}\">{$row['first_name']}</a></td>
        <td><a href=\"enrollment_person.php?id={$row['id']}\">{$row['last_name']}</a></td>
        <td>{$row['name']}</td>
      </tr>";
    }
    ?>
  </table>
</body>
</html>
