<?php

namespace App\Factory;
use http\Exception\InvalidArgumentException;

class Image extends \Faker\Provider\Base
{
    public const BASE_URL = 'https://loremflickr.com/';

    public const FORMAT_JPG = 'jpg';
    public const FORMAT_JPEG = 'jpeg';
    public const FORMAT_PNG = 'png';

    /**
     * @var array
     */
    protected static $categories = [
        'Авангардная литература' => 'avant-garde',
        'Боевик' => 'militant',
        'Детектив' => 'detective',
        'Исторический роман' => 'historical',
        'Любовный роман' => 'love',
        'Научная фантастика' => 'science',
        'Приключения' => 'adventures',
        'Триллер/ужасы' => 'horror',
        'Драма' => 'drama',
        'Фантастика' => 'fiction',
        'Фэнтези' => 'fantasy',
        'Сказка' => 'cartoon',
        'Поэзия' => 'poetry'
    ];

    /**
     * Generate the URL that will return a random image
     *
     * Set randomize to false to remove the random GET parameter at the end of the url.
     *
     * @example 'http://via.placeholder.com/640x480.png/CCCCCC?text=well+hi+there'
     *
     * @param int         $width
     * @param int         $height
     * @param string|null $category
     * @param bool        $randomize
     * @param string|null $word
     * @param bool        $gray
     * @param string      $format
     *
     * @return string
     */
    public static function imageUrl(
        $width = 640,
        $height = 480,
        $category = null,
        $randomize = true,
        $word = null,
        $gray = false,
        $format = 'png'
    ) {
        $url = "{$width}/{$height}";
        $queryParams = [];

        if ($category && !$word) {
            $word = static::$categories[$category];
        }

        if ($randomize) {
            $queryParams['random'] = 1;
        }

        return sprintf("%s%s%s%s?%s",
            self::BASE_URL,
            ($gray ? '/g' : ''),
            $url,
            ($word ? '/' . $word : ''),
            http_build_query($queryParams)
        );
    }

    /**
     * Download a remote random image to disk and return its location
     *
     * Requires curl, or allow_url_fopen to be on in php.ini.
     *
     * @example '/path/to/dir/13b73edae8443990be1aa8f1a483bc27.png'
     *
     * @return bool|string
     */
    public static function image(
        $dir = null,
        $width = 640,
        $height = 480,
        $category = null,
        $fullPath = true,
        $randomize = true,
        $word = null,
        $gray = false,
        $format = 'png'
    ) {
        $dir = null === $dir ? sys_get_temp_dir() : $dir; // GNU/Linux / OS X / Windows compatible
        // Validate directory path
        if (!is_dir($dir) || !is_writable($dir)) {
            throw new \InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
        }

        // Generate a random filename. Use the server address so that a file
        // generated at the same time on a different server won't have a collision.
        $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
        $filename = sprintf('%s.%s', $name, $format);
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        $url = static::imageUrl($width, $height, $category, $randomize, $word, $gray, $format);

        $result = file_put_contents($filepath, file_get_contents($url));

        if (!$result) return false;

        return $fullPath ? $filepath : $filename;
    }

    public static function getFormats(): array
    {
        return array_keys(static::getFormatConstants());
    }

    public static function getFormatConstants(): array
    {
        return [
            static::FORMAT_JPG => constant('IMAGETYPE_JPEG'),
            static::FORMAT_JPEG => constant('IMAGETYPE_JPEG'),
            static::FORMAT_PNG => constant('IMAGETYPE_PNG'),
        ];
    }
}
