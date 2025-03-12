<?php

namespace RefactoringGuru\Flyweight\RealWorld;

class CatVariation
{
    public $breed;
    public $image;
    public $color;
    public $texture;
    public $fur;
    public $size;

    public function __construct(
        string $breed,
        string $image,
        string $color,
        string $texture,
        string $fur,
        string $size
    ) {
        $this->breed = $breed;
        $this->image = $image;
        $this->color = $color;
        $this->texture = $texture;
        $this->fur = $fur;
        $this->size = $size;
    }

    public function renderProfile(string $name, string $age, string $owner)
    {
        echo "= $name =\n";
        echo "Age: $age\n";
        echo "Owner: $owner\n";
        echo "Breed: $this->breed\n";
        echo "Image: $this->image\n";
        echo "Color: $this->color\n";
        echo "Texture: $this->texture\n";
    }
}


class Cat
{
    public $name;
    public $age;
    public $owner;
    private $variation;

    public function __construct(string $name, string $age, string $owner, CatVariation $variation)
    {
        $this->name = $name;
        $this->age = $age;
        $this->owner = $owner;
        $this->variation = $variation;
    }

    public function matches(array $query): bool {
        foreach($query as $key => $value) {
            if(property_exists($this, $key)) {
                if($this != $key) {
                    return false;
                }
            } elseif(property_exists($this->variation, $key)) {
                if($this->variation->$key != $key) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }

    // public function render() : string {
    //     $this->variation->renderProfile($this->name, $this->age, $this->owner);
    // }
}

class CatDataBase {
    private $cats = [];
    private $variations = [];

    public function addCat(
        string $name,
        string $age,
        string $owner,
        string $breed,
        string $image,
        string $color,
        string $texture,
        string $fur,
        string $size
    ) {
        $variation = $this->getVariation($breed, $image, $color, $texture, $fur, $size);
        $this->cats[] = new Cat($name, $age, $owner, $variation);

        echo "CatDatabase: added a cat ($name, $breed).\n";
    }

    public function getVariation(
        string $breed,
        string $image,
        string $color,
        string $texture,
        string $fur,
        string $size
    ) : CatVariation {
        $key = $this->getKey(get_defined_vars());

        if(!isset($this->variations[$key])) {
            new CatVariation($breed, $image, $color, $texture, $fur, $size);
        }

        return $this->variations[$key];
    }

    public function getKey(array $data) : string {
        return md5(implode("_", $data));
    }

    public function findCat(array $query) {
        foreach($this->cats as $cat) {
            if($cat->matches($query)) {
                return $cat;
            }
        }

        echo "CatDatabase: Sorry, your query does not yield any results.";
    }
}
