<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Contact, Subscriber};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MiscController extends Controller
{
    public function contact(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'email' => 'required|email',
            'message' => 'required|string|max:3000',
        ]);
        if ($v->fails()) {
            return response()->json(['message' => $v->errors()->first()], 422);
        }

        Contact::create($request->only(['name', 'email', 'message', 'subject']));

        return response()->json(['message' => 'Your message has been sent. We will get back to you soon!']);
    }

    public function newsletter(Request $request)
    {
        $v = Validator::make($request->all(), ['email' => 'required|email']);
        if ($v->fails()) {
            return response()->json(['message' => $v->errors()->first()], 422);
        }

        Subscriber::firstOrCreate(['email' => $request->email]);

        return response()->json(['message' => 'Subscribed successfully!']);
    }
}
