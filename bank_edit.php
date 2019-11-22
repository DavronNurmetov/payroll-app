<?php
include ('includes/session.php');
// This script retrieves all the records from the users table.


$page_title = 'Banking';
include ('includes/header.php');

// Page header:
echo '<h1>Bank Account Details</h1>';

require_once ('mysqli_connect.php'); // Connect to the db.
	

$q = "SELECT holder_name, routing_no, account_no, address, state, city, zip_code FROM accounts WHERE user_id=$user_id";
	
$r = @mysqli_query($dbc, $q);

$account = mysqli_fetch_array($r);

mysqli_close($dbc); // Close the database connection.

?>
<br>
<table align="" width="50%">
  <tr>
    <th>Account Holder Name</th>
	<tr><td><?php echo $account['holder_name']; ?><br><br></td></tr>
  </tr>
  <tr>
    <th>Routing Number</th>
	<tr><td><?php echo $account['routing_no']; ?><br><br></td></tr>
  </tr>
  <tr>
  	<th>Bank Account Number</th>
	<tr><td><?php echo $account['account_no']; ?><br><br></td></tr>
  </tr>
  <tr>	
	<th><br><p><strong>Mailing Address</strong><br></th>
  </tr>
  <tr>
    <th>Address</th>
	<th>State</th>
	<tr>
		<td><?php echo $account['address'];  ?><br><br></td>
		<td><?php echo $account['state']; ?><br><br></td>
	</tr>
  </tr>
  <tr>
    <th>City</th>
    <th>Zip Code</th>
	<tr>
		<td><?php echo $account['city'] ?><br></td>
		<td><?php echo $account['zip_code'] ?><br></td>
	</tr>
  </tr>

</table>
<br><br>
	<a href="bank_update.php"><p><button type="edit" name="edit" class="btn btn-sm btn-primary" />EDIT</button></p></a>


<?php
include ('includes/footer.html');
?>
