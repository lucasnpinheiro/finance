<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 */
class Transaction extends Model
{
    protected ?string $table = 'transactions';
    protected array $fillable = ['id', 'value', 'type', 'status', 'created_at', 'description'];
    protected array $casts = [
        'id' => 'string',
    ];

}
