<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\File
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $path
 * @property int|null $file_id
 * @property int $collection_id
 * @property int|null $image_spec_id
 * @property-read \Illuminate\Database\Eloquent\Collection|File[] $childFiles
 * @property-read int|null $child_files_count
 * @property-read \App\Models\Collection $collection
 * @property-read File $parentFile
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
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
        'path',
        'collection_id',
        'file_id',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function path()
    {
        return $this->path.'/'.$this->name;
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'file_id');
    }
}
