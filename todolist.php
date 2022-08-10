<?php 
    // initialize errors variable
	$errors = "";

	// connect to database
	$db = mysqli_connect("localhost", "root", "", "todo");

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task']) or empty($_POST['task'])) {
			$errors = "You must fill in the task and status";
		}else{
			$task = $_POST['task'];
			$st = $_POST['sts'];
			$sql = "INSERT INTO task (task,st) VALUES ('$task','$st')";

			
			mysqli_query($db, $sql);
			header('location: todolist.php');
		}
	}
	
	// delete task
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($db, "DELETE FROM task WHERE id=".$id);
		header('location: todolist.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>todo-list</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">ToDo List</h2>
	</div>
	<form method="post" action="todolist.php" class="input_form">
	<?php if (isset($errors)) { ?>
		<p><?php echo $errors; ?></p>
	<?php } ?>

		<label for="status">Task:</label>
		<input type="text" name="task" class="task_input">
		</br>
	    </br>
		<label for="status">Status:</label>
		<select  name="sts" >
		<option value="NEW">NEW</option>
		<option value="IN PROGRES">IN PROGRES</option>
		<option value="COMPLEATE">COMPLEATE</option>
		</select>
		</br>
		</br>
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
	</form>

	<table>
	<thead>
		
	</thead>

	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$tasks = mysqli_query($db, "SELECT * FROM task");

		$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['task']; ?> </td>
				<td class="st"> <?php echo $row['st']; ?> </td>
				<td > 
					<a href='#'>Edit</a> 
				</td>
				<td class="delete"> 
					<a href="todolist.php?del_task=<?php echo $row['id'] ?>">x</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
</table>
</body>
</html>