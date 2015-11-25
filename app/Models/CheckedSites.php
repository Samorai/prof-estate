<?php
namespace App\Models;

class CheckedSites extends Base
{

    protected $attributes = [
        'website' => '',
        'email' => '',
        'competitors' => [],
        'series' => [],
        'dates' => []
    ];

}