<?php

class NumberToWords {
    private static $languages = [
        'fa' => [
            'units' => ['', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه'],
            'teens' => ['ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده'],
            'tens' => ['', '', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود'],
            'hundreds' => ['', 'یکصد', 'دویست', 'سیصد', 'چهارصد', 'پانصد', 'ششصد', 'هفتصد', 'هشتصد', 'نهصد'],
            'thousands' => ['', 'هزار', 'میلیون', 'میلیارد']
        ],
        'en' => [
            'units' => ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'],
            'teens' => ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'],
            'tens' => ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'],
            'hundreds' => ['', 'one hundred', 'two hundred', 'three hundred', 'four hundred', 'five hundred', 'six hundred', 'seven hundred', 'eight hundred', 'nine hundred'],
            'thousands' => ['', 'thousand', 'million', 'billion']
        ]
    ];

    public static function convert($number, $lang = 'fa') {
        if (!isset(self::$languages[$lang])) return 'Language not supported';
        if ($number == 0) return $lang === 'fa' ? 'صفر' : 'zero';
        
        $dict = self::$languages[$lang];
        $number = (string) $number;
        $parts = str_split(strrev($number), 3);
        $words = [];
        
        foreach ($parts as $index => $part) {
            $part = strrev($part);
            $words[] = self::convertThreeDigits((int)$part, $dict) . ' ' . ($dict['thousands'][$index] ?? '');
        }
        
        return implode(' و ', array_filter(array_reverse($words)));
    }

    private static function convertThreeDigits($number, $dict) {
        $words = [];
        
        if ($number >= 100) {
            $words[] = $dict['hundreds'][(int)($number / 100)];
            $number %= 100;
        }
        
        if ($number >= 10 && $number <= 19) {
            $words[] = $dict['teens'][$number - 10];
        } elseif ($number >= 20) {
            $words[] = $dict['tens'][(int)($number / 10)];
            $number %= 10;
        }
        
        if ($number > 0) {
            $words[] = $dict['units'][$number];
        }
        
        return implode(' و ', array_filter($words));
    }
}
