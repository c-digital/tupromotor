<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class CustomerToBeApprovedController extends Controller
{
    public function index()
    {
        auth()->user()->unreadNotifications->markAsRead();

        $users = User::where('approved', '!=', 1)
            ->orWhere('approved', null)
            ->get();

        return view('backend.approved.index', compact('users'));
    }

    public function approved($id)
    {
        $user = User::find($id);
        $user->approved = true;
        $user->save();

        if ($user->phone) {
            $sid = 'AC3c2f7333dfb5c3333588728e70fca099';
            $token = '55aba6e206646c42ace1acde6b63b848';

            $twilio = new \Twilio\Rest\Client($sid, $token);

            $phone = $user->phone;

            $body = '*USUARIO DE TUPROMOTOR.NET APROBADO*

Tu usuario ha sido aprobado satisfactoriamente, ahora puedes iniciar sesión y empezar a usar nuestra plataforma.';

            $message = $twilio->messages
              ->create("whatsapp:$phone", // to
                       array(
                           "from" => "whatsapp:+14155238886",
                           "body" => $body
                       )
              );
        }

        return redirect('/admin/customer_to_be_approved');
    }

    public function decline($id)
    {
        $user = User::find($id);
        $user->approved = false;
        $user->save();
        return redirect('/admin/customer_to_be_approved');
    }
}
