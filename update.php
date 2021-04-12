<?php
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// include database and object files
include_once 'config/database.php';
include_once 'objects/product.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare objects
$product = new Product($db);

// set ID property of product to be edited
$product->id = $id;

// read the details of product to be edited
$product->readOne();


// set page header
$page_title = "Update Bourse";
include_once "layout_header.php";

echo "<div class='right-button-margin'>";
    echo "<a href='/bourse' class='btn btn-default pull-right'>Read Bourses</a>";
echo "</div>";


// if the form was submitted
if($_POST){

  if($_POST['exchange_R'] | $_POST['exchange_E']){

      $product->exchange_R = $_POST['exchange_R'];
      $product->exchange_E = $_POST['exchange_E'];

      if($product->exchange()){
          echo "<div class='alert alert-success alert-dismissable'>";
              echo "Exchange successfully.";
          echo "</div>";
      }
      else{
          echo "<div class='alert alert-danger alert-dismissable'>";
              echo "Unable to update.";
          echo "</div>";
      }

  }

  else {

    // set product property values
    $product->name = $_POST['name'];
    $product->USD = $_POST['usd'];
    $product->RUB = $_POST['rub'];
    $product->EUR = $_POST['eur'];
    $product->USDRUB = $_POST['usdrub'];
    $product->USDEUR = $_POST['usdeur'];
    $product->capital = $_POST['capital'];


    // update the product
    if($product->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Data was updated.";
        echo "</div>";
    }

    // if unable to update the product, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update.";
        echo "</div>";
    }
  }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
<p>
  USD  <input type='text' name='usd' disabled size="10" value='<?php echo $product->USD; ?>'  />
  RUB  <input type='text' name='rub' disabled size="10" value='<?php echo $product->RUB; ?>'  />
  EUR  <input type='text' name='eur' disabled size="10" value='<?php echo $product->EUR; ?>'  />
</p>

    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $product->name; ?>' required placeholder="only english" class='form-control' /></td>
        </tr>

        <tr>
            <td>USDRUB</td>
            <td><input type='text' name='usdrub' value='<?php echo $product->USDRUB; ?>' required placeholder="for example 10.23" class='form-control' /></td>
        </tr>

        <tr>
            <td>USDEUR</td>
            <td><input type='text' name='usdeur' value='<?php echo $product->USDEUR; ?>' required placeholder="for example 0.9" class='form-control' /></td>
        </tr>

        <tr>
            <td>Capital</td>
            <td><input type='text' name='capital' value='<?php echo $product->capital; ?>' required placeholder="for example 1200" class='form-control' /></td>
        </tr>


     </table>

          <div align="right">
              <button type="submit" class="btn btn-primary">Update</button>
          </div>



</form>


<!--buy("RUBUSD", 15) - покупка 15долларов за рубли-->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">

      <div class="text-primary">
         exchange RUBUSD
          </div>
         <input type='text' name='exchange_R' size="5" required placeholder="$"  />
      <button>buy dollars</button>
</form>

<!--buy("EURUSD", 15) - покупка 15долларов за евро-->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">

      <div class="text-primary">
        exchange EURUSD
         </div>
        <input type='text' name='exchange_E' size="5" required placeholder="$"  />
      <button>buy dollars</button>
</form>



<?php
include_once "layout_footer.php";
