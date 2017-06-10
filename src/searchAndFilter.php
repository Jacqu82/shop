<?php

class searchAndFilter
{
    public static function searchShow()
    {
        echo '
        <div class="col-md-2"></div>
        <div class="col-md-4 col-sm-6 col-xs-12 search">
                <form style="color: #101010" method="post" action="group.php">
                    <input type="text" name="search" class="searchText">
                    <input type="submit" value="Szukaj">
                </form>
        </div>';
    }

    public static function filterShow()
    {
        echo '
        <div class="col-md-4 col-sm-6 col-xs-12 filter">
            <form style="color:black; margin-left: 79px" method="post" action="group.php">
                <select name="filter">
                    <option value="name">Nazwa</option>
                    <option value="price">Cena</option>
                    <option value="availability">Dostępność</option>
                </select>
                <input type="submit" value="Sortuj">
            </form>
        </div>
        <div class="col-md-2"></div>
        ';
    }
//
//    public static function search()
//    {
//        $sql = 'SELECT * FROM item WHERE name LIKE "%%"';
//    }
}
