<?php

namespace Chiron\Support\Test;

use PHPUnit\Framework\TestCase;
use Chiron\Support\Callback;

final class CallbackTest extends TestCase
{
    /**
     * @dataProvider callableProvider
     */
    public function testToStringAndUnwrapFunction($callable, string $result): void
    {
        self::assertSame(Callback::toString($callable), $result);
    }

    public function callableProvider(): array
    {
        return [
            ['trim', 'trim'],
            ['undefined', 'undefined'],
            ['', ''],
            [null, ''],
            [\Closure::fromCallable('trim'), '{closure trim}'],
            [\Closure::fromCallable([Test::class, 'publicStaticMethod']), '{closure Chiron\Support\Test\Test::publicStaticMethod}'],
            [\Closure::fromCallable([new Test(), 'publicMethod']), '{closure Chiron\Support\Test\Test::publicMethod}'],
            [function() {}, '{closure}'],
            [[Test::class, 'publicStaticMethod'], 'Chiron\Support\Test\Test::publicStaticMethod'],
            ['Chiron\Support\Test\Test::publicStaticMethod', 'Chiron\Support\Test\Test::publicStaticMethod'],
            [[new Test(), 'publicMethod'], 'Chiron\Support\Test\Test::publicMethod'],
            [[new Test(), 'undefined'], 'Chiron\Support\Test\Test::undefined'],
            [['UndefinedClass', 'undefined'], 'UndefinedClass::undefined'],
            [new Test(), 'Chiron\Support\Test\Test::__invoke'],
            [new \StdClass(), 'stdClass::__invoke'], // The __invoke() function doesn't exist in the StdClass.
            [(new Test())->createPrivateClosure(), '{closure Chiron\Support\Test\Test::privateMethod}'],
            [Test::createPrivateStaticClosure(), '{closure Chiron\Support\Test\Test::privateStaticMethod}'],
        ];
    }
}

final class Test
{
    public static function publicStaticMethod(): void
    {
    }

    public function publicMethod(): void
    {
    }

    private function privateMethod(): void
    {
    }

    private static function privateStaticMethod(): void
    {
    }

    public function createPrivateClosure(): \Closure
    {
        return \Closure::fromCallable([$this, 'privateMethod']);
    }

    public static function createPrivateStaticClosure(): \Closure
    {
        return \Closure::fromCallable([self::class, 'privateStaticMethod']);
    }

    public function __invoke()
    {
    }
}
