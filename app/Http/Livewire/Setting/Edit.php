<?php

namespace App\Http\Livewire\Setting;

use App\Models\Setting;
use App\Models\Location;
use App\Models\Quote;


use Livewire\Component;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;
use Exception;



class Edit extends Component
{
    use WithFileUploads;

    public Setting $setting;
    public $file_quotes;
    public $file_locations;
    public $path;
    public array $csv_fields_locations =  ['nombre', 'latitud', 'longitud'];
    public array $csv_fields_quotes =  ['ruta', 'km', 'lts', 'casetas', 'pemex', 'pension', 'comidas', 'hotel', 'evento'];
    public string $file_locations_message;
    public string $file_quotes_message;

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
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $this->processFileQuotes();
            $this->processFileLocations();
            $this->setting->save();
            DB::commit();
            return Redirect::route('settings.edit')->with('status', 'updated');
        } catch (Exception $e) { 
            DB::rollback();
            return;
        }    
    }

    private function processFileLocations() {
        try {
            if($this->file_locations) {
                $filename = $this->file_locations->hashName();
                $path = $this->file_locations->storeAs('temp_csv', $filename);
    
                $csv_data = $this->getDataFromCsv($this->csv_fields_locations, $path);
                if(count($csv_data['header']) && count($csv_data['data'])) {
                    $locations_bulk = [];
                    foreach($csv_data['data'] as $value) {
                        $locations_bulk[] = [
                            'name' => $value['nombre'],
                            'latitude' => $value['latitud'],
                            'longitude' => $value['longitud'],
                            'user_id' => Auth::id()
                        ];
                    }
                    $this->creteLocationsBulk($locations_bulk);
                } else {
                    $this->file_locations_message = __('Incorrect csv format.');
                    throw new \Exception(__('Incorrect csv format.'));
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
        } catch (Exception $e) {
            $this->file_locations_message = __('csv_error_create_bulk', [ 'attribute' => __('locations')]);
            throw $e;
        }
    }

    private function processFileQuotes() {
        try {
            if($this->file_quotes) {
                $filename = $this->file_quotes->hashName();
                $path = $this->file_quotes->storeAs('temp_csv', $filename);
    
                $csv_data = $this->getDataFromCsv($this->csv_fields_quotes, $path);
                if(count($csv_data['header']) && count($csv_data['data'])){
                    $quotes_bulk = [];
                    foreach($csv_data['data'] as $value) {
                        $quotes_bulk[] = [
                            'name' => $value['nombre'],
                            'latitude' => $value['latitud'],
                            'longitude' => $value['longitud'],
                            'user_id' => Auth::id()
                        ];
                    }
    
                    $this->creteQuotesBulk($quotes_bulk);
                } else {
                    $this->file_quotes_message = __('Incorrect csv format.');
                    throw new \Exception(__('Incorrect csv format.'));
                }
            } 
        } catch(Exception $e) {
            throw $e;
        }
       
    }

    private function creteQuotesBulk($quotes_bulk) {
        try {
            Quote::whereNotNull('id')->delete();
            Quote::insert($quotes_bulk);
        } catch (Exception $e) {
            $this->file_quotes_message = __('csv_error_create_bulk', [ 'attribute' => __('locations')]);
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
        $csv_format = [];
        $keys =  explode(',',$csv_array[0]);
        if(count($csv_array) && $csv_fields == $keys ){
            foreach ($csv_array as $key => $lineString)
            {
                if($key) {
                    $lineArray = explode(",",$lineString);
                    $csv_format[] = $this->buildFormattedItem($keys, $lineArray);
                }
            }
            array_pop($csv_format);
            return [ 'header' =>  $keys, 'data' => $csv_format ];
        } else {
            return [ 'header' =>  [], 'data' => [] ];
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
        return view('livewire.setting.edit');
    }
}
