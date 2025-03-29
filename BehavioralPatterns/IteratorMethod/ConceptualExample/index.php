<?php

namespace RefactoringGuru\Iterator\Conceptual;

use Iterator;
use Traversable;

class AlphabeticalOrderIterator implements \Iterator
{
    private $collection;
    private $position = 0;
    private $reverse = false;

    public function __construct($collection, $reverse = false)
    {
        $this->collection = $collection;
        $this->reverse = $reverse;
    }

    public function rewind(): void
    {
        $this->position = $this->reverse ? count($this->collection->getItems()) - 1 : 0;
    }

    public function current(): string
    {
        return $this->collection->getItems()[$this->position];
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position = $this->position + ($this->reverse ? -1 : 1);
    }

    public function valid(): bool
    {
        return isset($this->collection->getItems()[$this->position]);
    }
}

class WordsCollection implements \IteratorAggregate
{
    private $items = [];

    public function getItems()
    {
        return $this->items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function getIterator(): Iterator
    {
        return new AlphabeticalOrderIterator($this);
    }

    public function getReverseIterator(): Iterator
    {
        return new AlphabeticalOrderIterator($this, true);
    }
}

$collection = new WordsCollection();
$collection->addItem('First');
$collection->addItem('Second');
$collection->addItem('Third');

echo "Straight traversal:\n";
foreach($collection->getIterator() as $item) {
    echo $item . "\n";
}

echo "\n";
echo "Reverse traversal:\n";
foreach($collection->getReverseIterator() as $item) {
    echo $item . "\n";
}