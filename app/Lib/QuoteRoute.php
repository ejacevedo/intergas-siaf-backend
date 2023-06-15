<?php

namespace App\Lib;

use App\Models\Route;
use App\Models\Setting;

class QuoteRoute
{
    public function getLiters(Route $quote)
    {
        return round($quote->kilometer / 1.5);
    }

    public function getCostTravel(Route $quote)
    {
        return $quote->cost_tollbooth + $quote->cost_pemex + $quote->cost_pension + $quote->cost_food + $quote->cost_hotel;
    }

    public function getPriceSale(Setting $setting, Route $quote)
    {
        return round($quote->cost_travel * (1 + $setting->price_sale), 2);
    }

    public function getCostPerKilogram(Setting $setting, Route $quote)
    {
        return round($quote->price_sale / $setting->load_capacity_per_kilogram, 2);
    }

    public function getCostPerliter(Setting $setting, Route $quote)
    {
        return round($quote->price_sale / $setting->load_capacity_per_liter, 2);
    }
}
