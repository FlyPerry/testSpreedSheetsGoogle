<?php

namespace app\commands;

use app\components\GoogleSheets;
use app\models\BudgetCategories;
use app\models\BudgetEntries;
use app\models\BudgetProducts;
use app\models\BudgetYears;
use yii\console\Controller;
use yii\db\Exception;

class ParseExcelController extends Controller
{
    protected string $spreedSheetId = '10En6qNTpYNeY_YFTWJ_3txXzvmOA7UxSCrKfKCFfaRw';
    /**
     * @var $googleSheets GoogleSheets
     */
    protected GoogleSheets $googleSheets;

    public function actionIndex()
    {
        echo "Welcome to the Google Sheets Parser!\n";
    }

    private function actionAuthGoogle()
    {
        // Получаем экземпляр компонента GoogleSheets
        $this->googleSheets = \Yii::$app->googleSheets;

        // Вызываем метод для авторизации через консоль
        $this->googleSheets->authenticateConsole();
    }

    public function actionParseSheet()
    {
        $this->actionAuthGoogle();

        $list = 'HAGERSTOWN TOTAL';
        $range = 'A1:N'; // Диапазон данных, который нужно получить
        $spreedRange = $list . '!'.$range;
        // Получаем данные
        $data = $this->googleSheets->getSpreadsheetValues($this->spreedSheetId, $spreedRange);

        // Пропускаем заголовки (первая и вторая строка)
        array_shift($data);
        array_shift($data);


        $parsedData = [];
        $currentCategory = null;

        foreach ($data as $row) {
            $categoryName = trim($row[0] ?? '');
            $productName = trim($row[1] ?? '');

            // Если строка содержит название категории
            if (!empty($categoryName) && empty($productName) && count($row) === 1) {
                $currentCategory = $categoryName;
                continue;
            }
            $productName = trim($row[0] ?? '');
            // Если строка содержит продукт
            if (!empty($currentCategory) && !empty($productName) && $productName !== 'Total') {
                $parsedData[] = [
                    'category' => $currentCategory,
                    'product' => $productName,
                    'budget' => array_slice($row, 1, 12), // Берем значения за 12 месяцев
                ];
            }

            // Останавливаем обработку на строке CO-OP
            if ($categoryName === 'CO-OP') {
                break;
            }
        }
        // Удаляем CO-OP
        array_pop($parsedData);

        try {
            $this->saveParsedDataToDatabase($parsedData, 2024);
        } catch (Exception $exception) {
            var_dump($exception);
        } finally {
            echo "Данные по {$list} успешно обновлены";
        }
    }

    private function saveParsedDataToDatabase($parsedData, $year)
    {
        foreach ($parsedData as $item) {
            // Сохраняем год
            $yearModel = BudgetYears::find()->where(['year' => $year])->one();
            if (!$yearModel) {
                $yearModel = new BudgetYears();
                $yearModel->year = $year;
                $yearModel->save();
            }

            // Сохраняем категорию
            $categoryModel = BudgetCategories::find()->where(['name' => $item['category']])->one();
            if (!$categoryModel) {
                $categoryModel = new BudgetCategories();
                $categoryModel->name = $item['category'];
                $categoryModel->save();
            }

            // Сохраняем продукт
            $productModel = BudgetProducts::find()
                ->where(['category_id' => $categoryModel->id, 'name' => $item['product']])
                ->one();
            if (!$productModel) {
                $productModel = new BudgetProducts();
                $productModel->category_id = $categoryModel->id;
                $productModel->name = $item['product'];
                $productModel->save();
            }

            // Сохраняем записи бюджета
            foreach ($item['budget'] as $monthIndex => $amount) {
                // Используем номер месяца как id
                $monthId = $monthIndex + 1;

                $entryModel = BudgetEntries::find()
                    ->where([
                        'product_id' => $productModel->id,
                        'year_id' => $yearModel->id,
                        'month_id' => $monthId,
                    ])
                    ->one();

                if (!$entryModel) {
                    $entryModel = new BudgetEntries();
                    $entryModel->product_id = $productModel->id;
                    $entryModel->year_id = $yearModel->id;
                    $entryModel->month_id = $monthId;
                }

                $entryModel->amount = str_replace(['$', ','], '', $amount);
                $entryModel->save();
            }
        }
    }
}
