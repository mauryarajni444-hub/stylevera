<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GameScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /** GET /game — the playable page. Route is 'sv.auth'-gated, so a guest never reaches here. */
    public function play(Request $request)
    {
        $userId = auth()->id() ?? session('sv_user_id');
        $best = $userId ? GameScore::bestFor($userId) : 0;

        return view('frontend.game', ['best' => $best]);
    }

    /** POST /game/score — saves a completed run's score for the logged-in user. */
    public function submitScore(Request $request)
    {
        $v = Validator::make($request->all(), [
            'score' => 'required|integer|min:0|max:1000000',
            'combo_best' => 'nullable|integer|min:0|max:1000',
        ]);
        if ($v->fails()) {
            return response()->json(['message' => $v->errors()->first()], 422);
        }

        $userId = auth()->id() ?? session('sv_user_id');

        GameScore::create([
            'user_id' => $userId,
            'score' => $request->score,
            'combo_best' => $request->input('combo_best', 0),
        ]);

        return response()->json([
            'message' => 'Score saved!',
            'best' => GameScore::bestFor($userId),
        ]);
    }

    /** GET /game/leaderboard — top 10 players page. */
    public function leaderboard()
    {
        $rows = GameScore::leaderboard(10);
        return view('frontend.game-leaderboard', ['rows' => $rows]);
    }
}
