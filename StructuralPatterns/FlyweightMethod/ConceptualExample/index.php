<?php

namespace RefactoringGuru\Flyweight\Conceptual;

class Flyweight {
    private $sharedState;

    public function __construct($sharedState) {
        $this->sharedState = $sharedState;
    }

    public function operation($uniqueState) : void {
        $s = json_encode($this->sharedState);
        $u = json_encode($uniqueState);
        echo "Flyweight: Displaying shared ($s) and unique ($u) state.\n";
    }
}

class FlyweightFactory {
    private $flyweights = [];

    public function __construct(array $initialFlyweights) {
        foreach($initialFlyweights as $state) {
            $this->flyweights[$this->getKey($state)] = new FlyweightFactory($state);
        }
    }

    private function getKey(array $state): string {
        ksort($state);

        return implode("_", $state);
    } 

    public function getFlyweight(array $sharedState) : Flyweight {
        $key = $this->getKey($sharedState);

        if(!isset($this->flyweights[$key])) {
            echo "FlyweightFactory: Can`t find a flyweight, creating new one.\n";
            $this->flyweights[$key] = new Flyweight($sharedState);
        } else {
            echo "Flyweight: Reusing existing flywight.\n";
        }

        return $this->flyweights[$key];
    }

    public function listFlyweights() : void {
        $count = count($this->flyweights);
        echo "\nFlyweightFactory: I have $count flyweights:\n";
        foreach($this->flyweights as $key => $flyweight) {
            echo $key . "\n";
        }
    }
}