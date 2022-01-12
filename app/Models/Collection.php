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
 * @property int $webp
 * @property-read \Illuminate\Database\Eloquent\Collection|Collection[] $childrenCollections
 * @property-read int|null $children_collections_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereWebp($value)
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
