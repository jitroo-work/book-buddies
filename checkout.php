<?php
include("header.php");

if (@!$_SESSION['username']) {
  header('location:login.php');
}

if (count($_SESSION['cartBookIdArray']) == 0)
{
  header('location:cart.php');
}

$dbError = mysqli_connect_errno();

if ($dbError){
  echo "Error: " . $dbError;
} else {
  $addressQuery = "SELECT address FROM users WHERE username = '" . $_SESSION['username'] . "';";
  $result = $db->query($addressQuery);
  $row = $result->fetch_assoc();
}

function rowStyling($r)
{
  if($r % 2 == 0)
  {
    return "bg-dark text-light";
  }
  else
  {
    return "bg-light text-dark";
  }
}

?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
    // function showCardCredentials(card, isCard, form){
    //   document.getElementById(card).style.display = form.value == 'Credit/Debit Card' ? 'block' : 'none';
    //   document.getElementById(isCard).value = form.value == 'Credit/Debit Card' ? 'yes' : 'no';
    // }
    function showCardCredentials(form){
      if (form.value == 'Credit/Debit Card') {
        document.getElementById('cardCredentials').style.display = 'block';
        document.getElementById('isCard').value = 'yes';
        $('#cardNumber').prop('required', true);
        $('#cardCvv').prop('required', true);
        $('#cardExpiration').prop('required', true);
      }else{
        document.getElementById('cardCredentials').style.display = 'none';
        document.getElementById('isCard').value = 'no';
        $('#cardNumber').prop('required', false);
        $('#cardCvv').prop('required', false);
        $('#cardExpiration').prop('required', false);
      }
    }

    function updateAddress(){
      document.getElementById("address").value = '<?php echo $row['address'] ?>'
    }
	</script>

	<title>Checkout</title>
</head>
<body onload="showCardCredentials('paymentMethod')">
<div class="container-fluid">
	<div class="row title-bar">
    <div class="row">
      <div class="col-auto"><button type="button" class="btn btn-secondary back" onclick="window.location.href='home.php'">Back</button>
      </div>
      <div class="col-auto"><h1>BOOK BUDDIES | Checkout</h1></div>
    </div>
  </div>
</div>

<?php include('topnav.php'); ?>

<div class="container-fluid">
  <div class="row cover">
		<div class="col-8">
      <div class="card bg-light">
        <h4 class="card-header bg-secondary text-white">CHECKOUT DETAILS</h4>
        <div class="scrollable">
          <div class="card-body scrollable-content">
            <?php include("checkout-details.php"); ?>
          </div>
        </div>
      </div>
		</div>
		<div class="col-4 gradient" style="display: block !important; padding-top: 20px">
      <p>Before you can make the purchase, you must also fill up the following information:</p>
      <form class="row text-start" action="checkout.php" method="post">
      <div class="mb-3 row">
        <label class="col-lg-4 col-form-label text-white" for="paymentMethod">Payment Method</label>
        <div class="col-sm-8">
          <select id="paymentMethod" name="paymentMethod" class="btn btn-light dropdown-toggle" onchange="showCardCredentials(this)">
              <option value="Cash on Delivery">Cash on Delivery</option>
              <option value="Credit/Debit Card">Credit / Debit Card</option>
          </select><br>
        </div>
      </div>
      <div id="cardCredentials">
        <div class="mb-3 row">
          <label class="col-lg-4 col-form-label text-white" for="cardNumber">Card Number</label>
          <div class="col-sm-8">
           <input type="text" id="cardNumber" name="cardNumber" pattern="[0-9]{16}" class="form-control" required>
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-lg-4 col-form-label text-white" for="cardCvv">CVV</label>
          <div class="col-sm-8">
            <input type="text" id="cardCvv" name="cardCvv" class="form-control">
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-lg-4 col-form-label text-white" for="cardExpiration">Expiration Date</label>
          <div class="col-sm-8">
            <input type="text" id="cardExpiration" name="cardExpiration" class="form-control">
          </div>
        </div>
      </div>
      <div class="mb-3 row">
        <label class="col-lg-4 col-form-label text-white" for="address">Delivery Address</label>
        <div class="col-sm-8">
          <input id="address" type="text" name="address" class="form-control">
        <?php if($row['address'] != ""){?>
            <script type="text/javascript">
              updateAddress();
            </script>
        <?php } ?>
        </div>
      </div>
      <input id="isCard" type="hidden" name="isCard" class="form-control" value="no">
      <div class="card-footer text-end">
        <button type="submit" class="btn btn-orange" name="confirmCheckout">Confirm</button>
      </div>
      </form>
    </div>
  </div>

<?php
if(isset($_POST["confirmCheckout"]))
{
  if ($dbError)
  {
    echo "Error: " . $dbError;
  }
  else
  {
    $updateQuery = "UPDATE users SET address = '" . $_POST['address'] . "' WHERE username = '" . $_SESSION['username'] . "';";
    $updateResult = $db->query($updateQuery);
    echo "<script type='text/javascript'>updateAddress();</script>";
  }
?>

<!-- MODAL CONFIRM CHECKOUT -->
<div class="modal fade" id="confirm" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Confirm Checkout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Please confirm the following details.</p>
        <?php include("checkout-details.php"); ?>
        <div class="mb-3 row">
          <label class="col-lg-4 col-form-label text-dark">Payment Method</label>
          <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext text-secondary" value="<?php echo $_POST['paymentMethod']; ?>">
          </div>
        </div>
        <?php if($_POST['isCard'] == 'yes'){ ?>
        <div class="mb-3 row">
          <label class="col-lg-4 col-form-label text-dark">Card Number</label>
          <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext text-secondary" value="<?php echo $_POST['cardNumber']; ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-lg-4 col-form-label text-dark">CVV</label>
          <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext text-secondary" value="<?php echo $_POST['cardCvv']; ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-lg-4 col-form-label text-dark">Expiration Date</label>
          <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext text-secondary" value="<?php echo $_POST['cardExpiration']; ?>">
          </div>
        </div>
        <?php } ?>
        <div class="mb-3 row">
          <label class="col-lg-4 col-form-label text-dark">Address</label>
          <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext text-secondary" value="<?php echo $_POST['address']; ?>">
          </div>
        </div>
        <div class="mb-3 row">
          <label class="col-lg-4 col-form-label text-dark">Amount Due</label>
          <div class="col-sm-8">
            <input type="text" readonly class="form-control-plaintext text-secondary" value="PHP <?php echo number_format($totalPrice, 2, '.', ','); ?>">
          </div>
        </div>
      </div>
      <div class="modal-footer bg-muted">
        <button type="button" class="btn btn-primary" name="confirm" onclick="window.location.href='success.php'">Submit</button>
      </div>
    </div>
    <script type="text/javascript">
      $(window).load(function(){
      $('#confirm').modal('show');
    });
    </script>;
<?php } ?>
  </div>
</div>

<?php include("footer.php"); ?>
</body>
</html>
