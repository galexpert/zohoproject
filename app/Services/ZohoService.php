<?php


namespace App\Services;

use GuzzleHttp\Client;

class ZohoService
{

    private $client;

    public function __construct()
    {
        // Создание клиента Guzzle
        $this->client = new Client();
    }


    public function createAccountDeal($request)
    {
        // Получение токена доступа
        $accessToken = $this->getAccessToken();

        // Отправка данных на Zoho CRM API
        try {
            // Создание учетной записи
            $accountResponse = $this->client->request('POST', 'https://www.zohoapis.eu/crm/v2/Accounts', [
                'headers' => [
                    'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
                ],
                'json' => [
                    'data' => [
                        [
                            'Account_Name' => $request->accountName,
                            'Website' => $request->accountWebsite,
                            'Phone' => $request->accountPhone,
                        ],
                    ],
                ],
            ]);

            // Создание сделки
            $dealResponse = $this->client->request('POST', 'https://www.zohoapis.eu/crm/v2/Deals', [
                'headers' => [
                    'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
                ],
                'json' => [
                    'data' => [
                        [
                            'Deal_Name' => $request->dealName,
                            'Stage' => $request->dealStage,
                        ],
                    ],
                ],
            ]);

            // Проверка статуса ответа
            if (($dealResponse->getStatusCode() == 201 || $dealResponse->getStatusCode() == 202) &&
                ($accountResponse->getStatusCode() == 201 || $accountResponse->getStatusCode() == 202)) {
                // Обработка ответа
                $dealBody = $dealResponse->getBody();
                $accountBody = $accountResponse->getBody();
                $dealResult = json_decode($dealBody);
                $accountResult = json_decode($accountBody);


                $dealId = isset($dealResult->data[0]->details->id) ? $dealResult->data[0]->details->id : null;
                if ($dealId) {
                    $dealResult = $this->getDeal($this->client, $dealId, $accessToken);
                    // $dealResult = $dealResult['data'];
                }
                $accountId = isset($accountResult->data[0]->details->id) ? $accountResult->data[0]->details->id : null;
                if ($accountId) {
                    $accountResult = $this->getAccount($this->client, $accountId, $accessToken);
                    //  $accountResult = $accountResult['data'];
                }


                return ['dealData' => $dealResult, 'accountData' => $accountResult];

            } else {
                // Обработка ошибки
                return null;
            }
        } catch (\Exception $e) {
            // Обработка исключения
            return null;
        }
    }


    private function getAccessToken()
    {
        // Ваши учетные данные Zoho CRM
        $clientId = '1000.TRXPA9EKTK78IM3PP5GN7JOSZGYUWA';
        $clientSecret = 'f8a6bfcd3311dda5c5cc19d5f074445e2d8e0366f5';
        $refreshToken = '1000.46760a907724ba8711da82db35b1158d.b96008e69d2aa73319705cc16b68ec96';

        // 1000.3a2286ce024af48fa2c1e27e3e568849.d054541a3fa2e5b7369d2ae04aa9a58b

        // Создание клиента Guzzle
        $client = $this->client;

        // Отправка запроса на получение токена доступа
        $response = $client->request('POST', 'https://accounts.zoho.eu/oauth/v2/token', [
            'form_params' => [
                'refresh_token' => $refreshToken,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'refresh_token',
            ],
        ]);

        // Проверка статуса ответа
        if ($response->getStatusCode() == 200) {
            // Обработка ответа
            $body = $response->getBody();
            $result = json_decode($body);

            // Возвращение токена доступа
            return $result->access_token;
        } else {
            // Обработка ошибки
            throw new \Exception('Failed to get access token');
        }
    }

    private function getDeal($client, $dealId, $accessToken)
    {
        //  $dealId = $dealResult->data[0]->details->id;
        $accountResponse = $client->request('GET', "https://www.zohoapis.eu/crm/v2/Deals/$dealId", [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
            ],
        ]);

        // Проверка статуса ответа
        if ($accountResponse->getStatusCode() == 200) {
            // Обработка ответа
            $body = $accountResponse->getBody();
            $dealData = json_decode($body);

            // Возвращение токена доступа
            return $dealData;
        } else {
            // Обработка ошибки
            throw new \Exception('Failed to get access token');
        }
    }

    private function getAccount($client, $accountId, $accessToken)
    {
        //  $dealId = $dealResult->data[0]->details->id;
        $accountResponse = $client->request('GET', "https://www.zohoapis.eu/crm/v2/Accounts/$accountId", [
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $accessToken,
            ],
        ]);

        // Проверка статуса ответа
        if ($accountResponse->getStatusCode() == 200) {
            // Обработка ответа
            $body = $accountResponse->getBody();
            $accountData = json_decode($body);

            // Возвращение токена доступа
            return $accountData;
        } else {
            // Обработка ошибки
            throw new \Exception('Failed to get access token');
        }
    }

}
