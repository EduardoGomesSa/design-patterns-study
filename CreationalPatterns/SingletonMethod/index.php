<?php

namespace RefactoringGuru\Singleton\RealWorld;

class Singleton {
    private static $instances = [];

    protected function __construct() {}

    protected function __clone(){}

    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }

    public static function getInstance() {
        $subclass = static::class;

        if(!isset(self::$instances[$subclass])) {
            self::$instances[$subclass];
        }

        return self::$instances[$subclass];
    }
}

class Logger extends Singleton {
    private $fileHandle;

    protected function __construct() {
        $this->fileHandle = fopen('php://stdout', 'w');
    }

    public function writeLog(string $message):void {
        $date = date('Y-m-d');

        fwrite($this->fileHandle, "$date: $message\n");
    }

    public static function log(string $message): void {
        $logger = static::getInstance();

        $logger->writeLog($message);
    }
}

class Config extends Singleton {
    private $hashMap = [];

    public function getValue(string $key) : string {
        return $this->hashMap[$key];
    }

    public function setValue(string $key, string $value) : void {
        $this->hashMap[$key] = $value;
    }
}

