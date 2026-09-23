<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /** POST /api/game/score — auth required. Saves a completed run's score. */
    public function submitScore(Request $request)
    {
        $v = Validator::make($request->all(), [
            'score' => 'required|integer|min:0|max:1000000',
            'combo_best' => 'nullable|integer|min:0|max:1000',
        ]);
        if ($v->fails()) {
            return response()->json(['message' => $v->errors()->first()], 422);
        }

        $user = $request->attributes->get('api_user');

        GameScore::create([
            'user_id' => $user->id,
            'score' => $request->score,
            'combo_best' => $request->input('combo_best', 0),
        ]);

        return response()->json([
            'message' => 'Score saved!',
            'best' => GameScore::bestFor($user->id),
        ], 201);
    }

    /** GET /api/game/best — auth required. The logged-in user's personal best. */
    public function myBest(Request $request)
    {
        $user = $request->attributes->get('api_user');
        return response()->json(['best' => GameScore::bestFor($user->id)]);
    }

    /** GET /api/game/leaderboard — public. Top 10 players by best score. */
    public function leaderboard()
    {
        $rows = GameScore::leaderboard(10);

        return response()->json([
            'leaderboard' => $rows->map(fn($r) => [
                'name' => $r->user?->name ?? 'Player',
                'score' => (int) $r->best_score,
            ])->values(),
        ]);
    }
}
