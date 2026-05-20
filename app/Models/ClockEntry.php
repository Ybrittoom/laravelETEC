<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClockEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'clock_in',
        'lunch_start',
        'lunch_end',
        'clock_out',
        'total_minutes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mutator automático para calcular as horas trabalhadas sempre que atualizar o ponto
    public function calculateTotalMinutes()
    {
        if (!$this->clock_in || !$this->clock_out) {
            return 0;
        }

        $in = Carbon::parse($this->clock_in);
        $out = Carbon::parse($this->clock_out);
        
        $total = $in->diffInMinutes($out);

        // Subtrai o tempo de almoço se ambos os horários existirem
        if ($this->lunch_start && $this->lunch_end) {
            $lStart = Carbon::parse($this->lunch_start);
            $lEnd = Carbon::parse($this->lunch_end);
            $lunchTime = $lStart->diffInMinutes($lEnd);
            $total -= $lunchTime;
        }

        return $total > 0 ? $total : 0;
    }
}