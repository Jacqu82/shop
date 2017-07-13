<?php

include_once 'connection.php';
require_once 'autoload.php';
require_once '../layout/Layout.php';

session_start();

?>
<!DOCTYPE HTML>
<html>

<?php //metoda wysiwetlająca część Head strony
Layout::showHead();

//sprawdzenie czy użytkownik jest zalogowany
if (!isset($_SESSION['user'])) {
    header("location:index.php");
} else {
    ?>
    <body>
    <div class="container">
        <?php //wywołanie metody pokazującej górny pasek opcji
        Layout::showAllOptionsIndex($connection);
        ?>
        <div id="panel" class="col-md-12 col-sm-12 col-xs-12">
            <h1>ALLEDROGO - niepoważny sklep internetowy</h1>
            <div class="col-md-12 col-sm-12 col-xs-12 searchAndFilter">
                <?php
                //wywołanie metod które wyświetlają formularze - wyszukiwania i filtrów
                Layout::searchShow();
                Layout::filterShow();
                //przypisanie zmiennej selection domyslnej wartości jako pusty string
                $selection = '';
                //domyslne sortowanie po nazwie, poprzez przypisanie stringa 'name' do zmiennej orderSelection
                $orderSelection = 'name';
                if ($_SERVER['REQUEST_METHOD'] === "POST") {
                    //jeśli POST-em przesłane zostały dane odnosnie wyszukiwania to uruchomi się ten if
                    if (isset($_POST['search'])) {
                        $selection = mysqli_real_escape_string($connection, $_POST['search']);
                    }
                    //jesli POST z filtrem - uruchomi się ten filtr
                    if (isset($_POST['filter'])) {
                        $orderSelection = mysqli_real_escape_string($connection, $_POST['filter']);
                    }
                }
                ?>
            </div>
        </div>
        <div class="row mainRow">
            <div class="col-md-2 col-sm-2 col-xs-3 witaj row1">
                <div class="row rowing">
                    <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1 logo">
                        <a href="../web/index.php" class="btn btn-primary btn-block logo">Alledrogo</a>
                    </div>
                    <?php //wywołanie metody, która ma za zadanie wyświetlić wszystkie nazwy grup produktów(lewy side bar)
                    Layout::showGroupName($connection)
                    ?>
                </div>
            </div>
            <div class="col-md-8 tresc col-sm-8 col-xs-6" id="mainContent">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    if (isset($_GET['groupId'])) {
                        //przy wyborze grupy produktów przypisujemy id tej grupy do zmiennej oraz zapisujemy w sesji
                        $groupId = $_GET['groupId'];
                        $groupId = intval($groupId);
                        $_SESSION['groupId'] = $groupId;
                    }
                }
                ?>
                <div id="content" class="fakeScroll">
                    <?php
                    //w przypadku wysyłania danych POST-em - czyli wykorzystania wyszukiwania lub filtru
                    // nie uruchomi się if z GET-em, dlatego wykorzystujemy id zapisane w sesji
                    $groupId = $_SESSION['groupId'];
                    //uruchamiamy metodę , która wyciąga odpowiednie dane i je wyświetla
                    Layout::showProductGroup($groupId, $connection, $selection, $orderSelection)
                    ?>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-3 witaj row1">
                <div class="row rowing">
                    <div class="col-md-12 col-sm-12 col-xs-12 rejestracja1 row1 logo">
                        <div id="line">
                            <a class="btn btn-primary btn-block logo">Bestsellers</a>
                        </div>
                    </div>
                    <div id="productsCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <?php //trzy razy wywoływana metoda, której celem jest wylosowanie produktów i wrzucenie ich do karuzeli
                                Layout::getHTML($connection) ?>
                            </div>
                            <div class="item">
                                <?php Layout::getHTML($connection); ?>
                            </div>
                            <div class="item">
                                <?php Layout::getHTML($connection); ?>
                            </div>
                        </div>
                    </div>
                    <div id="productsCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="item active">
                                <?php //trzy razy wywoływana metoda, której celem jest wylosowanie produktów i wrzucenie ich do karuzeli
                                Layout::getHTML($connection) ?>
                            </div>
                            <div class="item">
                                <?php Layout::getHTML($connection); ?>
                            </div>
                            <div class="item">
                                <?php Layout::getHTML($connection); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row foot">
            <h1>2017 &copy ALLEDROGO</h1>
        </div>
    </div>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/style.js"></script>
    </body>
    <?php
}
$connection->close();
?>
</html>