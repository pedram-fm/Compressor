<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class Compressor
{
    public function compressFile($filePath): void
    {
        $zipType = env('ZIP_TYPE', 'zip');
        switch ($zipType) {
            case 'zip':
                $zip = new ZipArchive();
                $zipPath = storage_path('app/compressed-files/' . basename($filePath) . '.zip');
                if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
                    $zip->addFile($filePath, basename($filePath));
                    $zip->close();
                    unlink($filePath);
                }
                break;
            case '7zip':
                $sevenZipPath = storage_path('app/compressed-files/' . basename($filePath) . '.7z');
                $command = '7z a ' . $sevenZipPath . ' ' . $filePath;
                exec($command, $output, $returnCode);
                if ($returnCode === 0) {
                    unlink($filePath);
                }
                break;
            case 'tar.gz':
                $tarGzPath = storage_path('app/compressed-files/' . basename($filePath) . '.tar.gz');
                $command = 'tar -czf ' . $tarGzPath . ' -C ' . dirname($filePath) . ' ' . basename($filePath);
                exec($command, $output, $returnCode);
                if ($returnCode === 0) {
                    unlink($filePath);
                }
                break;
            default:
                break;
        }
    }

}


