<?php 

namespace RefactoringGuru\Command\Conceptual;

interface Command {
    public function execute() : void;
}

class SimpleCommand implements Command {
    private $payload;

    public function __construct(string $payload) {
        $this->payload = $payload;
    }

    public function execute(): void
    {
        echo "SimpleCommand: See, I can do simple things like printing (".$this->payload .")\n";
    }
}

class ComplexCommand implements Command {
    private $receiver;
    private $a;
    private $b;

    public function __construct(Receiver $receiver, string $a, string $b) {
        $this->receiver = $receiver;
        $this->a = $a;
        $this->b = $b;
    }

    public function execute(): void
    {
        echo "ComplexCommand: Complex stuff should be done by a receiver object.\n";
        $this->receiver->doSomething($this->a);
        $this->receiver->doSomethingElse($this->b);
    }
}

class Receiver {
    public function doSomething(string $a) : void {
        echo "Receiver: Working on(" . $a . ".)\n";
    }

    public function doSomethingElse(string $b) : void {
        echo "Receiver: Also working on (" . $b . ".)\n";
    }
}