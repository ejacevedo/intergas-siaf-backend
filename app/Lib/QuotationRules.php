<?php

namespace App\Lib;
use App\Models\Quote;
use App\Models\Setting;

class QuotationRules
{        
    public function getLiters(Quote $quote) {
        return round($quote->kilometer / 1.5);
    }

    public function getCostTravel(Quote $quote) {
        return $quote->cost_tollbooth + $quote->cost_pemex + $quote->cost_pension + $quote->cost_food + $quote->cost_hotel;
    }

    public function getAmountEvent(Setting $setting, Quote $quote) {
        return  $setting->price_event * $quote->kilometer;
    }

    public function getCostDisel(Setting $setting, Quote $quote) {
        return  $setting->price_disel * $this->getLiters($quote);
    }

    public function getAmountTotal(Setting $setting, Quote $quote) {
        return  $this->getCostDisel($setting, $quote) + $this->getCostTravel($quote) + $quote->cost_event;
    }

    public function getPriceSale(Setting $setting, Quote $quote) {
        return round($quote->cost_total * (1 + $setting->price_sale ),2);
    }

    public function getCostPerKilogram(Setting $setting, Quote $quote) {
        return round($quote->price_sale / $setting->load_capacity_per_kilogram, 2);
    }

    public function getCostPerliter(Setting $setting, Quote $quote){
        return round($quote->price_sale / $setting->load_capacity_per_liter, 2);
    }
}