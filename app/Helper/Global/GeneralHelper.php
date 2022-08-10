<?php

if (! function_exists('convertEncoding')) {
    /**
     * Convert data from first language to second language
     *
     * @param array  $items        Array
     * @param string $toEncoding   to encoding
     * @param string $fromEncoding from encoding
     *
     * @return array
     */
    function convertEncoding($items, $toEncoding = 'SJIS-win', $fromEncoding = 'UTF-8')
    {
        $newItem = array();
        foreach ($items as $item) {
            $newItem[] = mb_convert_encoding($item, $toEncoding, $fromEncoding);
        }
        return $newItem;
    }
}

if (! function_exists('parseDateString')) {
    /**
     * parseDateString
     *
     * @return string
     */
    function parseDateString($date)
    {
        if ($date) {
            return date(config('define.format.display.date'), strtotime($date));
        } else {
            return '';
        }
    }

    if (!function_exists('formatDate')) {
        /**
         * formatDate
         *
         * @return string
         */
        function formatDate($date)
        {
            if (!$date) {
                return '';
            }
    
            return Carbon::parse($date)->format(config('define.format.default.date'));
        }
    }
}