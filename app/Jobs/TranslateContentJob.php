<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\AutoTranslationService;
use Illuminate\Database\Eloquent\Model;

class TranslateContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $model;

    /**
     * Create a new job instance.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
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
            $fields = ['content'];
        }

        $needsSave = false;
        foreach ($fields as $field) {
            $translations = $this->model->getTranslations($field);
            $translated = AutoTranslationService::translateArray($translations);
            
            // Check if there was any actual change
            if (json_encode($translations) !== json_encode($translated)) {
                $this->model->$field = $translated;
                $needsSave = true;
            }
        }

        if ($needsSave) {
            // Save without touching timestamps to avoid redundant updates
            $this->model->saveQuietly();
        }
    }
}
