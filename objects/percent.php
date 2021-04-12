<?php
class Percent
{

    // database connection and table name
    private $conn;
    private $table_name = "percent";

    // object properties
    public $percent_USD;
    public $percent_RUB;
    public $percent_EUR;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read()
    {
        $query = "SELECT * FROM " . $this->table_name . " ";

        $stmt = $this
            ->conn
            ->prepare($query);
        $stmt->execute();

        return $percent = $stmt->fetch(PDO::FETCH_LAZY);
    }

    //Reassignment in all bourses
    function update()
    {

        $query = "UPDATE " . $this->table_name . "
               SET
                 `USD` = :USD, `RUB` = :RUB, `EUR` = :EUR ";
        $params = [
          ':USD' => $this->percent_USD,
          ':RUB' => $this->percent_RUB,
          ':EUR' => $this->percent_EUR
        ];

        $stmt = $this
            ->conn
            ->prepare($query);

        if ($stmt->execute($params))
        {

            $data = $this
                ->conn
                ->query("SELECT
                                a.USD, a.RUB, a.EUR, b.id, b.USDRUB, b.USDEUR, b.capital
                           FROM percent as a, products as b")
                ->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $k => $v)
            {

                $query = "UPDATE `products`
                   SET
                   `USD` = :USD, `RUB` = :RUB, `EUR` = :EUR
                   WHERE id = :id";
                $params = [
                     ':id' => $v['id'],
                     ':USD' => ($v['capital']) / 100 * ($v['USD']) ,
                     ':RUB' => ($v['capital']) / 100 * ($v['RUB']) * ($v['USDRUB']),
                     ':EUR' => ($v['capital']) / 100 * ($v['EUR']) * ($v['USDEUR'])
                   ];

                $stmt = $this
                    ->conn
                    ->prepare($query);
                $stmt->execute($params);
            }

        }
        return true;
    }

}
