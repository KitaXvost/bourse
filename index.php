<?php

// core.php holds pagination variables
include_once 'config/core.php';

// include database and object files
include_once 'config/database.php';
include_once 'objects/product.php';
include_once 'objects/percent.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$percent = new Percent($db);

$page_title = "Read Bourses";
include_once "layout_header.php";


// specify the page where paging is used
$page_url = "index.php?";

// count total rows - used for pagination
$total_rows=$product->countAll();

// read_template.php controls how the product list will be rendered
include_once "read_template.php";

// layout_footer.php holds our javascript and closing html tags
include_once "layout_footer.php";
