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

class PlainTextFilter extends TextFormat {
    public function formatText(string $text): string
    {
        $text = parent::formatText($text);
        return strip_tags($text);
    }
}

class DangerousHTMLTagsFilter extends TextFormat {
    private $dangerousTagPatterns = [
        "|<script.*?>([\s\S]*)?</script>|i",
    ];

    private $dangerousAttributes = [
        "onclick", "onkeypress",
    ];

    public function formatText(string $text): string
    {
        $text = parent::formatText($text);

        foreach($this->dangerousTagPatterns as $pattern) {
            $text = preg_replace($pattern, "", $text);
        }

        foreach($this->dangerousAttributes as $attribute) {
            $text = preg_replace_callback('|<(.*?)>|', function ($matches) use ($attribute) {
                $result = preg_replace("|$attribute=|i", '', $matches[1]);
                return "<". $result .">";
            }, $text);
        }

        return $text;
    }
}