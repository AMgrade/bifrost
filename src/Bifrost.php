<?php

declare(strict_types=1);

namespace AMgrade\Bifrost;

use function array_replace_recursive;
use function json_encode;

use const JSON_HEX_AMP;
use const JSON_HEX_APOS;
use const JSON_HEX_QUOT;
use const JSON_HEX_TAG;
use const JSON_THROW_ON_ERROR;
use const null;

class Bifrost
{
    protected static array $data = [];

    public static function getDefaultNamespace(): string
    {
        return 'Bifrost';
    }

    public static function push(array $data): void
    {
        self::$data = array_replace_recursive(self::$data, $data);
    }

    public static function forget(string $key): void
    {
        unset(self::$data[$key]);
    }

    public static function flush(): void
    {
        self::$data = [];
    }

    public static function toArray(): array
    {
        return self::$data;
    }

    /**
     * @throws \JsonException
     */
    public static function toJson(): string
    {
        return json_encode(
            self::toArray(),
            JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT,
        );
    }

    /**
     * @throws \JsonException
     */
    public static function toHtml(?string $namespace = null): string
    {
        $data = self::toJson();
        $namespace = $namespace ?: self::getDefaultNamespace();

        return "<script>window.{$namespace} = {$data};</script>";
    }
}
