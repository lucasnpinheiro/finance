<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 */
class Account extends Model
{
    protected ?string $table = 'accounts';
    protected array $fillable = ['id', 'balance', 'created_at', 'updated_at'];
    protected array $casts = [
        'id' => 'string',
    ];
}
