<?php

namespace App\Lib;
use App\Models\Quote;
use App\Models\Settings;

class QuotationRules
{    
    public function getLiters(Quote $quote) {
        return round($quote->kilometer / 1.5);
    }

    public function getCostTravel(Quote $quote) {
        return $quote->cost_tollbooth + $quote->cost_pemex + $quote->cost_pension + $quote->cost_food + $quote->cost_hotel;
    }

    public function getPriceSale(Settings $setting, Quote $quote) {
        return round($quote->cost_travel * (1 + $setting->price_sale ),2);
    }

    public function getCostPerKilogram(Settings $setting, Quote $quote) {
        return round($quote->price_sale / $setting->price_kilogram, 2);
    }

    public function getCostPerliter(Settings $setting, Quote $quote){
        return round($quote->price_sale / $setting->price_liter, 2);
    }
}