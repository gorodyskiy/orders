<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attribute that allows|forbids timestams.
     * 
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_name',
        'amount',
        'status_id',
    ];

    /**
     * The attributes that should be hidden.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The model's default values for attributes.
     * 
     * @var array<string, mixed>
     */
    protected $attributes = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
        ];
    }

    /**
     * Order's status.
     * 
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(
            Status::class
        );
    }

    /**
     * Orders's user.
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

    /**
     * 
     * 
     * @param Builder $query
     * @return Builder
     */
    public function scopeByUser(Builder $query): Builder
    { 
        return $query->where('user_id', auth()->user()->id);
    }
}
