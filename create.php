<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/product.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// pass connection to objects
$product = new Product($db);


// set page headers
$page_title = "Create Bourse";
include_once "layout_header.php";

echo "<div class='right-button-margin'>";
    echo "<a href='/bourse' class='btn btn-default pull-right'>Read Bourses</a>";
echo "</div>";

?>
<?php
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){

    // set product property values
    $product->name = $_POST['name'];
    $product->USDRUB = $_POST['usdrub'];
    $product->USDEUR = $_POST['usdeur'];
    $product->capital = $_POST['capital'];


    // create the product
    if($product->create()){
        echo "<div class='alert alert-success'>Bourse was created.</div>";
    }

    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create.</div>";
    }
}
?>

<!-- HTML form for creating a product -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>Name</td>
            <td><input type='text' name='name' required placeholder="only english" class='form-control' /></td>
        </tr>

        <tr>
            <td>USDRUB</td>
            <td><input type='text' name='usdrub' required placeholder="for example 10.23" class='form-control' /></td>
        </tr>

        <tr>
            <td>USDEUR</td>
            <td><input type='text' name='usdeur' required placeholder="for example 0.9" class='form-control' /></td>
        </tr>

        <tr>
            <td>Capital</td>
            <td><input type='text' name='capital' required placeholder="for example 1200" class='form-control' /></td>
        </tr>

      </table>

            <div align="right">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>



</form>
<?php

// footer
include_once "layout_footer.php";
?>
