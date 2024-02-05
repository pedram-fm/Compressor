<?php

namespace App\Jobs;

use App\Helpers\Compressor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CompressFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle(): void
    {
        try {
            app(Compressor::class)->compressFile($this->file);
        } catch (\Exception $e) {
            Log::error("Compression failed: " . $e->getMessage());
            // Handle exceptions
        }
    }
}
