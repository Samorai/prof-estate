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
        ],
        'Other' => []
    ];

    public function getPotential($country, $month_start, $month_end)
    {
        $month_start -= 1;
        $month_end -= 1;
        $potential = [];
        $data = self::where(['name' => $country])->first();

        $potentials = ($data) ? $data->getAttribute('potentials') : array_fill(0,11,0);


        if ($month_end < $month_start) {
            foreach ($potentials as $key => $value) {
                if ($key >= $month_start) {
                    $potential[] = $value;
                }
            }
            for ($i=0; $i <= $month_end; $i++)  {
                $potential[] = $potentials[$i];
            }

        } else {
            foreach ($potentials as $key=>$value) {
                if ($key >= $month_start && $key <= $month_end) {
                    $potential[] = $value;
                }
            }
        }
        
        //xdebug_var_dump([$month_start,$month_end,$potential, $potentials]);exit;
        return $potential;
    }

    public function getPotentialsList()
    {
        $potentials = self::all();
        $return = [];
        foreach ($potentials as $potential)
        {
            $return[] = $potential->name;
        }
        if ($return) {
            $return[] = 'Other';
        }
        return ($return) ? $return : array_keys($this->potentials);
    }

}