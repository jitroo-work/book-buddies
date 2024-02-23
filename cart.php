<?php
include("header.php");

if (@!$_SESSION['username']) {
  header('location:login.php');
}

$dbError = mysqli_connect_errno();

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
  $deleteBookId = @($_GET['deleteId']);
  for ($k = 0; $k < count($_SESSION['cartBookIdArray']); $k++)
  {
    if($_SESSION['cartBookIdArray'][$k] == $deleteBookId)
    {
      array_splice($_SESSION['cartBookIdArray'], $k, 1);
      array_splice($_SESSION['cartBookQtyArray'], $k, 1);
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(isset($_POST['cart-checkout']))
  {
    $newCartQty = $_POST['cartQty'];
    foreach ($newCartQty as $key => $n)
    {
      $_SESSION['cartBookQtyArray'][$key] = $newCartQty[$key];
    }
    header('location:checkout.php');
  }
  else
  {
    $cartBookId = $_POST['bookId'];
    $cartBookQty = $_POST['bookQty'];

    if (count($_SESSION['cartBookIdArray']) == 0)
    {
      $_SESSION['cartBookIdArray'][] = $cartBookId;
      $_SESSION['cartBookQtyArray'][] = $cartBookQty;
    }
    else
    {
      $bookIsRepeated = false;
      for ($i = 0; $i < count($_SESSION['cartBookIdArray']); $i++)
      {
        if($_SESSION['cartBookIdArray'][$i] == $cartBookId)
        {
          $_SESSION['cartBookQtyArray'][$i] += $cartBookQty;
          $bookIsRepeated = true;
        }
      }
      if(!$bookIsRepeated)
      {
        $_SESSION['cartBookIdArray'][] = $cartBookId;
        $_SESSION['cartBookQtyArray'][] = $cartBookQty;
      }
    }
  }

  if(isset($_POST['addCart']))
  {
    $DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

    $file = fopen($DOCUMENT_ROOT."/book-buddies/logs.txt", "ab") or die("Unable to read file.");

    if ($file != null)
    {
      $date = new DateTime("now", new DateTimeZone('Asia/Manila'));
      $outputString = " - added a book to cart on " .  $date->format('l jS \of F Y h:i:s A') . " at " . $_SERVER['REMOTE_ADDR'] . "\n";

      fwrite($file, $outputString, strlen($outputString));
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Cart</title>
</head>
<body>
<div class="container-fluid">
	<div class="row title-bar">
		<div class="row">
			<div class="col-auto">
				<button type="button" class="btn btn-secondary back" onclick="window.location.href='home.php'">Back</button>
			</div>
			<div class="col-auto"><h1>BOOK BUDDIES</h1></div>
		</div>
	</div>
</div>

<?php include('topnav.php'); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-9">
      <div class="card bg-light">
        <h4 class="card-header bg-secondary text-white">CART</h4>
        <div class="card-body">
          <div class="mb-3 row">
            <span class="col-md text-dark">Name</span>
            <span class="col-md text-dark">Thumbnail</span>
            <span class="col-sm-2 text-dark">Price</span>
            <span class="col-sm-2 text-dark">Quantity</span>
            <span class="col-sm-2 text-dark">Action</span>
          </div>
          <form id="qty-form" action="cart.php" method="post">
            <?php
            $rowStylingCounter = 0;

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

            $totalPrice = 0;

            if ($dbError)
            {
              echo "Error: " . $dbError;
            }
            else
            {
              if (count($_SESSION['cartBookIdArray']) == 0)
              {
                echo "No items in your cart (yet)";
              }
              else
              {
                for ($j = 0; $j < count($_SESSION['cartBookIdArray']); $j++)
                {
                    $query = "SELECT book.title, book.price, book.image_name as img FROM book WHERE book.id =" . $_SESSION['cartBookIdArray'][$j] . ";";
                    $result = $db->query($query);
                    $row = $result->fetch_assoc();

                    echo "<div class='pb-2 pt-2 row " . rowStyling($rowStylingCounter) . "'>";
                    echo "<span class='col-md'>" . $row['title'] . "</span>";
                    echo "<span class='col-md'><img src='img/" . $row['img'] . "' width='75'></span>";
                    echo "<span class='col-sm-2'>PHP " . number_format($row['price'], 2, '.', ',') . "</span>";
                    echo "<span class='col-sm-2'><input name='cartQty[]' type='number' min='1' value='" . $_SESSION['cartBookQtyArray'][$j] . "' style='width:50%'></span>";
                    echo "<span class='col-sm-2'><a href='cart.php?deleteId=" . $_SESSION['cartBookIdArray'][$j] . "'>" .
                         "<button type='button' class='btn btn-danger'>DELETE</button></a></span>";
                    echo "</div>";

                    $totalPrice += ($row['price'] * $_SESSION['cartBookQtyArray'][$j]);
                    $rowStylingCounter += 1;
                }
              }
            }
            ?>
          </form>
        </div>
      </div>
    </div>

    <div class="col-3">
      <div class="card bg-light">
        <h4 class="card-header bg-info text-white">CHECKOUT</h4>
        <div class="card-body">
          <div class="p-3 row">
            <p class="fw-bold">TOTAL COST: PHP <?php echo number_format($totalPrice, 2, '.', ',') ?></p><br>
            <p class="text-muted">Note: By checking out, quantities in this page will be used, so make sure they are correct.</p>
            <div class="d-flex flex-row justify-content-around">
              <div class="flex-column"><a href="home.php"><button type='button' class='btn btn-secondary'>KEEP SHOPPING</button></a></div>
              <?php
                if (count($_SESSION['cartBookIdArray']) != 0)
                {
                  echo '<div class="flex-column"><button type="submit" class="btn btn-orange" form="qty-form" name="cart-checkout">CHECKOUT</button></div>';
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>

<?php include("footer.php"); ?>
</body>
</html>
