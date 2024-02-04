<?php

require_once __DIR__ . '/vendor/autoload.php';


use Castled\Castled;
use Castled\CastledException;

// Replace 'your_api_key' and 'your_options' with appropriate values
$apiKey = 'abcd';
$options = ['option1' => 'value1'];

try {
    // Initialize the Castled class
    Castled::init($apiKey, $options);

    // Example usage of the Castled class
    // Track an event
    $result = Castled::track([
        'event' => 'user_signed_up',
        'userId' => '12345',
        'properties' => [
            'plan' => 'basic'
        ]
    ]);

    echo $result ? "Event tracked successfully.\n" : "Failed to track event.\n";

    // Add more method calls as needed for testing
} catch (CastledException $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
}
