<?php

namespace RefactoringGuru\ChainOfResponsibility\Conceptual;

interface Handler
{
    public function setNext(Handler $handler): Handler;

    public function handle(String $request): ?string;
}

abstract class AbstractHandler implements Handler
{
    private $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(string $request): ?string
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        return null;
    }
}


class MonkeyHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        if ($request === "Banana") {
            return "Monkey: I'll eat the " . $request . ".\n";
        } else {
            return parent::handle($request);
        }
    }
}

class SquirrelHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        if ($request === "Nut") {
            return "Squirrel: I'll eat the " . $request . ".\n";
        } else {
            return parent::handle($request);
        }
    }
}

class DogHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        if ($request === "MeatBall") {
            return "Dog: I'll eat the " . $request . ".\n";
        } else {
            return parent::handle($request);
        }
    }
}

function clientCode(Handler $handler)
{
    foreach (["Nut", "Banana", "Cup of coffee"] as $food) {
        echo "Client: Who wants a " . $food . "?\n";
        $result = $handler->handle($food);

        if ($result) {
            echo "  " . $result;
        } else {
            echo "  " . $food . " was left untouched.\n";
        }
    }
}

$monkey = new MonkeyHandler();
$squirrel = new SquirrelHandler();
$dog = new DogHandler();

$monkey->setNext($squirrel)->setNext($dog);

echo "Chain: Monkey > Squirrel > Dog\n\n";
clientCode($monkey);
echo "\n";

echo "Subchain: Squirrel > Dog\n\n";
clientCode($squirrel);
echo "\n";