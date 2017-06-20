<?php

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
        $userId = $_SESSION['id'];
        $i = 1;
        $sing = '';
        echo "<div userId='$userId' id='userId'></div>";
        foreach ($result as $value) {
            $id = $value['id'];
            echo '
    <div class="col-md-12 productInCart">
            <div class="col-md-2 part"><img class="img-responsive "src="' . $value['path'] . '">
            </div>
            <div class="col-md-4 part">' . $value['name'] . '
            </div>
            <div class="col-md-2 part">' . '<form class="fuck"><input type ="number"  id="' . $id . '" class="itemId form-control input-sm quantityItem" value = 1 min="1" max="' . $value["availability"] . '"></form>max: ' . $value['availability'] . '
            </div>
            <div class="col-md-2 part price" name="' . $value['price'] . '">' . $value['price'] . '
            </div>
        <div class="col-md-2 part">
            <br/>
            <a href="deleteItemFromCart.php?id=' . $id . '"><button class="btn-danger deleteItemInBasket">Usuń</button></a>
        </div>
    </div>';
            $sum += $value['price'];
            $sing .= '&id' . $i . '=' . $id . '&quantity' . $i . '=1';
            $i++;
        }
        echo "<div class='col-md-12' style='color: #ffffff; border-top: solid white 1px; margin-bottom: 10px'>";
        echo "<div class='col-md-8' style=''>Łączna kwota wynosi: </div>";
        echo "<div class='col-md-2' id='sum'>$sum</div>";
        echo "<div class='col-md-2'><a href='order.php?sum=$sum&userId=$userId" . $sing . "&i=" . $i . "'><button class='btn-info' id='buttonPay'>Zapłać</button> </a> </div>";
        echo "</div>";
    }
}
