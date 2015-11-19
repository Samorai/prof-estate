<?php
namespace App\Models;

class CheckedSites extends Base
{

    protected $attributes = [
        'website' => '',
        'competitors' => [],
        'series' => [],
        'dates' => []
    ];

}