<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZohoRequest;
use App\Services\ZohoService;

//use Illuminate\Http\Request;


class ZohoController extends Controller
{
    private $zohoService;

    public function __construct(ZohoService $zohoService)
    {
        $this->zohoService = $zohoService;

    }

    public function store(ZohoRequest $request)
    {

        // Отправка данных на Zoho CRM API
        try {
            // Создание учетной записи
            $result = $this->zohoService->createAccountDeal($request);

            if ($result) {

                return response()->json(['message' => 'Deal and Account created successfully', 'dealData' => $result['dealData'], 'accountData' => $result['accountData']]);
            } else {
                // Обработка ошибки
                return response()->json(['message' => 'Failed to create deal or account'], 500);
            }
        } catch (\Exception $e) {
            // Обработка исключения
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


}
