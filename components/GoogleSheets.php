<?php

namespace app\components;

use Yii;
use yii\base\Component;
use Google_Client;
use Google_Service_Sheets;
use GuzzleHttp\Client;

class GoogleSheets extends Component
{
    /**
     * @var $client Google_Client
     * @var $service Google_Service_Sheets
     */

    public Google_Client $client;
    public Google_Service_Sheets $service;

    public function init()
    {
        parent::init();

        $this->client = new Google_Client();

        //https://stackoverflow.com/questions/35638497/curl-error-60-ssl-certificate-prblm-unable-to-get-local-issuer-certificate
        $guzzleClient = new Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
        $this->client->setHttpClient($guzzleClient);
        $this->client->setApplicationName('Yii2 Google Sheets API');
        $this->client->setScopes([Google_Service_Sheets::SPREADSHEETS_READONLY]);
        $this->client->setAuthConfig(Yii::getAlias('@app/client_secret_763400579647-jksj2lb7q07antp4gto0nci7d3fh8jh5.apps.googleusercontent.com.json'));
        $this->client->setAccessType('offline');

        $this->service = new Google_Service_Sheets($this->client);
    }

    // Авторизация
    public function authenticateConsole()
    {

        // Проверка, есть ли токен
        $tokenPath = Yii::getAlias('@app/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $this->client->setAccessToken($accessToken);
            echo "Авторизация прошла успешно \n";
        }

        // Если токен истек, получаем новый
        if ($this->client->isAccessTokenExpired()) {
            $authUrl = $this->client->createAuthUrl();
            Yii::info("Open the following link in your browser to authorize: $authUrl", 'google-sheets');
            echo "Open the following link in your browser:\n$authUrl\n";
            echo "Enter verification code: ";
            $authCode = trim(fgets(STDIN));

            $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
            $this->client->setAccessToken($accessToken);

            // Сохраняем токен для последующего использования
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($accessToken));
        }
    }

    public function authenticateWithCode($authCode)
    {
        $tokenPath = Yii::getAlias('@app/token.json');

        // Получаем и сохраняем токен с помощью авторизационного кода
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
        $this->client->setAccessToken($accessToken);

        // Создаем директорию для хранения токенов, если она не существует
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }

        // Сохраняем токен в файл
        file_put_contents($tokenPath, json_encode($accessToken));
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }

    public function getSpreadsheetValues($spreadsheetId, $range) : array
    {
        return $this->service->spreadsheets_values->get($spreadsheetId, $range)->getValues();
    }

}
