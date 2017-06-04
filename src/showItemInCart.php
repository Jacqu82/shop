<?php
/**
 * Created by PhpStorm.
 * User: sgr13
 * Date: 28.05.17
 * Time: 15:02
 */

class showItemInCart
{
    public static function getItemInCart(mysqli $connection)
    {

        $sql = "SELECT * FROM cart c LEFT JOIN users u ON c.user_id=u.id LEFT JOIN item i ON c.item_id=i.id";

        $result = $connection->query($sql);

        if (!$result) {
            die("Błąd odczytu z bazy danych - Cart" . $connection->connect_errno);
        }

        return $result;
    }

    public static function showItem(mysqli $connection)
    {
       $result = self::getItemInCart($connection);
        $sum = 0;

       foreach($result as $value) {
           $id = $value['id'];
           echo '
    <div class="col-md-12 productInCart">
            <div class="col-md-2 part"><img class="img-responsive "src="' . $value['path'] .'">
            </div>
            <div class="col-md-4 part">' .$value['name'] . '
            </div>
            <div class="col-md-2 part">' . '<form><input type ="number" class="form-control input-sm" value = 1 min="1" max="' . $value["availability"] . '"></form>max: ' . $value['availability'] .  '
            </div>
            <div class="col-md-2 part" >' . $value['price'] . '
            </div>
        <div class="col-md-2 part">
            <br/>
            <a href="deleteItemFromCart.php?id=' . $id . '"><button class="btn-danger deleteItemInBasket">Usuń</button></a>
        </div>

    </div>';
           $sum += $value['price'];
       }
        echo "<div class='col-md-12' style='color: #ffffff; border-top: solid white 1px; margin-bottom: 10px'>";
        echo "<div class='col-md-8' style=''>Łączna kwota wynosi: </div>";
        echo "<div class='col-md-2'>$sum zł. </div>";
        echo "<div class='col-md-2'><a href='order.php'><button class='btn-info'>Zapłać</button> </a> </div>";
        echo "</div>";
    }
}