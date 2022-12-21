<?php
require_once 'database.php';
class MessageModel extends Database
{
    public function getMessages()
    {
        $query = 'SELECT * FROM messages';
        return $this->Select($query);
    }

    public function createMessage($message)
    {
        $query =
            'INSERT INTO messages (source, destination, sentBy, body) VALUES (?, ?, ?, ?)';
        $params = [
            'ssss',
            $message['source'],
            $message['destination'],
            $message['sentBy'],
            $message['body'],
        ];
        return $this->Insert($query, $params);
    }

    public function getMessage($id)
    {
        $query = 'SELECT * FROM messages WHERE id = ?';
        $params = ['i', $id];
        return $this->Select($query, $params);
    }
}
