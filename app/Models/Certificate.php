<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Certificate extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    const COLLECTION_COMPLETE_PDF = 'complete-pdf';

    protected $fillable = ['name'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('pdf')
            ->singleFile();

        $this->addMediaCollection(static::COLLECTION_COMPLETE_PDF)
            ->singleFile();
    }
}
