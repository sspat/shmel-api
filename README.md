# sspat/shmel-api

Установка
---------

Предпочтительным способом является установка через [composer](http://getcomposer.org/download/).
Поскольку пакет не опубликован на packagist, необходимо прописать репозиторий в composer.json:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/sspat/shmel-api"
    }
],
"require": {
    "sspat/shmel-api": "dev-master"
}
```
И выполнить команду на установку:
```bash
$ php composer.phar update
```

Для интеграции с 1С-Битрикс нужно подключить автозагрузчик composer,
это можно сделать в файле `/bitrix/php_interface/init.php`:
```php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
```
Пример использования
---------------------
```php
<?php
use sspat\ShmelAPI\APIClient;
use sspat\ShmelAPI\Requests\TermsOfRiggingRequest;

// Создаем экземпляр класса sspat\ShmelAPI\APIClient
$api = new APIClient(
    APIClient::TEST_ENDPOINT,  // адрес API
    [
        'login' => 'petya', // Логин
        'password' => '123456' // Пароль
    ]
);

$request = new TermsOfRiggingRequest(); // Создаем экземпляр класса запроса
$response = $api->sendRequest($request); // Передаем его в метод sendRequest, который вернет ответ API
```
Конфигурация
------------
В качестве первого параметра при создании класса APIClient необходимо передавать адрес API.
В классе определены две константы, содержащие пути к тестовому и продакшн-серверу API.

| Константа | API |
| --- | --- |
| APIClient::TEST_ENDPOINT | Тестовый сервер API |
| APIClient::PRODUCTION_ENDPOINT | Продакшн сервер API |

Вторым аргументом передается массив для конфигурации класса [SoapClient](http://php.net/manual/ru/soapclient.soapclient.php).
Все возможные параметры описаны по ссылке в руководстве php, обратить внимание следует на следующие:

| Параметр | Описание |
| --- | --- |
| login | Логин для HTTP аутентификации |
| password | Пароль для HTTP аутентификации |
| cache_wsdl | Режим кеширования WSDL-файлов, по умолчанию они кешируются на диске на 24 часа |

Пример:
```php
$api = new APIClient(
    APIClient::TEST_ENDPOINT,
    [
        'login' => 'petya',
        'password' => '123456',
        'wsdl_cache' => WSDL_CACHE_NONE
    ]
);
```
Запросы и ответы
----------------
Классы в неймспейсе `\sspat\ShmelAPI\Requests` представляют методы API.
Каждый класс запроса имеет соответствующий класс ответа в неймспейсе `\sspat\ShmelAPI\Responses`
который будет возвращен после выполнения запроса.

| Класс запроса | Класс ответа | Описание |
| --- | --- | --- |
| ListAndCostOfGoodsRequest | ListAndCostOfGoodsResponse | Перечень и стоимость товаров |
| ListAndCostOfServicesRequest | ListAndCostOfServicesResponse | Перечень и стоимость услуг |
| ListAndTermsOfKitsRequest | ListAndTermsOfKitsResponse | Перечень и условия пакетов на переезд |
| TermsOfRatesForCarsRequest | TermsOfRatesForCarsResponse | Условия тарифа на транспортные средства |
| TermsOfRatesForLoadersRequest | TermsOfRatesForLoadersResponse | Условия тарифа на грузчиков |
| TermsOfRiggingRequest | TermsOfRiggingResponse | Условия расчета такелажных работ |

Некоторые классы запросов принимают параметры для конфигарции запроса.
Для передачи значений параметров необходимо вызывать соответствующие методы
обьекта запроса:

| Класс запроса | Метод(тип аргумента) |
| --- | --- |
| TermsOfRatesForCarsRequest | setID(string), setRate(string) |
| TermsOfRatesForLoadersRequest | setID(string), setRate(string) |

Пример:
```php
$request = new TermsOfRatesForCarsRequest();
$request
    ->setID('000000026')
    ->setRate('Физическое лицо Без НДС');
    
$response = $api->sendRequest($request);
```

Для получения самого ответа API нужно использовать метод `getData()` классов ответа:
```php
$request = new TermsOfRatesForCarsRequest();
$response = $api->sendRequest($request);
$termsOfRatesForCars = $response->getData();
```
Метод возвращает массив обьектов класса stdClass содержащих данные соответствующих сущностей.
Поля сушностей подробно описаны в документации к API.

Кеширование
-----------
__Файловый кеш__

Обьекту APIClient можно передать обьект драйвера кеширования с настройками кеширования.
```php
$api = new APIClient(APIClient::TEST_ENDPOINT);

$cache = new FileCache('/tmp');
$api->setCacheDriver($cache);
```

Ответы API будут кешироваться по умолчанию на 24 часа.
Первым аргументом при создании драйвера кеша передается абсолютный путь к папке в которой будет размещаться кеш.
Папка должна быть создана заранее и к ней должен быть доступ на чтение и запись.
Для каждого метода API можно указать свое время кеширования, передав массив конфигурации при создании обьекта драйвера кеша.
Ключами массива должны быть названия методов API, их можно получить из статического метода `::getCacheCategory()` у классов запросов.
Значениями массива передается время кеширования в секундах.
```php
$cache = new FileCache(
    '/tmp',
    [
        ListAndTermsOfKitsRequest::getCacheCategory() => 3600, // Кешируем ответы этого метода на час
        TermsOfRiggingRequest::getCacheCategory() => 7200 // Кешируем ответы другого метода на два часа
    ]
);
```
Актуальность кеша проверяется каждый раз при отправке соответствующего запроса, из этого следует:
```php
$cache = new FileCache(
    '/tmp',
    [
        ListAndTermsOfKitsRequest::getCacheCategory() => 3600 // Кешируем на час
    ]
);

// ... через 10 минут в другом месте

$cache = new FileCache(
    '/tmp',
    [
        ListAndTermsOfKitsRequest::getCacheCategory() => 10 
        // Время кеширования изменено на 10 секунд, кеш от предыдущего запроса в таком случае уже устарел и не будет использован
    ]
);
```
Для ручного сброса кеша доступны два метода:
```php
$cache = new FileCache('/tmp');
$cache->clearCategory(ListAndTermsOfKitsRequest::getCacheCategory()); // Удалит кеш для метода ListAndTermsOfKits
$cache->clearAll(); // Удалит весь кеш
```
Метод `::clearAll()` следует использовать с особой осторожностью, т.к. он рекурсивно удаляет все содержимое любой папки 
указанной как путь к кешу при создании обьекта драйвера кеша.

Обработка ошибок
---------------
Все ошибки оформлены в виде исключений унаследованных от базового класса `\sspat\Exceptions\ShmelAPIException`

| Класс | Вид ошибок |
| --- | --- |
| ShmelAPIException | Любая ошибка |
| ShmelAPIConfigException | Ошибка конфигурирования |
| ShmelAPISoapException | Ошибка уровня SOAP клиента |
| ShmelAPICacheException | Ошибка уровня кеширования |

Пример
```php
try {
    $api = new APIClient(
        APIClient::TEST_ENDPOINT,
        [
            'login' => 'petya',
            'password' => '123456'
        ]
    );
    
    $cache = new FileCache('/tmp/');
    $api->setCacheDriver($cache);
    
    $request = new TermsOfRatesForCarsRequest();

    $response = $api->sendRequest($request);
} catch (ShmelAPIConfigException $e) {
    // Обработка ошибки конфигурации
} catch (ShmelAPISoapException $e) {
    // Обработка ошибки уровня SOAP
} catch (ShmelAPICacheException $e) {
    // Обработка ошибки уровня кеширования
}

$termsOfRatesForCars = $response->getData();
```