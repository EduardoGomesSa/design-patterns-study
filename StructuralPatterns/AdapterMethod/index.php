<?php

namespace RefactoringGuru\Adapter\RealWorld;


interface Notification
{
    public function send(string $title, string $message);
}

class EmailNotification implements Notification
{
    private $adminEmail;

    public function __construct(string $adminEmail)
    {
        $this->adminEmail = $adminEmail;
    }

    public function send(string $title, string $message)
    {
        mail($this->adminEmail, $title, $message);
        echo "Sent  email with title '$title' to '{$this->adminEmail}' that says";
    }
}

class SlackApi
{
    private $login;
    private $apikey;

    public function __construct(string $login, string $apiKey)
    {
        $this->login = $login;
        $this->apikey = $apiKey;
    }

    public function logIn(): void
    {
        echo "Logged in to a slack account '{$this->login}'.\n";
    }

    public function sendMessage(string $chatId, string $message): void
    {
        echo "Posted following message into the '$chatId' chat '$message'.\n";
    }
}

class SlackNotification implements Notification
{
    private $slack;
    private $chatId;

    public function __construct($slack, $chatId)
    {
        $this->slack = $slack;
        $this->chatId = $chatId;
    }

    public function send(string $title, string $message): void
    {
        $slackMessage = "#" . $title . "# " . strip_tags($message);
        $this->slack->logIn();
        $this->slack->sendMessage($this->chatId, $slackMessage);
    }
}

function clientCode(Notification $notification)
{
    echo $notification->send(
        "Website is down!",
        "<strong style='color:red;font-size:50px;>Alert</strong>" . "Our website is not responding. Call admins and bring it up!"
    );
}


echo "Client code is designed correctly and works with email notifications:\n";
$notification = new EmailNotification("developers@example.com");
clientCode($notification);
echo "\n\n";

echo "the same client code can work with other classes via adapter:\n";
$slackApi = new SlackApi("example.com", "xxxxxxx42");
$notification = new SlackNotification($slackApi, "Example.com Developers");
clientCode($notification);