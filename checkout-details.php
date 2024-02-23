<div class="mb-3 row">
  <span class="col-md text-dark">Name</span>
  <span class="col-md text-dark">Thumbnail</span>
  <span class="col-sm-2 text-dark">Price</span>
  <span class="col-sm-2 text-dark">Quantity</span>
</div>
<?php
$rowStylingCounter = 0;

$totalPrice = 0;

if ($dbError)
{
  echo "Error: " . $dbError;
}
else
{
  for ($j = 0; $j < count($_SESSION['cartBookIdArray']); $j++)
  {
      $bookQuery = "SELECT book.title, book.price, book.image_name as img FROM book WHERE book.id =" . $_SESSION['cartBookIdArray'][$j] . ";";
      $bookResult = $db->query($bookQuery);
      $bookRow = $bookResult->fetch_assoc();

      echo "<div class='pb-2 pt-2 row " . rowStyling($rowStylingCounter) . "'>";
      echo "<span class='col-md'>" . $bookRow['title'] . "</span>";
      echo "<span class='col-md'><img src='img/" . $bookRow['img'] . "' width='75'></span>";
      echo "<span class='col-sm-2'>PHP " . number_format($bookRow['price'], 2, '.', ',') . "</span>";
      echo "<span class='col-sm-2'>" . $_SESSION['cartBookQtyArray'][$j] . "</span>";
      echo "</div>";

      $totalPrice += ($bookRow['price'] * $_SESSION['cartBookQtyArray'][$j]);
      $rowStylingCounter += 1;
  }
}
?>
