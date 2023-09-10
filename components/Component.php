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
    public function render(String $body)
    {
        echo $body;
    }

    public function shorten_string(string $str, int $length)
    {
        if (strlen($str) > $length) {
            $str = substr($str, 0, $length) . '...';
        }
        return $str;
    }
}
