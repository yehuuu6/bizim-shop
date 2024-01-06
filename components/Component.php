<?php

namespace Components;

/**
 * Component super class
 */
class Component
{
    /**
     * Renders component to the page
     */
    public function render(string $body)
    {
        echo $body;
    }

    /**
     * Converts name to a valid slug.
     * @param string $str The string to convert.
     * @return string
     */
    public function get_slug(?string $str)
    {
        $str = str_replace('_', '-', $str);
        return $str;
    }

    /**
     * Shortens the string to the specified length.
     * @param string $str The string to shorten.
     * @param int $length The length to shorten the string.
     * @return string
     */
    public function shorten_string(string $str, int $length)
    {
        if (strlen($str) > $length) {
            $str = substr($str, 0, $length);
            $last_char = substr($str, -1);
            if ($last_char === ' ') {
                $str = substr($str, 0, -1);
            }
            $str .= '...';
        }
        return $str;
    }
}
