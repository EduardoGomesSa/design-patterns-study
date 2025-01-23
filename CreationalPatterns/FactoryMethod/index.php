<?php 

namespace Refactoring\FactoryMethod\RealWorld;

abstract class SocialNetworkPoster {
    abstract public function getSocialNetwork() : SocialNetworkConnector;

    public function post($content): void {
        $network = $this->getSocialNetwork();

        $network->login();
        $network->createPost($content);
        $network->logout();
    }
}

class FacebookPoster extends SocialNetworkPoster {
    private $login, $password;

    public function __construct(string $login, string $password) {
        $this->login = $login;
        $this->password = $password;
    }

    public function getSocialNetwork() : SocialNetworkConnector {
        return new FacebookConnector($this->login, $this->password);
    }
}

class LinkedInPoster extends SocialNetworkPoster {
    private $email, $password;

    public function __construct(string $email, string $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function getSocialNetwork() : SocialNetworkConnector
    {
        return new LinkedInConnector($this->email, $this->password);
    }
}

interface SocialNetworkConnector {
    public function logIn() : void;
    public function logOut() : void;
    public function createPost($content) : void;
}

class FacebookConnector implements SocialNetworkConnector {
    private $login, $password;

    public function __construct(string $login, string $password) {
        $this->login = $login;
        $this->password = $password;
    }

    public function logIn() : void {
        echo "Envio da requisicao API HTTP para logar usuario $this->login com senha $this->password\n";
    }

    public function logOut() : void {
        echo "Envio da requisicao API HTTP para logOut do usuario $this->login\n";
    }

    public function createPost($content) : void {
        echo "Envio da requisicao API HTTP para criar um post na timeline do Facebook ";
    }
}

class LinkedInConnector implements SocialNetworkConnector {
    private $email, $password;

    public function __construct(string $email, string $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function logIn(): void
    {
        echo "Envio da requisicao API HTTP para logar usuario $this->email senha $this->password\n";
    }

    public function logOut(): void
    {
        echo "Envio da requisicao API HTTP para logOut do usuario $this->email\n";
    }

    public function createPost($content): void
    {
        echo "Envio da requisicao API HTTP para criar um post na timeline do LinkedIn\n";
    }
}

function clientCode(SocialNetworkPoster $creator){
    $creator->post("Vai Corinthians 42");
    $creator->post("Vamos ganhar TUDO em 2025");
}

echo "Testanto Criador concreto 1\n";
clientCode(new FacebookPoster("Eduardo_Uchiha", "dudu123"));

echo "Testanto Criador concreto 2\n";
clientCode(new LinkedInPoster("eduardo@gmail.com", "eduardo123"));



