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



class Edit extends Component
{
    use WithFileUploads;

    public Setting $setting;
    public $file_quotes;
    public $file_locations;
    public $path;
    public array $csv_fields_locations =  ['nombre', 'latitud', 'longitud'];
    public array $csv_fields_quotes =  ['ruta', 'km', 'lts', 'casetas', 'pemex', 'pension', 'comidas', 'hotel'];
    public string $file_locations_message;
    public string $file_quotes_message;
    public $all_roles_except_a_and_b;

    protected function rules()
    {
        return [
            'setting.price_sale' => 'required|numeric|min:0.1',
            'setting.price_kilogram' => 'required|numeric',
            'setting.price_liter' => 'required|numeric',
            'setting.price_disel' => 'required|numeric',
            'setting.price_event' => 'required|numeric',
            'file_locations' => ['nullable',  File::types(['csv'])],
            'file_quotes' => ['nullable',  File::types(['csv'])]
        ];
    }


    public function mount()
    {
        $this->setting =  Setting::get()->first();
        $this->all_roles_except_a_and_b = Role::whereNotIn('name', ['role A', 'role B'])->get();

    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $this->processFileLocations();
            $this->processFileQuotes();
            $this->setting->save();
            DB::commit();
            return Redirect::route('settings.edit')->with('status', 'updated');
        } catch (Exception $e) { 
            DB::rollback();
            return;
            // return Redirect::route('settings.edit')->with('status', 'updated');
        }    
    }

    private function processFileLocations() {
        try {
            if($this->file_locations) {
                $filename = $this->file_locations->hashName();
                $path = $this->file_locations->storeAs('temp_csv', $filename);
                $this->$path = $path;

                $csv_data = $this->getDataFromCsv($this->csv_fields_locations, $path);
                if(count($csv_data['header']) && count($csv_data['data'])) {
                    $locations_bulk = [];
                    foreach($csv_data['data'] as $key => $value) {
                        $locations_bulk[] = [
                            'name' => $value['nombre'],
                            'latitude' => $value['latitud'],
                            'longitude' => $value['longitud'],
                            'user_id' => Auth::id(),
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                    $this->creteLocationsBulk($locations_bulk);
                } else {
                    $this->file_locations_message = __('Incorrect csv format.');
                    throw new \Exception($this->file_locations_message);
                }
            } 
        } catch (Exception $e) { 
            throw $e;
        }  
        
    }

    private function creteLocationsBulk($locations_bulk) {
        try {
            Location::whereNotNull('id')->delete();
            Location::insert($locations_bulk);

            Address::whereNotNull('id')->delete();
            Address::insert($locations_bulk);

        } catch (Exception $e) {
            $this->file_locations_message = __('csv_error_create_bulk', [ 'attribute' => __('locations')]);
            throw $e;
        }
    }

    private function processFileQuotes() {
        try {
            if($this->file_quotes) {
                $file_path = $this->file_quotes->path();
                $line = 0;
                $quotes_data = [];
                if (($handle = fopen($file_path, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $line++;

                        if($line === 1 ) {
                            $this->getValidationHeaderCsv($this->csv_fields_quotes, $data);
                        }  
                        else
                        {
                            $quotes_data[] = $this->buildFormattedItem($this->csv_fields_quotes, $data);
                        }       
                    }
                    [ $quotes_bulk,  $routes_bulk ] = $this->buildQuotesArray($quotes_data);
                    $this->creteQuotesBulk($quotes_bulk, $routes_bulk);
                   // fclose($handle);
                }                
            } 
        } catch(Exception $e) {
            $this->file_quotes_message = $e->getMessage();
            throw $e;
        }
    }

    public function buildQuotesArray($quotes){
        $quotes_bulk = [];
        $routes_bulk = [];
        foreach($quotes as $key => $value) {
            $routes = $this->getRouteLocations($key, $value['ruta']);
            $routes_new = $this->getRoutes($key, $value['ruta']);

            $replace = ["$",","];
            $values   = ["",""];

            // $replace = ["$"];
            // $values   = [""];

            $kilometer = str_replace($replace, $values, $value['km']);
            $cost_tollbooth = str_replace($replace, $values, $value['casetas']);
            $cost_pemex = str_replace($replace, $values, $value['pemex']);
            $cost_pension = str_replace($replace, $values, $value['pension']);
            $cost_food = str_replace($replace, $values, $value['comidas']);
            $cost_hotel = str_replace($replace, $values, $value['hotel']);

            $quotes_bulk[] = [
                'user_id' => Auth::id(),
                'point_a_location_id' => $routes[0]->id,
                'point_b_location_id' => $routes[1]->id,
                'point_c_location_id' => $routes[2]->id,
                'kilometer'=> $kilometer,
                'cost_tollbooth'=> $cost_tollbooth,
                'cost_pemex'=> $cost_pemex,
                'cost_pension'=> $cost_pension,
                'cost_food'=> $cost_food,
                'cost_hotel'=> $cost_hotel,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $routes_bulk[] = [
                'user_id' => Auth::id(),
                'load_address_id' => $routes_new[0]->id,
                'unload_address_id' => $routes_new[1]->id,
                'return_address_id' => $routes_new[2]->id,
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

        return [$quotes_bulk, $routes_bulk];
    }

    private function getValidationHeaderCsv($headers_quotes, $data){
        $csv_header = array_map('strtolower',$data);
        if($headers_quotes != $csv_header) {
            throw new \Exception(__('Incorrect csv format.'));
        }
    }

    private function getRouteLocations($key, string $routes){
        $rutasArray = explode("-",$routes);
        if(count($rutasArray) !== 3) {
            $this->file_quotes_message = __('incorrect_route_format', ['line' => $key + 1]);
            throw new \Exception($this->file_quotes_message);
        }
        
        $locationName0 = trim($rutasArray[0]);
        $locationName1 = trim($rutasArray[1]);
        $locationName2 = trim($rutasArray[2]);

        $location0 = Location::select('id', 'name')->where('name', $locationName0)->first();
        $location1 = Location::select('id', 'name')->where('name', $locationName1)->first();
        $location2 = ($locationName0 === $locationName2) ? $location0 : Location::select('id', 'name')->where('name', $locationName2)->first();
        
        if(empty($location0) || empty($location1) || empty($location2)) {
            $this->file_quotes_message = __('location_not_found', ['line' => $key + 1]);
            throw new \Exception($this->file_quotes_message);
        }

        return [$location0,  $location1,  $location2];
    }

    private function getRoutes($key, string $routes){
        $rutasArray = explode("-",$routes);
        if(count($rutasArray) !== 3) {
            $this->file_quotes_message = __('incorrect_route_format', ['line' => $key + 1]);
            throw new \Exception($this->file_quotes_message);
        }
        
        $locationName0 = trim($rutasArray[0]);
        $locationName1 = trim($rutasArray[1]);
        $locationName2 = trim($rutasArray[2]);

        $location0 = Address::select('id', 'name')->where('name', $locationName0)->first();
        $location1 = Address::select('id', 'name')->where('name', $locationName1)->first();
        $location2 = ($locationName0 === $locationName2) ? $location0 : Address::select('id', 'name')->where('name', $locationName2)->first();
        
        if(empty($location0) || empty($location1) || empty($location2)) {
            $this->file_quotes_message = __('location_not_found', ['line' => $key + 1]);
            throw new \Exception($this->file_quotes_message);
        }

        return [$location0,  $location1,  $location2];
    }

    private function creteQuotesBulk($quotes_bulk, $routes_bulk) {
        try {
            Quote::whereNotNull('id')->delete();
            Quote::insert($quotes_bulk);

            Route::whereNotNull('id')->delete();
            Route::insert($routes_bulk);

        } catch (Exception $e) {
            $this->file_locations_message = __('csv_error_create_bulk', [ 'attribute' => __('quotes')]);
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
                // $this->file_quotes_message = 'kghsdfdfs';
                return [ 'header' =>  $keys, 'data' => $csv_format ];
                //  return [ 'header' =>  [], 'data' => [], 'keys' => $keys];
            } else {
                // // array_pop($csv_array);
                // $this->file_quotes_message = '675465324';
                return [ 'header' =>  [], 'data' => []];
            }
        } catch (Exception $e) {
            // $this->file_quotes_message = $e->getMessage();
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
        return view('livewire.setting.edit');
    }
}
