<?php
declare(strict_types=1);

namespace Afonso\Pitstops\Tests;

use Afonso\Pitstops\Utils;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UtilsTest extends TestCase
{
    public function testMillisecondsToDisplayTimeWithLessThanASecond()
    {
        $this->assertEquals('00:00.123', Utils::millisecondsToDisplayTime(123));
    }

    public function testMillisecondsToDisplayTimeWithLessThanAMinute()
    {
        $this->assertEquals('00:58.915', Utils::millisecondsToDisplayTime(58915));
    }

    public function testMillisecondsToDisplayTimeWithLessThanAnHour()
    {
        $this->assertEquals('10:21.912', Utils::millisecondsToDisplayTime(621912));
    }

    public function testMillisecondsToDisplayTimeWithOverZeroHours()
    {
        $this->assertEquals('01:00:01.123', Utils::millisecondsToDisplayTime(3601123));
    }

    public function testGetPermutationsWithRepetition()
    {
        $this->assertEquals(
            [
                ['foo', 'foo', 'foo'],
                ['foo', 'foo', 'bar'],
                ['foo', 'bar', 'foo'],
                ['foo', 'bar', 'bar'],
                ['bar', 'foo', 'foo'],
                ['bar', 'foo', 'bar'],
                ['bar', 'bar', 'foo'],
                ['bar', 'bar', 'bar'],
            ],
            Utils::getPermutationsWithRepetition(['foo', 'bar'], 3)
        );
    }

    public function testGetPermutationsWithRepetitionWithLengthOne()
    {
        $this->assertEquals(
            [
                ['foo'],
                ['bar'],
            ],
            Utils::getPermutationsWithRepetition(['foo', 'bar'], 1)
        );
    }

    public function testGetPermutationsWithRepetitionWithLengthZero()
    {
        $this->assertEquals(
            [],
            Utils::getPermutationsWithRepetition(['foo', 'bar'], 0)
        );
    }

    public function testGetPermutationsWithRepetitionWithNegativeLength()
    {
        $this->expectException(InvalidArgumentException::class);
        Utils::getPermutationsWithRepetition(['foo', 'bar'], -1);
    }

    public function testGetPermutationsWithRepetitionWithZeroItems()
    {
        $this->assertEquals(
            [],
            Utils::getPermutationsWithRepetition([], 2)
        );
    }

    public function testGetCombinationsWithoutRepetition()
    {
        $this->assertEquals(
            [
                ['foo', 'bar'],
                ['foo', 'baz'],
                ['foo', 'quux'],
                ['bar', 'baz'],
                ['bar', 'quux'],
                ['baz', 'quux'],
            ],
            Utils::getCombinationsWithoutRepetition(['foo', 'bar', 'baz', 'quux'], 2)
        );
    }

    public function testGetCombinationsWithoutRepetitionWithLengthOne()
    {
        $this->assertEquals(
            [
                ['foo'],
                ['bar'],
                ['baz'],
                ['quux'],
            ],
            Utils::getCombinationsWithoutRepetition(['foo', 'bar', 'baz', 'quux'], 1)
        );
    }

    public function testGetCombinationsWithoutRepetitionWithLengthZero()
    {
        $this->assertEquals(
            [],
            Utils::getCombinationsWithoutRepetition(['foo', 'bar', 'baz', 'quux'], 0)
        );
    }

    public function testGetCombinationsWithoutRepetitionWithNegativeLength()
    {
        $this->expectException(InvalidArgumentException::class);
        Utils::getCombinationsWithoutRepetition(['foo', 'bar', 'baz', 'quux'], -1);
    }

    public function testGetCombinationsWithoutRepetitionWithZeroItems()
    {
        $this->assertEquals(
            [],
            Utils::getCombinationsWithoutRepetition([], 2)
        );
    }
}
