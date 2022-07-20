<?php

namespace Chiron\Support\Test;

use PHPUnit\Framework\TestCase;
use Chiron\Support\Str;

final class StrTest extends TestCase
{
    public function testSplitLines()
    {
        $this->assertEquals([], Str::splitLines(''));
        $this->assertEquals(['foo'], Str::splitLines('foo'));
        $this->assertEquals(['foo', 'bar'], Str::splitLines("foo\nbar"));
        $this->assertEquals(['foo', 'bar'], Str::splitLines("foo\r\nbar"));
        $this->assertEquals(['foo', 'bar'], Str::splitLines("foo\r\nbar\n"));
    }

    public function testLength(): void
    {
        $this->assertSame(8, Str::length('a string'));
        $this->assertSame(3, Str::length('три'));
    }

    public function byteLength(): void
    {
        $this->assertEquals(0, Str::byteLength(''));
        $this->assertEquals(4, Str::byteLength('this'));
        $this->assertEquals(6, Str::byteLength('это'));
    }

    /**
     * @dataProvider providerStartsWith
     *
     * @param bool $result
     * @param string $string
     * @param string|null $with
     */
    public function testStartsWith(bool $result, string $string, string $with): void
    {
        $this->assertSame($result, Str::startsWith($string, $with));
    }

    public function providerStartsWith(): array
    {
        return [
            // positive check
            'empty strings' => [true, '', ''],
            'starts with empty string' => [true, 'string', ''],
            'starts with a space' => [true, ' string', ' '],
            'fully identical strings' => [true, 'abc', 'abc'],
            'fully identical multibyte strings' => [true, 'Bürger', 'Bürger'],
            'starts with multibyte symbols' => [true, '我Я multibyte', '我Я'],
            'starts with ascii and multibyte symbols' => [true, 'Qנטשופ צרכנות', 'Qנ'],
            'starts with multibyte symbol ไ' => [true, 'ไทย.idn.icann.org', 'ไ'],
            'starts with hex code' => [true, '!?+', "\x21\x3F"],
            'hex code starts with ascii symbols' => [true, "\x21?+", '!?'],
            // false-positive check
            'empty string and a space' => [false, '', ' '],
            'a space and two spaces' => [false, ' ', '  '],
            'case-sensitive check' => [false, 'Abc', 'a'],
            'needle is longer' => [false, 'Abc', 'Abcde'],
            'one of the symbols of the needle is not equal' => [false, 'abc', 'abe'],
            'contains, but not starts with' => [false, 'abc', 'b'],
            'contains, but not starts with again' => [false, 'abc', 'c'],
            'case-sensitive check with multibyte symbol' => [false, 'üЯ multibyte', 'Üя multibyte'],
        ];
    }

    /**
     * @dataProvider providerEndsWith
     *
     * @param bool $result
     * @param string $string
     * @param string|null $with
     */
    public function testEndsWith(bool $result, string $string, string $with): void
    {
        // case sensitive version check
        $this->assertSame($result, Str::endsWith($string, $with));
    }

    public function providerEndsWith(): array
    {
        return [
            // positive check
            [true, '', ''],
            [true, 'string', ''],
            [true, 'string ', ' '],
            [true, 'string', 'g'],
            [true, 'abc', 'abc'],
            [true, 'Bürger', 'Bürger'],
            [true, 'Я multibyte строка我!', ' строка我!'],
            [true, '+!?', "\x21\x3F"],
            [true, "+\x21?", "!\x3F"],
            [true, 'נטשופ צרכנות', 'ת'],
            // false-positive check
            [false, '', ' '],
            [false, ' ', '  '],
            [false, 'aaa', 'aaaa'],
            [false, 'abc', 'abe'],
            [false, 'abc', 'a'],
            [false, 'abc', 'b'],
            [false, 'string', 'G'],
            [false, 'multibyte строка', 'А'],
        ];
    }
}
