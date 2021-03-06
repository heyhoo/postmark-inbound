<?php

namespace Mvdnbrk\Postmark\Support;

use DateTime;

/**
 * This file is part of the Postmark Inbound package.
 *
 * @property-read string $timezone
 * @property-read bool $isUtc
 */
class PostmarkDate extends DateTime
{
    /**
     *  Constants for numeric representation of the day of the week.
     */
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;

    /**
     * Textual representation of a day, three letters.
     *
     * @var array
     */
    protected static $days_abbreviated = [
        self::SUNDAY => 'Sun',
        self::MONDAY => 'Mon',
        self::TUESDAY => 'Tue',
        self::WEDNESDAY => 'Wed',
        self::THURSDAY => 'Thu',
        self::FRIDAY => 'Fri',
        self::SATURDAY => 'Sat',
    ];

    /**
     * Get the textual respresentation of a day as three letters.
     *
     * @return array
     */
    public static function getAbbreviatedDays()
    {
        return static::$days_abbreviated;
    }

    /**
     * Get a collection of the textual respresentation of a day as three letters.
     *
     * @return \Mvdnbrk\Postmark\Support\Collection
     */
    public static function getAbbreviatedDaysCollection()
    {
        return collect(static::getAbbreviatedDays());
    }

    /**
     * Set the instance to UTC timezone.
     *
     * @return static
     */
    public function inUtcTimezone()
    {
        return parent::setTimezone(timezone_open('UTC'));
    }

    /**
     * Create a new instance from a string.
     *
     * @param  string $date
     * @return static
     */
    public static function parse($date)
    {
        try {
            return new static(
                collect(explode(' ', $date))
                ->reject(function ($value) {
                    return self::getAbbreviatedDaysCollection()->contains(trim($value, ','));
                })
                ->take(5)
                ->implode(' ')
            );
        } catch (\Exception $e) {
            //
        }

        return new static();
    }

    /**
     * Dynamically retrieve attributes on the data model.
     *
     * @param  string  $key
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function __get($key)
    {
        switch (true) {
            case $key === 'isUtc':
                return $this->getOffset() === 0;
            case $key === 'timezone':
                return $this->getTimezone()->getName();
            default:
                throw new \InvalidArgumentException(sprintf("Unknown getter '%s'", $key));
        }
    }
}
