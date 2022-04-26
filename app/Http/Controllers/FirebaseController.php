<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Facades\Larafirebase;

class FirebaseController extends Controller
{
    public function updateToken(Request $request)
    {
        \Log::info('updateToken ' . $request->token);
        try {
            $request->user()->update(['fcm_token' => $request->token]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false
            ], 500);
        }
    }

    public function notification(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required'
        ]);

        try {
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();


            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

            //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));

            /* or */

            Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);
            foreach ($fcmTokens as $fcm)
                Notification::create(['title' => $request->title, 'description' => $request->message, 'toFcm' => $fcm, 'status' => 'delivared']);
            return $this->getJsonResponse('success');
//            redirect()->back()->with('success', 'Notification Sent Successfully!!');

        } catch (\Exception $e) {
            report($e);
            return $this->getJsonResponse('error', $e->getMessage(), 400);
//        return redirect()->back()->with('error', 'Something goes wrong while sending notification.');
        }
    }

    public function oneNotification(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
            'fcmToken' => 'required'
        ]);
        try {
            Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($request->fcmToken);

            Notification::create(['title' => $request->title, 'description' => $request->message, 'toFcm' => $request->fcmToken, 'status' => 'delivared']);
            return $this->getJsonResponse('success');

        } catch (\Exception $e) {
            report($e);
            return $this->getJsonResponse('error', $e->getMessage(), 400);
        }
    }
    public function getNotification(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id'

        ]);
        $userToken = User::whereNotNull('fcm_token')->where('id','=',$request->user_id)->pluck('fcm_token');

   $notifications=  Notification::where('toFcm',$userToken[0])->get();
        return $this->getJsonResponse('success', $notifications, 200);


    }
}
