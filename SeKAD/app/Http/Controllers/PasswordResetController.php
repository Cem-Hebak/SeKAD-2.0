<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function sendResetLink(Request $request)
    {
        // Validate email input
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        // Check if user exists
        $user = DB::table('users')->where('loginemail', $email)->first();

        if ($user) {
            $username = $user->username;
            $pass = bin2hex(openssl_random_pseudo_bytes(4)); // Generate temporary password

            // Using PHPMailer to send email
            $mail = new PHPMailer(true);
            try {
                $mail->IsSMTP();
                $mail->Host = env('MAIL_HOST');
                $mail->SMTPAuth = true;
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('MAIL_PASSWORD');
                $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                $mail->Port = env('MAIL_PORT');
                $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Temporary Password for Login to Dashboard System';
                $mail->Body = "Temporary Password for <strong>$username</strong> - <strong>$pass</strong>.";

                $mail->send();

                // Update user's password in the database
                DB::table('users')->where('loginemail', $email)->update([
                    'password' => Hash::make($pass)
                ]);

                return redirect()->back()->with('status', 'Temporary password has been sent to your registered email. Please change it after logging in!');
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Mail could not be sent. Please try again later.']);
            }
        } else {
            return redirect()->back()->withErrors(['email' => 'Email not found in our records.']);
        }
    }
}
