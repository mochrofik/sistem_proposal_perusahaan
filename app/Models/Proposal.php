<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'division_id', 'status'];

    // ─── Relationships ──────────────────────────────────────────────────────

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function division(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    
    public function scopeVisibleBy(Builder $query, User $user): Builder
    {
        $isManager = $user->hasRole('Manager');
        $isFinance  = $user->hasRole('Finance');

        return $query->where(function (Builder $q) use ($user, $isManager, $isFinance) {

            $q->where('status', 'approved');
            $q->orWhere(function (Builder $sub) use ($user, $isManager) {
                $sub->whereIn('status', ['pending', 'rejected']);
                if (! $isManager) {
                    $sub->where('division_id', $user->division_id);
                }
            });
        });
    }


    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'Pending',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default    => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'amber',
            'approved' => 'emerald',
            'rejected' => 'red',
            default    => 'gray',
        };
    }
}
