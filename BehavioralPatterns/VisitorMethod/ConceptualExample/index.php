<?php 

namespace RefactoringGuru\Visitor\Conceptual;

use RefactoringGuru\TemplateMethod\Conceptual\ConcreteClass1;

interface Component{
    public function accept(Visitor $visitor):void;
}

class ConcreteComponentA implements Component {
    public function accept(Visitor $visitor): void
    {
        $visitor->visitConcreteComponentA($this);
    }

    public function exclusiveMethodOfConcreteComponentA(): string {
        return "A";
    }
}

class ConcreteComponentB implements Component {
    public function accept(Visitor $visitor): void
    {
        $visitor->visitConcreteComponentB($this);
    }

    public function specialMethodOfConcreteComponentB(): string {
        return "B";
    }
}

interface Visitor {
    public function visitConcreteComponentA(ConcreteComponentA $element): void;
    public function visitConcreteComponentB(ConcreteComponentB $element): void;
}

class ConcreteVisitor1 implements Visitor{
    public function visitConcreteComponentA(ConcreteComponentA $element): void
    {
        echo $element->exclusiveMethodOfConcreteComponentA() . " + ConcreteVisitor1\n";
    }

    public function visitConcreteComponentB(ConcreteComponentB $element): void
    {
        echo $element->specialMethodOfConcreteComponentB() . " + ConcreteVisitor1\n";
    }
}

class ConcreteVisitor2 implements Visitor {
    public function visitConcreteComponentA(ConcreteComponentA $element): void
    {
        echo $element->exclusiveMethodOfConcreteComponentA() . " + ConcreteVisitor2\n";
    }

    public function visitConcreteComponentB(ConcreteComponentB $element): void
    {
        echo $element->specialMethodOfConcreteComponentB() . " + ConcreteVisitor2\n";
    }
}

function clientCode(array $components, Visitor $visitor){
    foreach($components as $component) {
        $component->accept($visitor);
    }
}

$components = [
    new ConcreteComponentA(),
    new ConcreteComponentB(),
];

echo "The client code works with all visitors via the base Visitor interface:\n";
$visitor1 = new ConcreteVisitor1();
clientCode($components, $visitor1);
echo "\n";

echo "It allows the same client code to work with different types of visitors:\n";
$visitor2 = new ConcreteVisitor2();
clientCode($components, $visitor2);