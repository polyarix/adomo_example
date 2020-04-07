<?php

namespace Tests\Unit\User\Details;

use App\Service\User\Common\DatesDuration;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationDurationTest extends TestCase
{
    /** @var Carbon */
    protected $now;

    public function setUp(): void
    {
        parent::setUp();

        $this->now = Carbon::now();
    }

    public function testNowRegistrationDate()
    {
        $registered = Carbon::now();
        $data = DatesDuration::humanTiming($registered, $this->now);

        $this->assertEquals(0, $data->getFullYears());
        $this->assertEquals(0, $data->getFullMonths());
        $this->assertEquals(0, $data->getFullMinutes());
        $this->assertEquals(0, $data->getFullDays());
        $this->assertEquals(1, $data->getFullSeconds());
        $this->assertEquals('1 секунду', $data->getReadable());

        $data = DatesDuration::humanTiming($registered->subSeconds(5), $this->now);
        $this->assertEquals('5 секунд', $data->getReadable());

        $data = DatesDuration::humanTiming($registered->subSeconds(17), $this->now);
        $this->assertEquals('22 секунды', $data->getReadable());
    }

    public function testHoursRegistrationDate()
    {
        $registered = Carbon::now()->subMinutes(5)->subHours(10);
        $data = DatesDuration::humanTiming($registered, $this->now);

        $this->assertEquals(10, $data->getFullHours());
        $this->assertEquals(5, $data->getFullMinutes());
        $this->assertEquals(0, $data->getFullDays());
        $this->assertEquals('10 часов и 5 минут', $data->getReadable());

        $data = DatesDuration::humanTiming($registered->subHours(1), $this->now);
        $this->assertEquals('11 часов и 5 минут', $data->getReadable());

        $data = DatesDuration::humanTiming($registered->subHours(13), $this->now);
        $this->assertEquals('1 час и 5 минут', $data->getReadable());
    }

    public function testMonthsRegistrationDate()
    {
        $registered = Carbon::now()->subDay()->subMonths(4);

        $data = DatesDuration::humanTiming($registered, $this->now);

        $this->assertEquals(4, $data->getFullMonths());
        $this->assertEquals('4 месяца', $data->getReadable());

        $data = DatesDuration::humanTiming($registered->subYears(1), $this->now);

        $this->assertEquals(4, $data->getFullMonths());
        $this->assertEquals(1, $data->getFullYears());
        $this->assertEquals('1 год и 4 месяца', $data->getReadable());

        $data = DatesDuration::humanTiming($registered->addMonths(4), $this->now);
        $this->assertEquals('1 год', $data->getReadable());
    }

    public function testYearRegistrationDate()
    {
        $registered = Carbon::now()->subDay()->subYears(4);

        $data = DatesDuration::humanTiming($registered, $this->now);

        $this->assertEquals(4, $data->getFullYears());
        $this->assertEquals('4 года', $data->getReadable());
    }

    public function testOneDayRegistrationDate()
    {
        $registered = Carbon::now();
        $data = DatesDuration::humanTiming($registered, $this->now);

        $this->assertEquals(0, $data->getFullYears());
        $this->assertEquals(0, $data->getFullMonths());
        $this->assertEquals(0, $data->getFullMinutes());
        $this->assertEquals(1, $data->getFullSeconds());
        $this->assertEquals('1 секунду', $data->getReadable());
    }
}
