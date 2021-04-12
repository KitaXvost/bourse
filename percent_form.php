<?php


if($_POST)
{

    $percent->percent_USD = $_POST['usd_percent'];
    $percent->percent_RUB = $_POST['rub_percent'];
    $percent->percent_EUR = $_POST['eur_percent'];
    $percent->summ = $percent->percent_USD + $percent->percent_RUB + $percent->percent_EUR;

  if($percent->summ == 100){

    if($percent->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Reassignment in all bourses successfully.";
        echo "</div>";
    }
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update.";
        echo "</div>";
    }

  }
  else{
      echo "<div class='alert alert-danger alert-dismissable'>";
          echo "the amount ".$percent->summ."% is not 100% ";
      echo "</div>";
  }

}


// перераспределения денег в биржах в % соотношении
$currency_percent = $percent->read();
?>

<form method="post">
  <table class='text-primary'>
    <tr>
      <td>&#36;</td><td>&#8381;</td><td>&euro;</td><td></td>
    </tr>
  <tr>

      <td><input type='text' name='usd_percent' size="3" value='<?php echo $currency_percent->USD; ?>' required placeholder='USD' /></td>
      <td><input type='text' name='rub_percent' size="3" value='<?php echo $currency_percent->RUB; ?>' required placeholder='RUB' /></td>
      <td><input type='text' name='eur_percent' size="3" value='<?php echo $currency_percent->EUR; ?>' required placeholder='EUR' /></td>

    <td><button>reassignment 100%</button><td>
  </tr>

  </table></br>
</form>



<?php
// перераспределения денег в биржах в % соотношении,
/*$row = $currency_percent->fetch(PDO::FETCH_ASSOC);

    extract($row);

    echo "<form method='post'>";
        echo "<table class='text-primary'>";

            echo "<tr>";
              echo "<td>&#36;</td><td>&#8381;</td><td>&euro;</td><td></td>";
            echo "</tr>";
          echo "<tr>";
              echo "<td><input type='text' name='usd_percent' size='3' value='".$percent->percent_USD."' required placeholder='USD'  /></td>";
              echo "<td><input type='text' name='rub_percent' size='3' value='{$RUB}' required placeholder='RUB'  /></td>";
              echo "<td><input type='text' name='eur_percent' size='3' value='{$EUR}' required placeholder='EUR'  /></td>";
            echo "<td><button>reassignment 100%</button><td>";
          echo "</tr>";

        echo "</table></br>";
    echo "</form>";

*/
