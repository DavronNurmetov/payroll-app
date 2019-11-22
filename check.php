<?php 
include ('includes/session.php');

$page_title = 'Check';
include ('includes/header.php');

require_once ('mysqli_connect.php'); // Connect to the db.

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {
	
} 


mysqli_close($dbc); // Close the database connection.
?>

<div class="page-header">
    <h1>Check</h1>
</div>
<form class="form-signin" role="form" action="check.php" method="post">
    
    <p>Pay Period: <select name="type_id">
		<option>Apr 17 - Apr 24</option>
        </select></p>
	

</form>
	<img src='images\check.jpg' id='mainImg' width="58%"/>
	<br>
	<br>
    <p><button type="submit" name="submit" class="btn btn-sm btn-primary" onclick="printImg()"/>Print Check</button></p>

<?php
include ('includes/footer.html');
?>
