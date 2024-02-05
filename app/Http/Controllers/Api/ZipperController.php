<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Compressor;
use App\Http\Controllers\Controller;
use App\Jobs\CompressFileJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ZipperController extends Controller
{
    public function upload(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->storeAs('app_files', $file->getClientOriginalName(), 'local');
            $fullPath = Storage::disk('local')->path($filePath);

            dispatch(new CompressFileJob($fullPath));

            $downloadLink = $file->getClientOriginalName() . '.' . env('ZIP_TYPE', 'zip');

            return response()->json([
                'message' => 'File compression completed',
                'download_link' => route('file.download', ['file_path' => $downloadLink]),
            ], 200);

        } else {
            return response()->json(['message' => 'No file uploaded'], 400);
        }
    }

    public function download($filePath): \Symfony\Component\HttpFoundation\BinaryFileResponse|string
    {
        $fullPath = Storage::disk('compressed-files')->path($filePath);

        if (file_exists($fullPath)) {
            return response()->download($fullPath);
        } else {
            return "File not found";
        }
    }

}
