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

abstract class FieldComposite extends FormElement {
    protected $fields = [];

    public function add(FormElement $field) : void {
        $name = $field->getName();
        $this->fields[$name] = $name;
    }

    public function remove(FormElement $component) : void {
        $this->fields = array_filter($this->fields, function ($child) use ($component){
            return $child != $component;
        });
    }

    public function setData($data) : void{
        foreach($this->fields as $name => $field) {
            if(isset($data[$name])){
                $field->setData($data[$name]);
            }
        }
    }

    public function getData() : array {
        $data = [];
        foreach($this->fields as $name => $field){
            $data[$name] = $field->getData();
        }

        return $data;
    }

    public function render() : string {
        $output = "";

        foreach($this->fields as $name => $field) {
            $output .= $field->render();
        }

        return $output;
    }
} 

