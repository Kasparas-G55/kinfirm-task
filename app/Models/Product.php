<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

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

    public static function productPopularTags() {
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

    public static function relatedProducts(string $sku) {
        return DB::select("
            SELECT DISTINCT p2.photo, p2.sku
            FROM products p1
            JOIN json_each(p1.tags) AS tag1
            JOIN products p2
            JOIN json_each(p2.tags) AS tag2
                ON tag1.value = tag2.value
            WHERE p1.sku = ? AND p2.product_id != p1.product_id
        ", [$sku]);
    }

    public $timestamps = false;
}
