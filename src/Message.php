<?php

class Message
{
    protected $content;
    
    protected $date;
    
    protected $title;

    protected $receiverId;

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getReceiverId()
    {
        return $this->receiverId;
    }

    /**
     * @param mixed $receiverId
     */
    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId;
    }

    public static function showAllMessages (mysqli $connection)
    {
        $result = MessageDbQuery::selectAllFromUsersAndMessage($connection);

        echo "<div style='margin-left: 350px; margin-right: auto; margin-top: 50px' >";
        echo "<p>Sortowanie wg.:</p>";

        echo "<table border=1 cellpadding=5>";
        echo "<tr>";
        echo "<th>Date</th><th>User name</th><th>Title</th><th></th>";
        echo "</tr>";
        foreach ($result as $value) {
            if (isset($value['id'])) {
                $id = $value['id'];
                echo "<tr>";
                echo "<td>" . $value['date'] . "</td><td>" . $value['surname'] . " " . $value['name'] .  "</td><td>" . $value['title'] . "</td>";
                echo "<td><a href='showAdminMessage.php?id=$id&i=1'>Pokaż</a></td>";
                echo "<td><a href='showAdminMessage.php?id=$id&i=0'>Usuń</a></td>";
            }

        }
        echo "</table>";
        echo "</div>";
    }

    public static function deleteMessage (mysqli $connection, $id)
    {
        $result = MessageDbQuery::deleteMessage($connection, $id);
    }

    public static function showMessage (mysqli $connection, $id)
    {
        $result = MessageDbQuery::selectFromUsersAndMessageById($connection, $id);

        foreach ($result as $value) {
            echo "Tytuł: " . $value['title'] . "<br>";
            echo "Data: " . $value['date'] . "<br>";
            echo "Odbiorca: " . $value['surname'] . $value['name'] . "<br>";
            echo "Treść: <b>" . $value['content'] . "</b>";
        }
    }

    public function sendMessage(mysqli $connection, $title, $content, $id)
    {
        $date = date('y-m-d');
        MessageDbQuery::send($connection, $title, $content, $id, $date);

    }


}