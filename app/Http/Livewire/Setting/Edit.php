<?php

namespace App\Http\Livewire\Setting;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Support\Facades\Redirect;

use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;
use Exception;

use App\Repositories\AddressRepository;
use App\Repositories\RouteRepository;

class Edit extends Component
{
    use WithFileUploads;

    protected $addressRepository;
    protected $routeRepository;

    public Setting $setting;
    public $file_routes;
    public $file_addresses;
    public $path;
    public array $csv_fields_addresses =  ['nombre', 'latitud', 'longitud'];
    public array $csv_fields_routes =  ['ruta', 'km', 'lts', 'casetas', 'pemex', 'pension', 'comidas', 'hotel'];
    public string $file_addresses_message;
    public string $file_routes_message;

    protected function rules()
    {
        return [
            'setting.price_sale' => 'required|numeric|min:0.1',
            'setting.density' => 'required|numeric',
            'setting.load_capacity_per_kilogram' => 'required|numeric',
            'setting.load_capacity_per_liter' => 'required|numeric',
            'setting.price_disel' => 'required|numeric',
            'setting.price_event' => 'required|numeric',
            'file_addresses' => ['nullable',  File::types(['csv'])],
            'file_routes' => ['nullable',  File::types(['csv'])]
        ];
    }

    public function mount()
    {
        $this->setting =  Setting::get()->first();
        $this->calcLoadCapacityPerLiter();
    }

    public function save()
    {
        $this->addressRepository = app(AddressRepository::class);
        $this->routeRepository = app(RouteRepository::class);
        $this->validate();
        try {
            DB::beginTransaction();
            $this->processFileAddresses();
            $this->processFileRoutes();
            $this->calcLoadCapacityPerLiter();
            $this->setting->save();
            DB::commit();
            return Redirect::route('settings.edit')->with('status', 'updated');
        } catch (Exception $e) {
            DB::rollback();
            return;
        }
    }

    public function calcLoadCapacityPerLiter()
    {
        if($this->setting->load_capacity_per_kilogram && $this->setting->density) {
            $this->setting->load_capacity_per_liter = round($this->setting->load_capacity_per_kilogram / $this->setting->density, 2);
        }

        if(empty($this->setting->load_capacity_per_kilogram) || empty($this->setting->density)) {
            $this->setting->load_capacity_per_liter = 0;
        }
    }

    private function processFileAddresses()
    {
        try {
            if ($this->file_addresses) {
                $file_path = $this->file_addresses->path();
                $line = 0;
                $addresses_data = [];
                if (($handle = fopen($file_path, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $line++;

                        if ($line === 1) {
                            $this->getValidationHeaderCsv($this->csv_fields_addresses, $data);
                        } else {
                            $addresses_data[] = $this->buildFormattedItem($this->csv_fields_addresses, $data);
                        }
                    }
                    $addresses_bulk = $this->buildAddressesArray($addresses_data);
                    $this->createAddressesBulk($addresses_bulk);
                    fclose($handle);
                }
            }
        } catch (Exception $e) {
            $this->file_addresses_message = $e->getMessage();
            throw $e;
        }
    }

    private function createAddressesBulk($addresses_bulk)
    {
        try {
            $this->addressRepository->clearAll();
            $this->addressRepository->createBulk($addresses_bulk);
        } catch (Exception $e) {
            $this->file_addresses_message = __('csv_error_create_bulk', ['attribute' => __('addresses')]);
            throw $e;
        }
    }

    private function processFileRoutes()
    {
        try {
            if ($this->file_routes) {
                $file_path = $this->file_routes->path();
                $line = 0;
                $quotes_data = [];
                if (($handle = fopen($file_path, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $line++;

                        if ($line === 1) {
                            $this->getValidationHeaderCsv($this->csv_fields_routes, $data);
                        } else {
                            $quotes_data[] = $this->buildFormattedItem($this->csv_fields_routes, $data);
                        }
                    }
                    $routes_bulk = $this->buildQuotesArray($quotes_data);
                    $this->creteQuotesBulk($routes_bulk);
                    fclose($handle);
                }
            }
        } catch (Exception $e) {
            $this->file_routes_message = $e->getMessage();
            throw $e;
        }
    }


    public function buildAddressesArray($addresses)
    {
        $addresses_bulk = [];
        foreach ($addresses as $key => $value) {

            $addresses_bulk[] = [
                'name' => $value['nombre'],
                'latitude' => $value['latitud'],
                'longitude' => $value['longitud'],
                'user_id' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        return $addresses_bulk;
    }


    public function buildQuotesArray($quotes)
    {
        $quotes_bulk = [];
        $routes_bulk = [];
        foreach ($quotes as $key => $value) {
            $routes = $this->getRoutes($key, $value['ruta']);

            $replace = ["$"];
            $values   = [""];

            $kilometer = str_replace($replace, $values, $value['km']);
            $cost_tollbooth = str_replace($replace, $values, $value['casetas']);
            $cost_pemex = str_replace($replace, $values, $value['pemex']);
            $cost_pension = str_replace($replace, $values, $value['pension']);
            $cost_food = str_replace($replace, $values, $value['comidas']);
            $cost_hotel = str_replace($replace, $values, $value['hotel']);


            $routes_bulk[] = [
                'user_id' => Auth::id(),
                'load_address_id' => $routes[0]->id,
                'unload_address_id' => $routes[1]->id,
                'return_address_id' => $routes[2]->id,
                'kilometer' => $kilometer,
                'cost_tollbooth' => $cost_tollbooth,
                'cost_pemex' => $cost_pemex,
                'cost_pension' => $cost_pension,
                'cost_food' => $cost_food,
                'cost_hotel' => $cost_hotel,
                'created_at' => now(),
                'updated_at' => now()

            ];
        }
        return $routes_bulk;
    }

    private function getValidationHeaderCsv($headers_quotes, $data)
    {
        $csv_header = array_map('strtolower', $data);
        if ($headers_quotes != $csv_header) {
            throw new \Exception(__('Incorrect csv format.'));
        }
    }

    private function getRoutes($key, string $routes)
    {
        $line = $key + 2;
        $rutasArray = explode("-", $routes);
        if (count($rutasArray) !== 3) {
            $this->file_routes_message = __('incorrect_route_format', ['line' => $key + 1]);
            throw new \Exception($this->file_routes_message);
        }

        $addressName0 = trim($rutasArray[0]);
        $addressName1 = trim($rutasArray[1]);
        $addressName2 = trim($rutasArray[2]);

        $address0 = $this->addressRepository->getByFilters(['name' => $addressName0]);
        $address1 = $this->addressRepository->getByFilters(['name' => $addressName1]);
        $address2 = ($addressName0 === $addressName2) ? $address0 :  $this->addressRepository->getByFilters(['name' => $addressName2]);

        if (empty($address0)) {
            $this->file_routes_message = __('address_not_found', ['name' => $addressName0, 'line' => $line]);
            throw new \Exception($this->file_routes_message);
        }

        if (empty($address1)) {
            $this->file_routes_message = __('address_not_found', ['name' => $addressName0, 'line' => $line]);
            throw new \Exception($this->file_routes_message);
        }

        if (empty($address2)) {
            $this->file_routes_message = __('address_not_found', ['name' => $addressName0, 'line' => $line]);
            throw new \Exception($this->file_routes_message);
        }

        return [$address0,  $address1,  $address2];
    }

    private function creteQuotesBulk($routes_bulk)
    {
        try {
            $this->routeRepository->clearAll();
            $this->routeRepository->createBulk($routes_bulk);
        } catch (Exception $e) {
            $this->file_addresses_message = __('csv_error_create_bulk', ['attribute' => __('routes')]);
            throw $e;
        }
    }

    private function buildFormattedItem($keys, $data)
    {
        $responseFormat = [];
        foreach ($data as $key => $value) {
            $responseFormat[$keys[$key]] = $value;
        }
        return $responseFormat;
    }

    public function render()
    {
        return view('livewire.setting.edit');
    }
}
