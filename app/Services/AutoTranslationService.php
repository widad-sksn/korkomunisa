<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class AutoTranslationService
{
    /**
     * Automatically translates missing 'en' and 'ar' keys based on the 'id' key.
     *
     * @param array $data The translation array (e.g., ['id' => '...', 'en' => '...', 'ar' => '...'])
     * @return array
     */
    public static function translateArray(array $data): array
    {
        $idText = $data['id'] ?? '';
        
        // If Indonesian text is empty, nothing to translate
        if (empty(trim(strip_tags($idText)))) {
            return $data;
        }

        // Translate to English if empty
        if (empty(trim(strip_tags($data['en'] ?? '')))) {
            try {
                $tr = new GoogleTranslate('en', 'id');
                // preserve html tags if any
                $data['en'] = $tr->translate($idText);
            } catch (\Exception $e) {
                // Ignore errors (fallback to empty or whatever was there)
            }
        }

        // Translate to Arabic if empty
        if (empty(trim(strip_tags($data['ar'] ?? '')))) {
            try {
                $tr = new GoogleTranslate('ar', 'id');
                $data['ar'] = $tr->translate($idText);
            } catch (\Exception $e) {
                // Ignore errors
            }
        }

        return $data;
    }
}
