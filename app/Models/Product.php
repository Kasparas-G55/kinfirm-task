<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku',
        'description',
        'size',
        'photo',
        'tags',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'product_id',
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'sku', 'sku');
    }

    public static function tags() {
        return DB::select("
            SELECT title, COUNT(*) as count
            FROM (
                SELECT json_extract(value, '$.title') as title
                FROM products, json_each(products.tags)
            )
            WHERE title IS NOT NULL
            GROUP BY title
            ORDER BY count DESC
        ");
    }

    public $timestamps = false;
}
