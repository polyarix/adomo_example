<?php

namespace App\Service\User\Common;

use Carbon\Carbon;

class DatesDuration
{
    protected $years;
    protected $months;
    protected $weeks;
    protected $days;
    protected $hours;
    protected $minutes;
    protected $seconds;

    public function getFullYears()
    {
        return $this->years;
    }
    public function getFullMonths()
    {
        if($this->getFullYears() > 0) {
            return floor($this->months % 12);
        }
        return $this->months;
    }
    public function getFullDays()
    {
        return floor($this->days / 365);
    }
    public function getFullHours()
    {
        return $this->hours > 23 ? floor($this->hours / 24) : $this->hours;
    }
    public function getFullMinutes()
    {
        return $this->minutes % 60;
    }
    public function getFullSeconds()
    {
        if($this->getFullDays() > 0) {
            return floor($this->seconds / 3600);
        }
        return $this->seconds;
    }
    public function getReadable()
    {
        if($this->getFullYears() > 0) {
            $months = $this->getFullMonths();

            $response = sprintf('%d %s', $this->getFullYears(), num_decline($this->getFullYears(), ['год', 'года', 'лет']));
            if($months > 0) {
                $response .= sprintf(' и %d %s', $this->getFullMonths(), num_decline($this->getFullMonths(), ['месяц', 'месяца', 'месяцев']));
            }

            return $response;
        }
        if($this->getFullMonths() > 0) {
            $response = sprintf('%d %s', $this->getFullMonths(), num_decline($this->getFullMonths(), ['месяц', 'месяца', 'месяцев']));

            $days = floor($this->days) % 30;

            if($days > 0) {
                $response .= sprintf(' и %d %s', $days, num_decline($days, ['день', 'дня', 'дней']));
            }

            return $response;
        }
        if($this->days > 0) {
            $days = $this->hours % 24;
            $hours = $this->hours % $days;

            $response = sprintf('%d %s', $days, num_decline($days, ['день', 'дня', 'дней']));

            if($hours > 0) {
                $response .= sprintf(' и %d %s', $hours, num_decline($hours, ['час', 'часа', 'часов']));
            }

            return $response;
        }
        if($this->getFullHours() > 0 && $this->getFullMinutes() > 0) {
            return sprintf('%d %s и %d %s',
                $this->getFullHours(), num_decline($this->getFullHours(), ['час', 'часа', 'часов']),
                $this->getFullMinutes(), num_decline($this->getFullMinutes(), ['минуту', 'минуты', 'минут'])
            );
        }
        if($this->getFullMinutes() > 0) {
            $seconds = $this->getFullSeconds() % 60;
            return sprintf('%d %s и %d %s',
                $this->getFullMinutes(), num_decline($this->getFullMinutes(), ['минуту', 'минуты', 'минут']),
                $seconds, num_decline($seconds, ['секунду', 'секунды', 'секунд'])
            );
        }
        return sprintf('%d %s', $this->getFullSeconds(), num_decline($this->getFullSeconds(), ['секунду', 'секунды', 'секунд']));
    }

    public static function getDuration(Carbon $from, ?Carbon $to = null): string
    {
        if(!$to) {
            $to = Carbon::now();
        }

        return self::humanTiming($from, $to)->getReadable();
    }

    public static function getTokens(): array
    {
        return [
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];
    }

    public static function humanTiming(Carbon $from, ?Carbon $to = null)
    {
        if(!$to) {
            $to = Carbon::now();
        }

        $time = $to->timestamp - $from->timestamp; // to get the time since that moment
        $time = $time < 1 ? 1 : $time;

        $inc = new static();

        foreach (static::getTokens() as $unit => $text) {
            //if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);

            $text .= 's';
            $inc->{$text} = $numberOfUnits;
        }

        return $inc;
    }
}
