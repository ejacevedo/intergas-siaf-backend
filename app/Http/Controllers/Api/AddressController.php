<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Exception;

use App\Repositories\AddressRepository;


class AddressController extends Controller
{
    private $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $limit = $request->query('limit', 10);
            $addresses = $this->addressRepository->getAll($limit);
            return response()->json($addresses, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'address.index.failed',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
