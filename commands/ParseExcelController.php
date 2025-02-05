<?php

namespace app\commands;

use yii\console\Controller;

class ParseExcelController extends Controller
{
    public function actionIndex()
    {
        echo "Welcome to the Google Sheets Parser!\n";
    }
    public function actionAuthGoogle()
    {
        // Получаем экземпляр компонента GoogleSheets
        $googleSheets = \Yii::$app->googleSheets;

        // Вызываем метод для авторизации через консоль
        $googleSheets->authenticateConsole();
    }
    public function actionGetData()
    {
        // Получаем экземпляр компонента GoogleSheets
        $googleSheets = \Yii::$app->googleSheets;

        // Аутентификация
        $googleSheets->authenticateConsole();

        // ID таблицы и диапазон данных
        $spreadsheetId = '10En6qNTpYNeY_YFTWJ_3txXzvmOA7UxSCrKfKCFfaRw'; // Замените на свой ID
        $range = 'Totals!A1:B10'; // Диапазон данных, который нужно получить

        // Получаем данные
        $data = $googleSheets->getSpreadsheetData($spreadsheetId, $range);

        // Если данные получены, выводим их в консоль
        if ($data) {
            echo "Data from Google Sheets:\n";
            foreach ($data as $row) {
                echo implode(' | ', $row) . "\n";
            }
        } else {
            echo "No data found.\n";
        }
    }
}
