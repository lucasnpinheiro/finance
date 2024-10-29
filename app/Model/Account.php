<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 */
class Account extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'accounts';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = ['id', 'balance', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];
}
