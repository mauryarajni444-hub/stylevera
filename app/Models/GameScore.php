<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    protected $fillable = ['user_id', 'score', 'combo_best'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** The logged-in user's personal best score, or 0 if never played. */
    public static function bestFor(int $userId): int
    {
        return (int) static::where('user_id', $userId)->max('score');
    }

    /** Top N scores across all players, one row per player (their best). */
    public static function leaderboard(int $limit = 10)
    {
        return static::selectRaw('user_id, MAX(score) as best_score')
            ->with('user:id,name')
            ->groupBy('user_id')
            ->orderByDesc('best_score')
            ->limit($limit)
            ->get();
    }
}
