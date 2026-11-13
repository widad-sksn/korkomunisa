<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
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
            if ($lang === $sourceLang) {
                continue;
            }

            if (!empty(trim(strip_tags($data[$lang] ?? '')))) {
                continue;
            }

            try {
                $data[$lang] = self::translateText($sourceText, $lang, $sourceLang);
            } catch (\Throwable $e) {
                Log::warning("AutoTranslationService: failed translating from {$sourceLang} to {$lang}: " . $e->getMessage());
            }
        }

        return $data;
    }

    /**
     * Translates plain text or HTML content safely in blocks.
     */
    public static function translateText(string $text, string $targetLang, string $sourceLang): string
    {
        if (empty(trim(strip_tags($text)))) {
            return $text;
        }

        $targetGoogle = ($targetLang === 'jv') ? 'jw' : $targetLang;
        $sourceGoogle = ($sourceLang === 'jv') ? 'jw' : $sourceLang;

        // If content contains HTML tags, translate inner text of block elements to preserve markup & stay under URL limits
        if ($text !== strip_tags($text)) {
            $pattern = '/(<(p|h[1-6]|li|blockquote|figcaption|div)[^>]*>)(.*?)(<\/\2>)/si';
            if (preg_match($pattern, $text)) {
                return preg_replace_callback($pattern, function ($matches) use ($targetGoogle, $sourceGoogle) {
                    $openTag = $matches[1];
                    $inner = $matches[3];
                    $closeTag = $matches[4];

                    $cleanInner = trim(strip_tags($inner));
                    if (empty($cleanInner)) {
                        return $matches[0];
                    }

                    try {
                        $tr = new GoogleTranslate($targetGoogle, $sourceGoogle);
                        $translated = $tr->translate($cleanInner);
                        return $openTag . $translated . $closeTag;
                    } catch (\Throwable $e) {
                        Log::warning("AutoTranslation chunk error: " . $e->getMessage());
                        return $matches[0];
                    }
                }, $text);
            }
        }

        // Plain text (e.g. title)
        $tr = new GoogleTranslate($targetGoogle, $sourceGoogle);
        return $tr->translate($text);
    }
}
