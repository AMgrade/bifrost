<?php

declare(strict_types=1);

namespace Tests\Unit;

use AMgrade\Bifrost\Bifrost;
use PHPUnit\Framework\TestCase;

class BifrostTest extends TestCase
{
    public function setUp(): void
    {
        Bifrost::flush();

        parent::setUp();
    }

    public function testPush(): void
    {
        Bifrost::push(['foo' => 1]);
        $this->assertEquals(['foo' => 1], Bifrost::toArray());

        Bifrost::push(['bar' => 2]);
        $this->assertEquals(['foo' => 1, 'bar' => 2], Bifrost::toArray());
    }

    public function testPushWithReplacement(): void
    {
        Bifrost::push(['foo' => 1]);
        $this->assertEquals(['foo' => 1], Bifrost::toArray());

        Bifrost::push(['foo' => 2, 'bar' => 2]);
        $this->assertEquals(['foo' => 2, 'bar' => 2], Bifrost::toArray());

        Bifrost::push(['foo' => 5, 'bar' => 2, 'baz' => 10]);
        $this->assertEquals(['foo' => 5, 'bar' => 2, 'baz' => 10], Bifrost::toArray());
    }

    public function testForget(): void
    {
        Bifrost::push([
            'foo' => 1,
            'bar' => 2,
            'baz' => 3,
        ]);

        $this->assertEquals(
            ['foo' => 1, 'bar' => 2, 'baz' => 3],
            Bifrost::toArray(),
        );

        Bifrost::forget('foo');
        Bifrost::forget('bar');

        $this->assertEquals(['baz' => 3], Bifrost::toArray());
    }

    public function testFlush(): void
    {
        Bifrost::push([
            'foo' => 1,
            'bar' => 2,
            'baz' => 3,
        ]);

        $this->assertEquals(
            ['foo' => 1, 'bar' => 2, 'baz' => 3],
            Bifrost::toArray(),
        );

        Bifrost::flush();

        $this->assertEmpty(Bifrost::toArray());
    }

    public function testToHtmlWithDefaultNamespace(): void
    {
        Bifrost::push([
            'foo' => 1,
            'bar' => 2,
            'baz' => 3,
        ]);

        $namespace = Bifrost::getDefaultNamespace();

        $this->assertEquals(
            "<script>window.{$namespace} = {\"foo\":1,\"bar\":2,\"baz\":3};</script>",
            Bifrost::toHtml(),
        );
    }

    public function testToHtmlWithCustomNamespace(): void
    {
        Bifrost::push([
            'foo' => 1,
            'bar' => 2,
            'baz' => 3,
        ]);

        foreach (['foo', 'bar', 'baz'] as $namespace) {
            $this->assertEquals(
                "<script>window.{$namespace} = {\"foo\":1,\"bar\":2,\"baz\":3};</script>",
                Bifrost::toHtml($namespace),
            );
        }
    }
}
