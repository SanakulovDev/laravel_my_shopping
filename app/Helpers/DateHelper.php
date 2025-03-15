<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Format date to specified format
     * 
     * @param string|null $date The date to format
     * @param string $format The format to use
     * @param string|null $defaultText Text to show if date is null
     * @return string The formatted date
     */
    public static function format($date, $format = 'd.m.Y', $defaultText = '-')
    {
        if (empty($date)) {
            return $defaultText;
        }
        
        return Carbon::parse($date)->format($format);
    }

    /**
     * Format date with time
     * 
     * @param string|null $date The date to format
     * @param string|null $defaultText Text to show if date is null
     * @return string The formatted date with time
     */
    public static function formatWithTime($date, $defaultText = '-')
    {
        return self::format($date, 'd.m.Y H:i', $defaultText);
    }

    /**
     * Format date to human readable format (e.g. "2 days ago")
     * 
     * @param string|null $date The date to format
     * @param string|null $defaultText Text to show if date is null
     * @return string The formatted date
     */
    public static function diffForHumans($date, $defaultText = '-')
    {
        if (empty($date)) {
            return $defaultText;
        }
        
        return Carbon::parse($date)->diffForHumans();
    }
}