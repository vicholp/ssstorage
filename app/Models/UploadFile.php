<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UploadFile
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $upload_id
 * @property int|null $file_id
 * @property string $filename
 * @property string $result
 * @property-read \App\Models\File|null $file
 * @property-read \App\Models\Upload $upload
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadFile whereUploadId($value)
 * @mixin \Eloquent
 */
class UploadFile extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'result',
        'filename',
    ];
    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
