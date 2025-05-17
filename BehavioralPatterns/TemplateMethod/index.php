<?php

namespace RefactoringGuru\TemplateMethod\RealWorld;

abstract class SocialNetwork {
    protected $username;
    protected $password;

    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }
}