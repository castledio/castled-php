The Castled PHP SDK empowers your PHP-based backend servers to transmit user attributes and events to Castled. This data can serve as triggers for campaigns or workflows, or be synchronized with your data warehouse for advanced customer segmentation. The following steps will guide you through the process of integrating the SDK with your PHP application.

## SDK Installation

```php
require_once __DIR__ . '/vendor/autoload.php';

composer require castledio/castled-php-sdk
```

## SDK Initialisation

```php
  Castled::init(<Your API Key>);
```

## Track User Attributes

```php
  Castled::identify([
        'userId' => '12345',
        'traits' => [
            'plan' => 'basic',
            'first_name' => 'John',
            'last_name' => 'Taylor'
        ]
    ]);
```

## Track User Events

```php
  Castled::track([
        'event' => 'order_status_update',
        'userId' => '12345',
        'properties' => [
            'plan' => 'basic',
            'order_id' => 'o1'
        ]
    ]);
```

