<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReimbursementDetail extends Model
{
    use HasFactory;

    protected $table = 'reimbursement_details';
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reimbursement(): BelongsTo
    {
        return $this->belongsTo(Reimbursement::class, 'reimbursement_id');
    }
}
