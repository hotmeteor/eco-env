<?php

namespace Eco;

class Env
{
    /**
     * Check if .env has a variable by key.
     *
     * @param $file
     * @param $key
     */
    public static function has($file, $key): bool
    {
        $key = strtoupper(trim($key));

        if (file_exists($file)) {
            $lines = explode(PHP_EOL, file_get_contents($file));

            foreach ($lines as $line) {
                if (substr($line, 0, strlen($key)) === $key) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get an .env variable by key.
     *
     * @param $file
     * @param $key
     * @return string
     */
    public static function get($file, $key)
    {
        $key = strtoupper(trim($key));

        if (file_exists($file)) {
            $lines = explode(PHP_EOL, file_get_contents($file));

            foreach ($lines as $line) {
                if (substr($line, 0, strlen($key)) === $key) {
                    return $line;
                }
            }
        }

        return null;
    }

    /**
     * Set an .env variable by key.
     *
     * @param $file
     * @param $key
     * @param $value
     */
    public static function set($file, $key, $value): void
    {
        if (!file_exists($file)) {
            file_put_contents($file, null);
        }

        $key = strtoupper(trim($key));

        $setting = $key.'='.self::formatValue($value).PHP_EOL;

        $temp_file = "{$file}.tmp";

        $reading = fopen($file, 'r');
        $writing = fopen($temp_file, 'w');

        $replaced = false;

        while (!feof($reading)) {
            $line = fgets($reading);
            if (substr($line, 0, strlen($key)) === $key) {
                $line = $setting;
                $replaced = true;
            }

            fputs($writing, $line);
        }

        fclose($reading);
        fclose($writing);

        if (!$replaced) {
            file_put_contents($temp_file, $setting, FILE_APPEND);
        }

        rename($temp_file, $file);
    }

    /**
     * Unset an .env variable by key.
     *
     * @param $file
     * @param $key
     */
    public static function unset($file, $key): void
    {
        if (!file_exists($file)) {
            return;
        }

        $key = strtoupper(trim($key));

        $temp_file = "{$file}.tmp";

        $reading = fopen($file, 'r');
        $writing = fopen($temp_file, 'w');

        $replaced = false;

        while (!feof($reading)) {
            $line = fgets($reading);
            if (substr($line, 0, strlen($key)) === $key) {
                $line = '';
                $replaced = true;
            }

            fputs($writing, $line);
        }

        fclose($reading);
        fclose($writing);

        if (!$replaced) {
            unlink($temp_file);
        } else {
            rename($temp_file, $file);
        }
    }

    /**
     * Format an .env key name.
     *
     * @param $value
     * @return string
     */
    public static function formatValue($value)
    {
        $value = trim($value);

        if (str_contains($value, ' ')) {
            $value = "'".$value."'";
        }

        return $value;
    }
}
