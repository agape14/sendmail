<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'content',
        'is_sent',
        'last_sent_at'
    ];

    protected $casts = [
        'is_sent' => 'boolean',
        'last_sent_at' => 'datetime'
    ];

    /**
     * Obtener una pregunta aleatoria que no haya sido enviada recientemente
     */
    public static function getRandomUnsent()
    {
        $minDaysBetween = config('mype.min_days_between_emails', 1);
        
        return static::where(function ($query) use ($minDaysBetween) {
            $query->where('is_sent', false)
                  ->orWhere('last_sent_at', '<', now()->subDays($minDaysBetween));
        })
        ->inRandomOrder()
        ->first();
    }

    /**
     * Marcar la pregunta como enviada
     */
    public function markAsSent()
    {
        $this->update([
            'is_sent' => true,
            'last_sent_at' => now()
        ]);
    }

    /**
     * Resetear el estado de envío de todas las preguntas
     */
    public static function resetAllSentStatus()
    {
        static::query()->update([
            'is_sent' => false,
            'last_sent_at' => null
        ]);
    }
}
