<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ImageSpec
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $collection_id
 * @property int|null $height
 * @property int|null $width
 * @property int $quality
 * @property-read \App\Models\Collection|null $collections
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec query()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageSpec whereWidth($value)
 * @mixin \Eloquent
 */
class ImageSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'height',
        'width',
    ];

    public function collections()
    {
        return $this->belongsTo(Collection::class);
    }
}
