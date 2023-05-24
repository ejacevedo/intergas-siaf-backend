<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;

use Validator;
use Exception;

use App\Repositories\AddressRepository;


class AddressController extends Controller
{

    private $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function index(Request $request)
    {
        try {
            $addresses = $this->addressRepository->getAll();
            return response()->json($addresses, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'address.index.failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}