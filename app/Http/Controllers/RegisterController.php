<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        Auth::guard()->login($user);

        return redirect('/');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'category' => ['required'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }


    protected function create(array $data)
    {
        return User::create([
            'fname' => $data['fname'],
            'mname' => $data['mname'],
            'lname' => $data['lname'],
            'category' => $data['category'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'username' => 'required',
        ]);

        $data = array(
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'email' => $request->email,
            'username' => $request->username,
        );


        $users = User::find($request->id);

        $users = $users->update($data);

        return response()->json($users);
    }

    public function updatePassword(Request $request)
    {

        $user_id = $request->id;
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $confirm_new_password = $request->confirm_new_password;

        // get password
        $pw = User::find($user_id, ['password']);

        $data = array(
            'password' => Hash::make($confirm_new_password)
        );


        if (Hash::check($old_password, $pw->password) != 1) {
            $response = "Incorrect password. Please try again.";
        } else if ($new_password != $confirm_new_password) {
            $response = "Passwords did not matched. Please try again.";
        } else {
            $users = User::find($user_id);
            $sql = $users->update($data);
            if ($sql) {
                $response = 1;
            } else {
                $response = "Error in sql query.";
            }
        }

        return response()->json($response);
    }

    public function updateAvatar(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = "AVATAR" . date('Ymdhis');
            $filesize = $file->getSize();
            $fileType = $file->getClientOriginalExtension();
            $folder = uniqid() . '-' . now()->timestamp;

            $thumbnail = '/profile/avatar/' . $request->userId . '/' . $filename . "." . $fileType;

            $user = User::find($request->userId);
            if ($user->avatar != "") {
                if (Storage::exists('public' . $user->avatar)) {
                    Storage::delete('public' . $user->avatar);
                }
            }

            $updateUserAvatar = User::where('id', '=', $request->userId)
                ->update([
                    'avatar' => $thumbnail
                ]);

            if ($updateUserAvatar) {
                $file->storeAs('public/profile/avatar/' . $request->userId, $filename . "." . $fileType);
            }

            return response()->json(["folder" => $folder, "filename" => $thumbnail]);
            // return ["folder" => $folder, "filename" => $thumbnail];
        }

        return '';
    }
}
