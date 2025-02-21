<?php

namespace Universe\Timezone;

use Carbon\Carbon;

/**
 * Class Timezone
 *
 * @package Universe\Timezone
 */
class Timezone
{
    /**
     * Convert to Local Timezone.
     *
     * @param Carbon|null $date
     * @param string|null $format
     * @param bool        $formatTimezone
     * @param bool|null   $enableTranslation
     * @return string
     */
    public function convertToLocal(?Carbon $date, ?string $format = null, bool $formatTimezone = false, bool $enableTranslation = null): string
    {
        if (is_null($date)) {
            return __('Empty');
        }

        $timezone = (auth()->user()->timezone) ?? config('app.timezone');

        $enableTranslation = (bool)($enableTranslation !== null ? $enableTranslation : config('timezone.enable_translation'));

        $date->setTimezone($timezone);

        if (is_null($format)) {
            return $enableTranslation ? $date->translatedFormat(config('timezone.format')) : $date->format(config('timezone.format'));
        }

        $formattedDateTime = $enableTranslation ? $date->translatedFormat($format) : $date->format($format);

        if ($formatTimezone) {
            return $formattedDateTime.' '.$this->formatTimezone($date);
        }

        return $formattedDateTime;
    }

    /**
     * Convert from Local Timezone.
     *
     * @param $date
     * @return \Carbon\Carbon
     */
    public function convertFromLocal($date): Carbon
    {
        return Carbon::parse($date, auth()->user()->timezone)->setTimezone('UTC');
    }

    /**
     * Format Timezone.
     *
     * @param \Carbon\Carbon $date
     * @return string
     */
    private function formatTimezone(Carbon $date): string
    {
        $timezone = $date->format('e');
        $parts = explode('/', $timezone);

        if (count($parts) > 1) {
            return str_replace('_', ' ', $parts[1]).', '.$parts[0];
        }

        return str_replace('_', ' ', $parts[0]);
    }
}
