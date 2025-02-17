<?php

namespace RefactoringGuru\Composite\RealWorld;

use function PHPSTORM_META\type;

abstract class FormElement {
    protected $name;
    protected $title;
    protected $data;

    public function __construct(string $name, string $title) {
        $this->name = $name;
        $this->title = $title;
    }

    public function getName() : string {
        return $this->name;
    }

    public function setData($data) : void {
        $this->data = $data;
    }

    public function getData() : array {
        return $this->data;
    }

    abstract public function render() : string;
}

class Input extends FormElement {
    private $type;

    public function __construct(string $name, string $title, string $type) {
        $this->name = $name;
        $this->title = $title;
        $this->type = $type;
    }

    public function render(): string
    {
        return "<label for=\"{$this->name}\">{$this->title}</label>\n" .
            "<input name=\"{$this->name}\" type=\"{$this->type}\" value=\"{$this->data}\">\n";
    }
}

