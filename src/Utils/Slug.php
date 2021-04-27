<?php declare(strict_types=1);


namespace App\Utils;

/**
 * todo: in future use this --> vendor/symfony/string/Slugger/SluggerInterface.php
 */
final class Slug
{
    /**
     * @param string $text
     *
     * @return string
     */
    public static function create(string $text): string
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            $text = self::generateRandomString();
        }

        return $text;
    }

    private static function generateRandomString(int $length = 32): string
    {

        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
