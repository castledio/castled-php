<?php

declare(strict_types=1);

namespace Castled;

class Castled
{
    private static ?Client $client = null;

    /**
     * Initializes the default client to use. Uses the libcurl consumer by default.
     *
     * @param string $apiKey your project's apiKey key
     * @param array $options passed straight to the client
     */
    public static function init(string $apiKey, array $options = []): void
    {
        self::assert($apiKey, 'Castled::init() requires apiKey');
        self::$client = new Client($apiKey, $options);
    }

    /**
     * Assert `value` or throw.
     *
     * @param mixed $value
     * @param string $msg
     * @throws CastledException
     */
    private static function assert($value, string $msg): void
    {
        if (empty($value)) {
            throw new CastledException($msg);
        }
    }

    /**
     * Tracks a user action
     *
     * @param array $message
     * @return bool whether the track call succeeded
     */
    public static function track(array $message): bool
    {
        self::checkClient();
        $event = !empty($message['event']);
        self::assert($event, 'Castled::track() expects an event');
        self::validate($message, 'track');

        return self::$client->track($message);
    }

    /**
     * Check the client.
     *
     * @throws CastledException
     */
    private static function checkClient(): void
    {
        if (self::$client !== null) {
            return;
        }

        throw new CastledException('Castled::init() must be called before any other tracking method.');
    }

    /**
     * Validate common properties.
     *
     * @param array $message
     * @param string $type
     */
    public static function validate(array $message, string $type): void
    {
        $userId = (array_key_exists('userId', $message) && (string)$message['userId'] !== '');
        $anonId = !empty($message['anonymousId']);
        self::assert($userId || $anonId, "Castled::$type() requires userId or anonymousId");
    }

    /**
     * Tags traits about the user.
     *
     * @param array $message
     * @return bool whether the call succeeded
     */
    public static function identify(array $message): bool
    {
        self::checkClient();
        $message['type'] = 'identify';
        self::validate($message, 'identify');

        return self::$client->identify($message);
    }

    /**
     * Tags traits about the group.
     *
     * @param array $message
     * @return bool whether the group call succeeded
     */
    public static function group(array $message): bool
    {
        self::checkClient();
        $groupId = !empty($message['groupId']);
        self::assert($groupId, 'Castled::group() expects a groupId');
        self::validate($message, 'group');

        return self::$client->group($message);
    }

    /**
     * Tracks a page view
     *
     * @param array $message
     * @return bool whether the page call succeeded
     */
    public static function page(array $message): bool
    {
        self::checkClient();
        self::validate($message, 'page');

        return self::$client->page($message);
    }

    /**
     * Tracks a screen view
     *
     * @param array $message
     * @return bool whether the screen call succeeded
     */
    public static function screen(array $message): bool
    {
        self::checkClient();
        self::validate($message, 'screen');

        return self::$client->screen($message);
    }

    /**
     * Aliases the user id from a temporary id to a permanent one
     *
     * @param array $message
     * @return bool whether the alias call succeeded
     */
    public static function alias(array $message): bool
    {
        self::checkClient();
        $userId = (array_key_exists('userId', $message) && (string)$message['userId'] !== '');
        $previousId = (array_key_exists('previousId', $message) && (string)$message['previousId'] !== '');
        self::assert($userId && $previousId, 'Castled::alias() requires both userId and previousId');

        return self::$client->alias($message);
    }

    /**
     * Flush the client
     */
    public static function flush(): bool
    {
        self::checkClient();

        return self::$client->flush();
    }
}
