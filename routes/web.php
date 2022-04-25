<?php

use App\Models\Certificate;
use Illuminate\Support\Facades\Route;
use App\CertificatePDFMerger;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (CertificagtePDFMerger $merger) {
    /** @var Certificate $certificate */
    $certificate = Certificate::first();

    $media = $merger->execute($certificate);

    $media2 = $certificate->getFirstMedia(Certificate::COLLECTION_COMPLETE_PDF);

    $media3 = Media::query()
        ->where('model_type', Certificate::class)
        ->where('model_id', $certificate->id)
        ->where('collection_name', Certificate::COLLECTION_COMPLETE_PDF)
        ->latest()
        ->first();

    dd(
        $media?->id,
        $media2?->id,
        $media3?->id
    );
});
