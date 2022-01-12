<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Collection
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $slug
 * @property string $path
 * @property int|null $collection_id
 * @property-read \Illuminate\Database\Eloquent\Collection|Collection[] $childrenCollections
 * @property-read int|null $children_collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ImageSpec[] $imageSpecs
 * @property-read int|null $image_specs_count
 * @property-read Collection|null $parentCollection
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Collection extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'path',
        'collection_id',
    ];

    public function parentCollection()
    {
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function childrenCollections()
    {
        return $this->hasMany(Collection::class, 'collection_id');
    }

    public function imageSpecs()
    {
        return $this->hasMany(ImageSpec::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function getUrl()
    {
        if ($this->parentCollection) {
            $collection = [...$this->parentCollection->getUrl(), $this->slug];
            return $collection;
        }
        return [$this->slug];
    }

    public function getAncestors()
    {
        if ($this->parentCollection) {
            $collection = [$this, ...$this->parentCollection->getAncestors()];
            return $collection;
        }
        return [$this];
    }

    public function getPath()
    {
        $path = "";

        if ($this->parentCollection) {
            $path .= $this->parentCollection->getPath().'/';
        }

        $path .= $this->path;
        return $path;
    }
}
