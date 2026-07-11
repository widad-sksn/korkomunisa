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
        if ($this->model->translation_status === 'completed' && !$this->force) {
            return;
        }

        // Set to processing
        $this->model->translation_status = 'processing';
        $this->model->saveQuietly();

        // Define fields to translate based on model type
        $fields = [];
        if ($this->model instanceof \App\Models\Article) {
            $fields = ['title', 'content'];
        } elseif ($this->model instanceof \App\Models\Portfolio) {
            $fields = ['title', 'description'];
        } elseif ($this->model instanceof \App\Models\AboutImm) {
            $fields = ['title', 'content'];
        }

        $dataToTranslate = [];
        foreach ($fields as $field) {
            // Get raw fallback or default locale content
            // Assuming the author writes in one language, we take the original or current set value
            $translations = $this->model->getTranslations($field);
            
            // We just send the first available translation or a combined array to Gemini
            // Actually, the user asked to send something like:
            // "title": {"id": "...", "en": "", "ar": ""}
            // so Gemini can detect the source and fill the rest.
            
            // Ensure array has all 3 keys
            $dataToTranslate[$field] = [
                'id' => $translations['id'] ?? '',
                'en' => $translations['en'] ?? '',
                'ar' => $translations['ar'] ?? '',
            ];
            
            // If they wrote only in one language, they might have saved it as default (which Spatie maps to 'id' by default)
            // But let's say they wrote in English and their UI was set to 'en', it might be in 'en'.
            // In either case, we pass whatever we have.
        }

        $translatedResponse = GeminiTranslationService::translate($dataToTranslate);

        if ($translatedResponse) {
            // Success
            $this->model->original_language = $translatedResponse['detected_language'] ?? 'id';
            
            foreach ($fields as $field) {
                if (isset($translatedResponse[$field]) && is_array($translatedResponse[$field])) {
                    // Update field with all translations
                    $this->model->$field = $translatedResponse[$field];
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
            
            // Re-throw so it goes to failed_jobs table and can be retried automatically?
            // Actually, the user asked "Jika gagal... Tampilkan status: Translation Failed. Sediakan tombol: 🔄 Retry Translation"
            // So we just mark as failed and don't re-throw to avoid spamming the worker.
        }
    }
}
