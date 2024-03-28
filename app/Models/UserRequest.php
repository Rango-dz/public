<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Common\Core\BaseModel;

class UserRequest extends BaseModel
{
    protected $table = 'user_requests';

    public const MODEL_TYPE = 'user_request';

    protected $fillable = [
        'title_id',
        'season_no',
        'episode_no',
        'user_id'
    ];

    public function title(): BelongsTo
    {
        return $this->belongsTo(Title::class, 'title_id', 'id');
    }

    public function toNormalizedArray(): array
    {
        return [
            'id' => $this->id,
            'title_id' => $this->title_id,
            'model_type' => self::MODEL_TYPE,
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->title->name,
            'title_id' => $this->title_id,
            'season_no' => $this->season_no,
            'episode_no' => $this->episode_no,
            'created_at' => $this->created_at->timestamp ?? '_null',
        ];
    }

    public static function filterableFields(): array
    {
        return [ 'title_id'];
    }

    public static function getModelTypeAttribute(): string
    {
        return self::MODEL_TYPE;
    }
}
