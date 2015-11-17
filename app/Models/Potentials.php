<?php
namespace App\Models;

class Potentials extends Base
{

    protected $attributes = [
        'name' => '',
        'potentials' => [],
    ];

    private $potentials = [
        'UAE' => [
            40000, 42000, 43000, 45000, 43000, 46000, 48000, 50000, 47000, 46000, 48000, 46000
        ]
    ];

    public function getPotential($country, $month_start, $month_end)
    {
        $month_start -= 1;
        $month_end -= 1;
        $potential = [];
        foreach ($this->potentials[$country] as $key=>$value)
        {
            if ($key >= $month_start && $key <= $month_end) {
                $potential[] = $value;
            }
        }
        return $potential;
    }

    public function getPotentialsList()
    {
        return array_keys($this->potentials);
    }

}