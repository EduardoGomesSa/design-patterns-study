<?php

namespace RefactoringGuru\TemplateMethod\Conceptual;

abstract class AbstractClass {
    final public function templateMethod() : void {
        $this->baseOperation1();
        $this->requiredOperations1();
        $this->baseOperation2();
        $this->hook1();
        $this->requiredOperations2();
        $this->baseOperation3();
        $this->hook2();
    }

    protected function baseOperation1() : void {
        echo "AbstractClass says: I'm doing the bulk of the work\n";
    }

    protected function baseOperation2() : void {
        echo "AbstractClass says: But I let subclasses override some operations\n";
    }

    protected function baseOperation3() : void {
        echo "AbstractClass says: But I am doing the bulk of the work anyway\n";
    }

    abstract protected function requiredOperations1() : void;
    abstract protected function requiredOperations2() : void;

    protected function hook1() : void {}
    protected function hook2() : void {}
}

class ConcreteClass1 extends AbstractClass {
    protected function requiredOperations1(): void
    {
        echo "ConcreteClass1 says: Implemented Operation1\n";
    }

    protected function requiredOperations2(): void
    {
        echo "ConcreteClass1 says: Implemented Operation2\n";
    }
}

class ConcreteClass2 extends AbstractClass {
    protected function requiredOperations1(): void
    {
        echo "ConcreteClass2 says: Implemented Operation1\n";
    }

    protected function requiredOperations2(): void
    {
        echo "ConcreteClass2 says: Implemented Operation2\n";
    }

    protected function hook1(): void
    {
        echo "ConcreteClass2 says: Overridden Hook1\n";
    }
}