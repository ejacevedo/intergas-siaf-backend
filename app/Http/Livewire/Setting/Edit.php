<?php

namespace App\Http\Livewire\Setting;

use App\Models\Setting;
use App\Models\Location;
use App\Models\Quote;
use App\Models\Route;
use App\Models\Address;

use Livewire\Component;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;
use Exception;


use Spatie\Permission\Models\Role;
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
        // $this->addressRepository = $addressRepository;
        $this->setting =  Setting::get()->first();
        $this->calcLoadCapacityPerLiter();
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $this->processFileAddresses();
            $this->processFileQuotes();
            $this->calcLoadCapacityPerLiter();
            $this->setting->save();
            DB::commit();
            return Redirect::route('settings.edit')->with('status', 'updated');
        } catch (Exception $e) { 
            DB::rollback();
            $this->file_routes_message = $e->getMessage();
            return;
            // return Redirect::route('settings.edit')->with('status', 'updated');
        }    
    }

    public function calcLoadCapacityPerLiter() {
        $this->setting->load_capacity_per_liter = round($this->setting->load_capacity_per_kilogram / $this->setting->density,2);
    }

    private function processFileAddresses() {
        try {
            if($this->file_addresses) {
                $filename = $this->file_addresses->hashName();
                $path = $this->file_addresses->storeAs('temp_csv', $filename);
                $this->$path = $path;

                $csv_data = $this->getDataFromCsv($this->csv_fields_addresses, $path);
                if(count($csv_data['header']) && count($csv_data['data'])) {
                    $addresses_bulk = [];
                    foreach($csv_data['data'] as $key => $value) {
                        $addresses_bulk[] = [
                            'name' => $value['nombre'],
                            'latitude' => $value['latitud'],
                            'longitude' => $value['longitud'],
                            'user_id' => Auth::id(),
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                    $this->createAddressesBulk($addresses_bulk);
                } else {
                    $this->file_addresses_message = __('Incorrect csv format.');
                    throw new \Exception($this->file_addresses_message);
                }
            } 
        } catch (Exception $e) { 
            throw $e;
        }  
        
    }

    private function createAddressesBulk($addresses_bulk) {
        try {

            $addressRepository = new AddressRepository();
            $addressRepository->clearAll();
            $addressRepository->createBulk($addresses_bulk);

        } catch (Exception $e) {
            $this->file_addresses_message = __('csv_error_create_bulk', [ 'attribute' => __('locations')]);
            throw $e;
        }
    }

    private function processFileQuotes() {
        try {
            if($this->file_routes) {
                $file_path = $this->file_routes->path();
                $line = 0;
                $quotes_data = [];
                if (($handle = fopen($file_path, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $line++;

                        if($line === 1 ) {
                            $this->getValidationHeaderCsv($this->csv_fields_routes, $data);
                        }  
                        else
                        {
                            $quotes_data[] = $this->buildFormattedItem($this->csv_fields_routes, $data);
                        }       
                    }
                    $routes_bulk = $this->buildQuotesArray($quotes_data);
                    $this->creteQuotesBulk($routes_bulk);
                   // fclose($handle);
                }                
            } 
        } catch(Exception $e) {
            $this->file_routes_message = $e->getMessage();
            throw $e;
        }
    }

    public function buildQuotesArray($quotes){
        $quotes_bulk = [];
        $routes_bulk = [];
        foreach($quotes as $key => $value) {
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
                'kilometer'=> $kilometer,
                'cost_tollbooth'=> $cost_tollbooth,
                'cost_pemex'=> $cost_pemex,
                'cost_pension'=> $cost_pension,
                'cost_food'=> $cost_food,
                'cost_hotel'=> $cost_hotel,
                'created_at' => now(),
                'updated_at' => now()
              
            ];
        }

        // throw new \Exception(json_encode([ 'quotes_bulk' => $quotes_bulk, 'routes_bulk' => $routes_bulk]));

        return $routes_bulk;
    }

    private function getValidationHeaderCsv($headers_quotes, $data) {
        $csv_header = array_map('strtolower',$data);
        if($headers_quotes != $csv_header) {
            throw new \Exception(__('Incorrect csv format.'));
        }
    }

    private function getRoutes($key, string $routes) {
        $line = $key + 2;
        $rutasArray = explode("-",$routes);
        if(count($rutasArray) !== 3) {
            $this->file_routes_message = __('incorrect_route_format', ['line' => $key + 1]);
            throw new \Exception($this->file_routes_message);
        }
    
        $locationName0 = trim($rutasArray[0]);
        $locationName1 = trim($rutasArray[1]);
        $locationName2 = trim($rutasArray[2]);

        $location0 = Address::select('id', 'name')->where('name', $locationName0)->first();
        $location1 = Address::select('id', 'name')->where('name', $locationName1)->first();
        $location2 = ($locationName0 === $locationName2) ? $location0 : Address::select('id', 'name')->where('name', $locationName2)->first();
        
        if(empty($location0)) {
            $this->file_routes_message = __('address_not_found', [ 'name' => $locationName0, 'line' => $line ]);
            throw new \Exception($this->file_routes_message);
        }

        if(empty($location1)) {
            $this->file_routes_message = __('address_not_found', [ 'name' => $locationName0, 'line' => $line  ]);
            throw new \Exception($this->file_routes_message);
        }

        if(empty($location2)) {
            $this->file_routes_message = __('address_not_found', [ 'name' => $locationName0, 'line' => $line ]);
            throw new \Exception($this->file_routes_message);
        }

        return [$location0,  $location1,  $location2];
    }

    private function creteQuotesBulk($routes_bulk) {
        try {

            $routeRepository = new RouteRepository();
            $routeRepository->clearAll();
            $routeRepository->createBulk($routes_bulk);

        } catch (Exception $e) {
            $this->file_addresses_message = __('csv_error_create_bulk', [ 'attribute' => __('routes')]);
            throw $e;
        }
    }

    private function getDataFromCsv($csv_fields, $path_file){
        $file_to_read = Storage::disk('local')->get($path_file);
        $csv_string = json_encode($file_to_read);
        $csv_string_trim = trim($csv_string, '".');
        $csv_array =  explode("\\r\\n", $csv_string_trim);
        //$csv_format = $this->buildFormattedCsvData($csv_array);
        // $this->path = json_encode($csv_format);

        // if(count($csv_array) && explode(',',$csv_array[0]) == $csv_fields){
        //     $csv_format = $this->buildFormattedCsvData($csv_fields, $csv_array);
        //     return [ 'header' => $csv_format['keys'], 'data' => $csv_format['data'] ];
        // } else {
        //     return [ 'header' => [],'data' => [] ];
        // }
        return $this->buildFormattedCsvData($csv_fields, $csv_array);

    }

    private function buildFormattedCsvData($csv_fields, $csv_array) {
        try { 
            $csv_format = [];
            $keys = explode(',',$csv_array[0]);
            $keys = array_map('strtolower',$keys);
            if(count($csv_array) && $csv_fields == $keys ){
                foreach ($csv_array as $key => $lineString)
                {
                    if($key) {
                        $lineArray = explode(",",$lineString);
                        $csv_format[] = $this->buildFormattedItem($keys, $lineArray);
                    }
                }
                array_pop($csv_format);
                // $this->file_routes_message = 'kghsdfdfs';
                return [ 'header' =>  $keys, 'data' => $csv_format ];
                //  return [ 'header' =>  [], 'data' => [], 'keys' => $keys];
            } else {
                // // array_pop($csv_array);
                // $this->file_routes_message = '675465324';
                return [ 'header' =>  [], 'data' => []];
            }
        } catch (Exception $e) {
            // $this->file_routes_message = $e->getMessage();
            throw $e;
        }
    }

    private function buildFormattedItem($keys, $data) {
        $responseFormat = [];
        foreach ($data as $key=>$value){
            $responseFormat[$keys[$key]] = $value;
        }
        return $responseFormat;
    }

    public function render()
    {
        // $locations = Location::select('id', 'name')->whereIn('name', ['ZAPOPAN', 'ABASOLO', 'SLP'])->orderByRaw("CASE WHEN name = 'ZAPOPAN' THEN 1 WHEN name = 'ABASOLO' THEN 2 WHEN name = 'SLP' THEN 3 ELSE 4 END")->get();
       
        // // $locations = Location::whereIn('name', ['ABASOLO', 'SLP', 'ZAPOPAN'])->get();
        // $locations->count();
        // $this->path =
        
        // $locations = $this->getRouteLocations(1,'ZAPOPAN-ABASOLO-SLP');
        // $this->path = json_encode($locations);
       
        // Location::where('name', $rutasArray[0])->first();
        // Location::where('name', $rutasArray[0])->first();

        // $addressRepository = new AddressRepository();
        // $addressRepository->clearAll();
        // $addressRepository->createBulk($addresses_bulk);

        return view('livewire.setting.edit');
    }
}
