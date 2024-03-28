<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Common\Core\BaseModel;

class WhiteListedDomain extends BaseModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name'];

    public const MODEL_TYPE = 'whiteListedDomains';

    public function toNormalizedArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'model_type' => self::MODEL_TYPE,
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->timestamp ?? '_null',
        ];
    }

    public static function filterableFields(): array
    {
        return [ 'name'];
    }

    public static function getModelTypeAttribute(): string
    {
        return WhiteListedDomain::MODEL_TYPE;
    }
}
