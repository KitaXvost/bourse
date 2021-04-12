<?php
// get ID of the product to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// include database and object files
include_once 'config/database.php';
include_once 'objects/product.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare objects
$product = new Product($db);

// set ID property of product to be read
$product->id = $id;

// read the details of product to be read
$product->readOne();

// set page headers
$page_title = "Read One Bourse";
include_once "layout_header.php";

// read products button
echo "<div class='right-button-margin'>";
    echo "<a href='/bourse' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Bourses";
    echo "</a>";
    // HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered'>";

    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$product->name}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>USD</td>";
        echo "<td>&#36;{$product->USD}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>RUB</td>";
        echo "<td>{$product->RUB}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>EUR</td>";
        echo "<td>{$product->EUR}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>USDRUB</td>";
        echo "<td>{$product->USDRUB}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>USDEUR</td>";
        echo "<td>{$product->USDEUR}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td><b>Capital</b></td>";
        echo "<td><b>{$product->capital}</b></td>";
    echo "</tr>";



echo "</table>";
echo "</div>";

// set footer
include_once "layout_footer.php";
