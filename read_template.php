<?php
// create product button
echo "<div class='right-button-margin'>";
    echo "<a href='create.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-plus'></span> Create";
    echo "</a>";
echo "</div>";


include_once 'percent_form.php';


// display the products if there are any
if($total_rows>0){

    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>USD</th>";
            echo "<th>RUB</th>";
            echo "<th>EUR</th>";
            echo "<th>USDRUB</th>";
            echo "<th>USDEUR</th>";
            echo "<th>Capital</th>";
            echo "<th>Actions</th>";
        echo "</tr>";

$product_row = $product->readAll($from_record_num, $records_per_page);

        foreach ($product_row as $k => $v)
          {
            echo "<tr>";
                echo "<td>".$v['name']."</td>";
                echo "<td>".$v['USD']."</td>";
                echo "<td>".$v['RUB']."</td>";
                echo "<td>".$v['EUR']."</td>";
                echo "<td>".$v['USDRUB']."</td>";
                echo "<td>".$v['USDEUR']."</td>";
                echo "<td>".$v['capital']."</td>";

                echo "<td>";

                    // read product button
                    echo "<a href='read_one.php?id=".$v['id']."' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-eye-open'></span> ";
                    echo "</a>";

                    // edit product button
                    echo "<a href='update.php?id=".$v['id']."' class='btn btn-info left-margin'>";
                        echo "<span class='glyphicon glyphicon-edit'></span> ";
                    echo "</a>";

                    // delete product button
                    echo "<a delete-id='".$v['id']."' class='btn btn-danger delete-object'>";
                        echo "<span class='glyphicon glyphicon-trash'></span> ";
                    echo "</a>";

                echo "</td>";

            echo "</tr>";

          }


    echo "</table>";

    // paging buttons
    include_once 'paging.php';
}

// tell the user there are no products
else{
    echo "<div class='alert alert-danger'>No products found.</div>";
}
?>
<footer class="text-muted">
  source code GitHub
</footer>
