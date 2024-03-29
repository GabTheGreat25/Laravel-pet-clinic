<?php

namespace App;

class Cart
{
    public $services = null;
    public $totalCost = 0;
    public $animals = null;

    public function __construct($oldService)
    {
        if ($oldService) {
            $this->services = $oldService->services;
            $this->animals = $oldService->animals;
            $this->totalCost = $oldService->totalCost;
        }
    }

    public function add($services, $id)
    {
        try {
            $addService = ["cost" => $services->cost, "services" => $services];
            if ($this->services) {
                if (array_key_exists($id, $this->services)) {
                    $addService = array_unique($id);
                }
            }

            $addService["cost"] = $services->cost;
            $this->services[$id] = $addService;
            $this->totalCost += $services->cost;
        } catch (\Throwable $e) {
            return redirect()
                ->route("data")
                ->with("error", $e->getMessage());
        }
    }

    public function addAnimal($animals, $id)
    {
        try {
            $addAnimal = [
                "name" => $animals->animal_name,
                "animals" => $animals,
            ];
            if ($this->animals) {
                if (array_key_exists($id, $this->animals)) {
                    $addAnimal = array_unique($id);
                }
            }
            $this->animals[$id] = $addAnimal;
        } catch (\Throwable $e) {
            return redirect()
                ->route("data")
                ->with("error", $e->getMessage());
        }
    }

    public function removeService($id)
    {
        $this->totalCost -= $this->services[$id]["cost"];
        unset($this->services[$id]);
        unset($this->animals[$id]);
    }
}
