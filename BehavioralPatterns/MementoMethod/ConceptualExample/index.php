<?php

namespace RefactoringGuru\Memento\Conceptual;

class Originator
{
    private $state;

    public function __construct(string $state)
    {
        $this->state = $state;
        echo "Originator: My initial state is: {$this->state}\n";
    }

    public function doSomething(): void
    {
        echo "Originator: I'm doing something important. \n";
        $this->state = $this->generateRandomString(30);
        echo "Originator: and my state has changed to: {$this->state}\n";
    }

    private function generateRandomString(int $length = 10): string
    {
        return substr(
            str_shuffle(
                str_repeat(
                    $x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                    ceil($length / strlen($x))
                )
            ),
            1,
            $length,
        );
    }

    public function save() : Memento {
        return new ConcreteMemento($this->state);
    }

    public function restore(Memento $memento) : void {
        $this->state = $memento->getState();
        echo "Originator: My state has changed to: {$this->state}\n";
    }
}

interface Memento {
    public function getName() : string;
    public function getDate() : string;
}

class ConcreteMemento implements Memento {
    private $state;
    private $date;

    public function __construct(string $state) {
        $this->state = $state;
        $this->date = date('Y-m-d H:i:s');
    }

    public function getState() : string {
        return $this->state;
    }

    public function getName(): string
    {
        return $this->date . " / (" . substr($this->state, 0, 9) . "...)";
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
