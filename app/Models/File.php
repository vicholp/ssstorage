<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\File
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $extension
 * @property string $path
 * @property int|null $file_id
 * @property int $collection_id
 * @property int|null $image_spec_id
 * @property-read \App\Models\Collection $collection
 * @property-read File|null $file
 * @property-read \Illuminate\Database\Eloquent\Collection|File[] $files
 * @property-read int|null $files_count
 * @property-read \App\Models\ImageSpec|null $imageSpec
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereImageSpecId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class File extends Model
{
    protected $fillable = [
        'name',
        'extension',
        'path',
        'collection_id',
        'file_id',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function getRelativePath()
    {
        return "{$this->path}/{$this->name}.{$this->extension}";
    }

    public function getAbsolutePath()
    {
        return Storage::path($this->getRelativePath());
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'file_id');
    }

    public function getUrl()
    {
        return implode('/', $this->collection->getUrl()).'/'.$this->name.'.'.$this->extension;

    }

    public function imageSpec()
    {
        return $this->belongsTo(ImageSpec::class);
    }
}
