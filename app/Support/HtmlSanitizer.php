<?php

namespace App\Support;

class HtmlSanitizer
{
    /**
     * Clean untrusted HTML string to prevent XSS.
     * Removes dangerous executable tags, inline event handlers, and javascript: protocols.
     */
    public static function clean(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // Remove script, iframe, object, embed, style, applet tags and their contents
        $cleaned = preg_replace('#<(script|iframe|object|embed|style|applet)[^>]*>.*?</\1>#is', '', $html);
        $cleaned = preg_replace('#<(script|iframe|object|embed|style|applet)[^>]*>#is', '', $cleaned);

        // Remove inline event handlers (onerror, onload, onclick, onmouseover, etc.)
        $cleaned = preg_replace('#\s+on[a-zA-Z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)#i', '', $cleaned);

        // Disarm javascript:, vbscript:, data: pseudo-protocols on href and src
        $cleaned = preg_replace('#(href|src)\s*=\s*("|\')\s*(javascript|vbscript|data):[^"\']*("|\')#i', '$1="#"', $cleaned);

        return $cleaned;
    }

    /**
     * Clean an array of translatable strings or a single string.
     */
    public static function cleanInput(mixed $input): mixed
    {
        if (is_array($input)) {
            return array_map([self::class, 'cleanInput'], $input);
        }

        if (is_string($input)) {
            return self::clean($input);
        }

        return $input;
    }
}
