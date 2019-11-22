<?php 
include ('includes/session.php');

$page_title = 'Banking';
include ('includes/header.php');

require_once ('mysqli_connect.php'); // Connect to the db.

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

    $errors = array(); // Initialize an error array.

    // Check for a name:
    if (empty($_POST['holder_name'])) {
            $errors[] = 'You forgot to enter card holder name.';
    } else {
            $n = mysqli_real_escape_string($dbc, trim($_POST['holder_name']));
    }

    // Check for a routing number:
    if (empty($_POST['routing_no'])) {
            $errors[] = 'You forgot to enter your routing number.';
    } else {
            $ro = mysqli_real_escape_string($dbc, trim($_POST['routing_no']));
    }

    // Check for an account no and match against the confirmed account no:
    if (!empty($_POST['account_no1'])) {
            if ($_POST['account_no1'] != $_POST['account_no2']) {
                    $errors[] = 'Your account number did not match the confirmed account number.';
            } else {
                    $a1 = mysqli_real_escape_string($dbc, trim($_POST['account_no1']));
            }
    } else {
            $errors[] = 'You forgot to enter your account number.';
    }
	
    // Check for an address:
    if (empty($_POST['address'])) {
            $errors[] = 'You forgot to enter your address.';
    } else {
            $adr = mysqli_real_escape_string($dbc, trim($_POST['address']));
    }
	
    // Check for a state:
    if (empty($_POST['state'])) {
            $errors[] = 'You forgot to enter your state.';
    } else {
            $s = mysqli_real_escape_string($dbc, trim($_POST['state']));
    }
	
    // Check for a city:
    if (empty($_POST['city'])) {
            $errors[] = 'You forgot to enter your city.';
    } else {
            $c = mysqli_real_escape_string($dbc, trim($_POST['city']));
    }
	
    // Check for a Zip code:
    if (empty($_POST['zip_code'])) {
            $errors[] = 'You forgot to enter your zip code.';
    } else {
            $z = mysqli_real_escape_string($dbc, trim($_POST['zip_code']));
    }

    if (empty($errors)) { // If everything's OK.
		$query = "SELECT holder_name, routing_no, account_no, address, state, city, zip_code FROM accounts WHERE user_id=$user_id";
		$result = @mysqli_query($dbc, $query);
		
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if ($row){
			// Make the UPDATE query:
			$q = "UPDATE accounts SET user_id=$user_id, holder_name=$n, routing_no=$ro, account_no=$a1, address=$adr, state=$s, city=$c, zip_code=$z WHERE user_id=$user_id ";		
			$r = @mysqli_query($dbc, $q);
		}
		else{
			$q = "INSERT INTO accounts (holder_name, routing_no, account_no, address, state, city, zip_code) VALUES ($n, $ro, $a1, $adr, $s, $c, $z)";
			$r = @mysqli_query($dbc, $q);
		}

		
		if ($r) { // If it ran OK.
		
			// Print a message.
			echo '<h1>Thank you!</h1>
			<p>Your bank account details has been updated.</p><p><br /></p>';	
		
		} else { // If it did not run OK.
		
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Your bank account details could not be added/updated due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
			
		}

		// Include the footer and quit the script (to not show the form).
		include ('includes/footer.html'); 
		exit();
	}	
	else{// Report the errors.
	
		// Print any error messages, if they exist:
                if (!empty($errors)) {
                    echo '<div class="alert alert-danger">
                            <strong>Error updating bank details.</strong><br />
                    The following error(s) occurred:<br />';
                    foreach ($errors as $msg) {
                            echo " - $msg<br />\n";
                    }
                    echo '</p><p>Please try again.</p></div>';
                }
		
	} // End of if (empty($errors)) IF.

    mysqli_close($dbc); // Close the database connection.	
} 

?>

<div class="page-header">
    <h1>Bank Account Details</h1>
</div>
<form class="form-signin" role="form" action="bank_update.php" method="post">
    
    <p>Account Holder Name: <input type="normal" class="form-control" placeholder="Name" required autofocus name="holder_name" maxlength="40" value="<?php if (isset($_POST['holder_name'])) echo $_POST['holder_name']; ?>" /></p>
    <p>Routing Number: <input type="normal" class="form-control" placeholder="Routing number" required name="routing_no" maxlength="40" value="<?php if (isset($_POST['routing_no'])) echo $_POST['routing_no']; ?>" /></p>
    <p>Bank Account Number: <input type="normal" class="form-control" placeholder="Account number" required name="account_no1" maxlength="80" value="<?php if (isset($_POST['account_no1'])) echo $_POST['account']; ?>"  /> </p>
    <p>Re-enter Account: <input type="normal" class="form-control" placeholder="Re-enter account number" required name="account_no2" maxlength="20" value="<?php if (isset($_POST['account_no2'])) echo $_POST['account']; ?>"/></p><br>
	<p><strong>Mailing Address</strong></p>
    <p>Address: <input type="normal" class="form-control" placeholder="Address" required name="address" maxlength="20" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>"/></p>
    <p>State: <input type="normal" class="form-control" placeholder="State" required name="state" maxlength="20" value="<?php if (isset($_POST['state'])) echo $_POST['state']; ?>"/></p>
	<p>City: <input type="normal" class="form-control" placeholder="City" required name="city" maxlength="20" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>"/></p>
	<p>Zip Code: <input type="normal" class="form-control" placeholder="Zip Code" required name="zip_code" maxlength="20" value="<?php if (isset($_POST['zip_code'])) echo $_POST['zip_code']; ?>" /></p>
	<br>

    <p><button type="submit" name="submit" class="btn btn-sm btn-primary" />Update</button></p>
    <input type="hidden" name="submitted" value="TRUE" /> 
</form>
<?php
include ('includes/footer.html');
?>
