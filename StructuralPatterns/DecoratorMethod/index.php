<?php

namespace RefactoringGuru\Decorator\RealWorld;

interface InputFormat {
    public function formatText(string $text) : string;
}

class TextInput implements InputFormat {
    public function formatText(string $text): string
    {
        return $text;
    }
}

class TextFormat implements InputFormat {
    protected $inputFormat;

    public function __construct(InputFormat $inputFormat) {
        $this->inputFormat = $inputFormat;
    }

    public function formatText(string $text): string
    {
        return $this->inputFormat->formatText($text);
    }
}