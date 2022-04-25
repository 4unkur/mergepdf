<?php

namespace App;

use App\Models\Certificate;
use Exception;
use iio\libmergepdf\Merger;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class CertificatePDFMerger
{
    private Merger $merger;

    public function __construct()
    {
        $this->merger = new Merger();
    }

    public function execute(Certificate $certificate): Media
    {
        $this->addFiles($certificate);

        $mergedFilepath = $this->mergeFiles();

        $file = storage_path("app/$mergedFilepath");

        return $certificate
            ->addMedia($file)
            ->toMediaCollection(Certificate::COLLECTION_COMPLETE_PDF);
    }

    /**
     * Adds files to the merger
     *
     * @param  Certificate  $certificate
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function addFiles(Certificate $certificate): void
    {
        $file = $certificate->getFirstMedia('pdf')->getPath();

        $this->merger->addFile($file);
    }

    /**
     * Generates new merged file
     *
     * @return string path to the merged file
     * @throws Exception
     */
    private function mergeFiles(): string
    {
        $mergedCertificateContents = $this->merger->merge();
        $this->merger->reset(); // clearing the merger from added files
        $filename = Str::random(40).'.pdf';

        $result = Storage::put($filename, $mergedCertificateContents);

        if (!$result) {
            throw new Exception('Unable to merge PDF files');
        }

        return $filename;
    }
}
