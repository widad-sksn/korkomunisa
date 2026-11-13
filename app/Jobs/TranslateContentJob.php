<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\GeminiTranslationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TranslateContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model;
    public $force;
    public $timeout = 300; // Allow up to 5 minutes for long translations

    /**
     * Create a new job instance.
     * @param bool $force If true, it forces translation even if it was already completed.
     */
    public function __construct(Model $model, bool $force = false)
    {
        $this->model = $model;
        $this->force = $force;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Define fields to translate based on model type
        $fields = [];
        if ($this->model instanceof \App\Models\Article) {
            $fields = ['title', 'content'];
        } elseif ($this->model instanceof \App\Models\Portfolio) {
            $fields = ['title', 'description'];
        } elseif ($this->model instanceof \App\Models\AboutImm) {
            $fields = ['title', 'content'];
        }

        $hasMissingTranslations = false;
        foreach ($fields as $field) {
            $existing = $this->model->getTranslations($field);
            foreach (['en', 'ar', 'ja', 'jv'] as $loc) {
                if (empty(trim(strip_tags($existing[$loc] ?? '')))) {
                    $hasMissingTranslations = true;
                    break 2;
                }
            }
        }

        if ($this->model->translation_status === 'completed' && !$this->force && !$hasMissingTranslations) {
            return;
        }

        // Set to processing
        $this->model->translation_status = 'processing';
        $this->model->saveQuietly();

        $dataToTranslate = [];
        foreach ($fields as $field) {
            $translations = $this->model->getTranslations($field);
            
            $dataToTranslate[$field] = [
                'id' => $translations['id'] ?? '',
                'en' => $translations['en'] ?? '',
                'ar' => $translations['ar'] ?? '',
                'ja' => $translations['ja'] ?? '',
                'jv' => $translations['jv'] ?? '',
            ];
        }

        $translatedResponse = GeminiTranslationService::translate($dataToTranslate);

        // Fallback to free Google Translate if Gemini fails or quota exceeded
        if (!$translatedResponse) {
            Log::warning('TranslateContentJob: Gemini failed, fallback to AutoTranslationService for model: ' . get_class($this->model) . ' ID: ' . $this->model->id);
            $translatedResponse = ['detected_language' => $this->model->original_language ?? 'id'];
            foreach ($fields as $field) {
                $translatedResponse[$field] = \App\Services\AutoTranslationService::translateArray($dataToTranslate[$field] ?? []);
            }
        }

        if ($translatedResponse) {
            // Success
            $this->model->original_language = $translatedResponse['detected_language'] ?? 'id';
            
            foreach ($fields as $field) {
                if (isset($translatedResponse[$field]) && is_array($translatedResponse[$field])) {
                    // Update field with all translations
                    $this->model->setTranslations($field, $translatedResponse[$field]);
                }
            }
            
            $this->model->translation_status = 'completed';
            $this->model->translated_at = now();
            
            $this->model->saveQuietly();
        } else {
            // Failed
            $this->model->translation_status = 'failed';
            $this->model->saveQuietly();
            
            Log::error('TranslateContentJob failed for model: ' . get_class($this->model) . ' ID: ' . $this->model->id);
        }
    }
}
