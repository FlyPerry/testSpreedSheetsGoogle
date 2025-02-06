<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Parser GoogleSheets</h1>
    <br/>
</p>

## Инструкция по развёртыванию

### 1. Клонирование репозитория
Склонируйте репозиторий с помощью команды:
```bash
git clone https://github.com/FlyPerry/testSpreedSheetsGoogle.git
```

### 2. Установка зависимостей Composer
Перейдите в директорию проекта и выполните установку зависимостей:
```bash
composer install
```

### 3. Настройка файла `.env`
Скопируйте файл `.env.example` в `.env`:
```bash
cp .env.example .env
```
Откройте файл `.env` и настройте параметры подключения к базе данных, а также другие необходимые конфигурации.

### 4. Выполнение миграций
Выполните миграции для создания таблиц в базе данных:
```bash
php yii migrate
```

### 5. Проверка PHP-расширений
Убедитесь, что в вашей системе включены следующие модули PHP:
```ini
extension=curl
extension=ffi
extension=ftp
extension=fileinfo
extension=gd
extension=mbstring
extension=exif      ; Must be after mbstring as it depends on it
extension=mysqli
extension=openssl
extension=pdo_mysql
extension=pdo_odbc
extension=shmop
```

### 6. Проверка требований проекта
Проверьте, удовлетворяет ли ваша система требованиям проекта:
```bash
php -r "require 'requirements.php';"
```

### 7. Запуск локального сервера
Если все шаги выполнены успешно, запустите встроенный сервер Yii2:
```bash
php yii serve
```
Теперь приложение доступно по адресу `http://localhost:8080`.

### 8. Запуск парсера
Для запуска парсера выполните следующую команду:
```bash
php yii parse-excel/parse-sheet
```

---

## Дополнительно

### Виртуальная консоль
Если вы используете виртуальную консоль и хотите выполнить скрипт без открытия `cmd` или `powershell`, перейдите на одну директорию выше и выполните команду:
```bash
php ../yii parse-excel/parse-sheet
```

---

## Примечания
- Убедитесь, что у вас установлены все необходимые зависимости и расширения PHP.
- Если возникнут проблемы, проверьте логи в папке `runtime/logs` для диагностики ошибок.
- Для корректной работы парсера необходимо настроить доступ к Google Sheets API и указать соответствующие ключи в `.env`.

---

## Автор
Разработано [FlyPerry](https://github.com/FlyPerry).
