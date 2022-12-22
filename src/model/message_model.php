<?php
require_once 'database.php';

class Message {
    // Properties
    public string $source;
    public string $destination;
    public int $sentBy;
    public string $body;

    function __construct(string $source, string $destination, int $sentBy, string $body)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->sentBy = $sentBy;
        $this->body = $body;
    }

    function __serialize()
    {
        return [
            'source' => $this->source,
            'destination' => $this->destination,
            'sentBy' => $this->sentBy,
            'body' => $this->body
        ];
    }
}
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
            $message['sent_by'],
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
