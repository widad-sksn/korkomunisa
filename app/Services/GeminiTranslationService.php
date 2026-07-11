<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiTranslationService
{
    /**
     * Translates content using Google Gemini API.
     *
     * @param array $data Associative array of fields to translate (e.g., ['title' => '...', 'content' => '...'])
     * @return array|null Returns the JSON decoded array from Gemini, or null on failure.
     */
    public static function translate(array $data): ?array
    {
        $apiKey = env('GEMINI_API_KEY');
        
        if (empty($apiKey)) {
            Log::error('GeminiTranslationService: GEMINI_API_KEY is not set in .env');
            return null;
        }

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite:generateContent?key=' . $apiKey;

        // Protected terms mentioned by the user
        $protectedTerms = "IMM, Muhammadiyah, Universitas 'Aisyiyah Yogyakarta', Korkom, Komisariat, Darul Arqam, Tanwir, Muktamar, Laravel, PHP, JavaScript, HTML, CSS, Bootstrap, CKEditor, Docker, GitHub, GitLab, MySQL, PostgreSQL, Redis, Queue, Middleware, REST API, API, JWT, OAuth, Ubuntu, Linux, OpenWrt, Proxmox";

        // Building the prompt
        $systemInstruction = "You are a professional translator. Supported languages are: Indonesian (id), English (en), Arabic (ar), Japanese (ja), and Javanese (jv) (Use formal Krama Javanese).\n"
            . "Instructions:\n"
            . "1. Detect the source language of the provided content.\n"
            . "2. Translate the content into the other supported languages.\n"
            . "3. Preserve all HTML tags exactly as they are.\n"
            . "4. Do not translate these protected terms: $protectedTerms. Also do not translate names of people or places.\n"
            . "5. Return JSON only, without markdown code blocks, using this exact format:\n"
            . "{\n"
            . "  \"detected_language\": \"id|en|ar|ja|jv\",\n"
            . "  \"[field_name]\": {\n"
            . "    \"id\": \"...\",\n"
            . "    \"en\": \"...\",\n"
            . "    \"ar\": \"...\",\n"
            . "    \"ja\": \"...\",\n"
            . "    \"jv\": \"...\"\n"
            . "  }\n"
            . "}\n"
            . "The JSON must contain all fields provided in the input.";

        // Convert the input data to JSON for the prompt
        $inputJson = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        
        $prompt = "Please process the following fields:\n" . $inputJson;

        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $systemInstruction]
                ]
            ],
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'response_mime_type' => 'application/json',
                'temperature' => 0.1, // Low temperature for consistent JSON
            ]
        ];

        try {
            $response = Http::timeout(60)->post($url, $payload);

            if ($response->successful()) {
                $result = $response->json();
                
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $jsonText = $result['candidates'][0]['content']['parts'][0]['text'];
                    
                    // Decode the returned JSON
                    $translatedData = json_decode($jsonText, true);
                    
                    if (json_last_error() === JSON_ERROR_NONE) {
                        return $translatedData;
                    } else {
                        Log::error('GeminiTranslationService: Invalid JSON response from Gemini', ['response' => $jsonText]);
                        return null;
                    }
                }
                
                Log::error('GeminiTranslationService: Unexpected response structure', ['response' => $result]);
                return null;
            }

            Log::error('GeminiTranslationService: API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
            return null;

        } catch (\Exception $e) {
            Log::error('GeminiTranslationService: Exception caught', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
