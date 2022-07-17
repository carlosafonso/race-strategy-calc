<?php
declare(strict_types=1);

namespace Afonso\Pitstops\Tests;

use Afonso\Pitstops\Utils;
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
}
