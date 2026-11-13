<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class AutoTranslationService
{
    /**
     * Translates missing keys (id, en, ar, ja, jv) using available source text.
     */
    public static function translateArray(array $data): array
    {
        $supported = ['id', 'en', 'ar', 'ja', 'jv'];

        // Find primary non-empty source
        $sourceLang = 'id';
        $sourceText = '';
        foreach ($supported as $lang) {
            $val = $data[$lang] ?? '';
            if (!empty(trim(strip_tags($val)))) {
                $sourceLang = $lang;
                $sourceText = $val;
                break;
            }
        }

        if (empty(trim(strip_tags($sourceText)))) {
            return $data;
        }

        // ponytail: free google translate lacks custom glossary/terms protection. Use Gemini for nuanced translations.
        foreach ($supported as $lang) {
            if ($lang === $sourceLang || !empty(trim(strip_tags($data[$lang] ?? '')))) {
                continue;
            }
            try {
                $tr = new GoogleTranslate($lang, $sourceLang);
                $data[$lang] = $tr->translate($sourceText);
            } catch (\Throwable $e) {
                // Ignore failure on single locale
            }
        }

        return $data;
    }
}
