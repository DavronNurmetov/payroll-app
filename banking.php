<?php # Script 8.5 - register.php #2
include ('includes/session.php');


$page_title = 'Banking';
include ('includes/header.php');

require_once ('mysqli_connect.php'); // Connect to the db.

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {
	$pm = $_POST['type_id'];
	$name = '';
	if($_POST['type_id'] == '2'){
		$name .= "Bank Deposit";
	}
	else{
		$name .= "Check";
	}
        // Insert the payment method in the database...
        // Make the query:
        $q = "INSERT INTO payment_methods (method_type_id, method_name) VALUES ($pm, '$name')";		
        $r = @mysqli_query ($dbc, $q); // Run the query.
        if ($r) { // If it ran OK.
			
			if($_POST['type_id'] == '1'){
	            // Redirect:
				require_once ('check_functions.inc.php');
	            $url = absolute_url ('check.php');
	            header("Location: $url");
	            exit();
			}
			else{
	            // Redirect:
				require_once ('banking_functions.inc.php');
	            $url = absolute_url ('bank_edit.php');
	            header("Location: $url");
	            exit();
			}

        } else { // If it did not run OK.

                // Public message:
                echo '<h1>System Error</h1>
                <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 

                // Debugging message:
                echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';

        } // End of if ($r) IF.

        mysqli_close($dbc); // Close the database connection.

        // Include the footer and quit the script:
        include ('includes/footer.html'); 
        exit();
	
} 

$types = array();

// Make the query:
$q = "SELECT method_type_id, method_type_name FROM payment_method_types ORDER BY method_type_id ASC";		

$result = mysqli_query($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($result);

if ($num > 0) { // If it ran OK, display the records.
       
    while ($row = mysqli_fetch_assoc($result)) {
        $types[] = $row;
    }

    mysqli_free_result ($result); // Free up the resources.	
}

mysqli_close($dbc); // Close the database connection.

?>
<div class="page-header">
    <h1>Banking</h1>
</div>
<form class="form-signin" role="form" action="banking.php" method="post">
    
    <p>Payment Method: <select name="type_id">		
		
    <?php
    foreach ($types as $type) {
        echo "<option value=\"" . $type['method_type_id']. "\">" . $type['method_type_name'] . "</option>\n";
    }
    ?>
        </select></p>
    <p><button type="submit" name="submit" class="btn btn-sm btn-primary" />Select</button></p>
    <input type="hidden" name="submitted" value="TRUE" />
    
    
</form>
<?php
include ('includes/footer.html');
?>
