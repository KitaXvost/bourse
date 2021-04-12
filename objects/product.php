<?php
class Product{

    // database connection and table name
    private $conn;
    private $table_name = "products";

    // object properties
    public $id;
    public $name;
    public $USD;
    public $RUB;
    public $EUR;
    public $USDRUB;
    public $USDEUR;
    public $capital;
    public $percent_USD;
    public $percent_RUB;
    public $percent_EUR;
    public $exchange_R;
    public $exchange_E;
    public $timestamp;

    public function __construct($db){
        $this->conn = $db;
    }

    // create product
    function create(){

        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name,
                    USD=:USD,
                    RUB=:RUB,
                    EUR=:EUR,
                    USDRUB=:USDRUB,
                    USDEUR=:USDEUR,
                    capital=:capital,
                    created=:created";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->USDRUB=htmlspecialchars(strip_tags($this->USDRUB));
        $this->USDEUR=htmlspecialchars(strip_tags($this->USDEUR));
        $this->capital=htmlspecialchars(strip_tags($this->capital));

        // to get time-stamp for 'created' field
        $this->timestamp = date('Y-m-d H:i:s');
        $this->USD = $this->capital/100*15;
        $this->RUB = $this->capital/100*45*$this->USDRUB;
        $this->EUR = $this->capital/100*40*$this->USDEUR;

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":USD", $this->USD);
        $stmt->bindParam(":RUB", $this->RUB);
        $stmt->bindParam(":EUR", $this->EUR);
        $stmt->bindParam(":USDRUB", $this->USDRUB);
        $stmt->bindParam(":USDEUR", $this->USDEUR);
        $stmt->bindParam(":capital", $this->capital);
        $stmt->bindParam(":created", $this->timestamp);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    function readAll($from_record_num, $records_per_page){

    $query = "SELECT *
            FROM
                " . $this->table_name . "
            ORDER BY
                name ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $product_row = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// used for paging products
public function countAll(){

    $query = "SELECT id FROM " . $this->table_name . "";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    $num = $stmt->rowCount();

    return $num;
}

function readOne(){

    $query = "SELECT *
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";

    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $this->name = $row['name'];
    $this->USD = $row['USD'];
    $this->RUB = $row['RUB'];
    $this->EUR = $row['EUR'];
    $this->USDRUB = $row['USDRUB'];
    $this->USDEUR = $row['USDEUR'];
    $this->capital = $row['capital'];

}
function update(){

  $stmt = $this->conn->prepare("SELECT * FROM percent");
  $stmt->execute();
  $percent = $stmt->fetch(PDO::FETCH_LAZY);


    $query = "UPDATE
                " . $this->table_name . "
            SET
                name=:name,
                USD=:USD,
                RUB=:RUB,
                EUR=:EUR,
                USDRUB=:USDRUB,
                USDEUR=:USDEUR,
                capital=:capital
            WHERE
                id = :id";

    $stmt = $this->conn->prepare($query);

    // posted values
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->USDRUB=htmlspecialchars(strip_tags($this->USDRUB));
    $this->USDEUR=htmlspecialchars(strip_tags($this->USDEUR));
    $this->capital=htmlspecialchars(strip_tags($this->capital));
    $this->id=htmlspecialchars(strip_tags($this->id));

    $this->USD = $this->capital / 100 * $percent->USD;
    $this->RUB = $this->capital / 100 * $percent->RUB * $this->USDRUB;
    $this->EUR = $this->capital / 100 * $percent->EUR * $this->USDEUR;

    // bind parameters
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(":USD", $this->USD);
    $stmt->bindParam(":RUB", $this->RUB);
    $stmt->bindParam(":EUR", $this->EUR);
    $stmt->bindParam(':USDRUB', $this->USDRUB);
    $stmt->bindParam(':USDEUR', $this->USDEUR);
    $stmt->bindParam(':capital', $this->capital);
    $stmt->bindParam(':id', $this->id);

    // execute the query
    if($stmt->execute()){
        return true;
    }

    return false;

}


function exchange(){
// exchange RUBUSD
  if($this->exchange_R <> 0 && $this->RUB >= $this->exchange_R * $this->USDRUB ){

      $query = "UPDATE `products` SET `USD` = :USD, `RUB` = :RUB WHERE `id` = :id";
      $params = [
          ':id' => $this->id,
          ':USD' => $this->USD + $this->exchange_R,
          ':RUB' => $this->RUB - $this->exchange_R * $this->USDRUB
        ];

       $stmt = $this->conn->prepare($query);

     if($stmt->execute($params)){
         $this->USD = $this->USD + $this->exchange_R;
         $this->RUB = $this->RUB - $this->exchange_R * $this->USDRUB;
         return true;
     }
}

// exchange EURUSD
  if($this->exchange_E <> 0 && $this->EUR >= $this->exchange_R * $this->USDEUR ){

      $query = "UPDATE `products` SET `USD` = :USD, `EUR` = :EUR WHERE `id` = :id";
      $params = [
          ':id' => $this->id,
          ':USD' => $this->USD + $this->exchange_E,
          ':EUR' => $this->EUR - $this->exchange_E * $this->USDEUR
        ];

       $stmt = $this->conn->prepare($query);

     if($stmt->execute($params)){
         $this->USD = $this->USD + $this->exchange_E;
         $this->EUR = $this->EUR - $this->exchange_E * $this->USDEUR;
         return true;
     }
}
//$stmt->execute($params);

/*  $query = "UPDATE
              " . $this->table_name . "
          SET
              USD=:USD,
          WHERE
              id = :id";

  $stmt = $this->conn->prepare($query);

  // posted values
  $this->exchange_R=htmlspecialchars(strip_tags($this->exchange_R));
  $this->id=htmlspecialchars(strip_tags($this->id));

  //$this->USD = $this->capital/100*15;
  //$this->RUB = $this->capital/100*45*$this->USDRUB;
  //$this->EUR = $this->capital/100*40*$this->USDEUR;

  // bind parameters
  //$stmt->bindParam(':name', $this->name);
  $stmt->bindParam(":USD", $this->exchange_R);
  //$stmt->bindParam(":RUB", $this->RUB);
  //$stmt->bindParam(":EUR", $this->EUR);
  /*$stmt->bindParam(':USDRUB', $this->USDRUB);
  $stmt->bindParam(':USDEUR', $this->USDEUR);
  $stmt->bindParam(':capital', $this->capital);*/
  /*$stmt->bindParam(':id', $this->id);

  // execute the query
  if($stmt->execute()){
      return true;
  }

  return false;*/


}

// delete the product
function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);

    if($result = $stmt->execute()){
        return true;
    }else{
        return false;
    }
}

}
