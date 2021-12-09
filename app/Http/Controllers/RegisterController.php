<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Attendee;
use App\Models\ClassActivity;
use App\Models\ClassActivityDetail;
use App\Models\ClassActivityScoring;
use App\Models\Classes;
use App\Models\ClassList;
use App\Models\Post;
use App\Models\PostComments;
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

    public function createStudent(Request $request)
    {
        // $check_id_unique
        $count_student_id = User::where('student_id', $request->student_id)
            ->where('category', 'S')
            ->count();

        // $check_email_unique

        $count_email = User::where('email', $request->email)->count();

        if ($count_student_id > 0) {
            $response = 'id';
        } else if ($count_email > 0) {
            $response = 'email';
        } else {
            $form_data = array(
                'student_id'    => $request->student_id,
                'fname'         => $request->fname,
                'mname'         => $request->mname,
                'lname'         => $request->lname,
                'email'         => $request->email,
                'username'      => $request->student_id,
                'password'      => Hash::make('12345'),
                'category'      => 'S',
            );
            $user = User::create($form_data);
            if ($user) {
                $response = 1;
            }
        }

        return response()->json($response);
    }

    public function viewStudent(Request $request)
    {
        // $check_id_unique
        $response = User::where('category', 'S')
            ->get();

        return response()->json($response);
    }

    public function updateStudent(Request $request)
    {
        // $check_id_unique
        $count_student_id = User::where('student_id', $request->student_id)
            ->where('category', 'S')
            ->where('id', '!=', $request->id)
            ->count();

        // $check_email_unique
        $count_email = User::where('email', $request->email)
            ->where('id', '!=', $request->id)
            ->count();

        if ($count_student_id > 0) {
            $response = 'id';
        } else if ($count_email > 0) {
            $response = 'email';
        } else {
            $user = User::find($request->id);
            $form_data = array(
                'student_id'    => $request->student_id,
                'fname'         => $request->fname,
                'mname'         => $request->mname,
                'lname'         => $request->lname,
                'email'         => $request->email
            );
            $_user = $user->update($form_data);
            if ($_user) {
                $response = 1;
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

    public function createTeacher(Request $request)
    {
        // $check_id_unique
        $count_student_id = User::where('student_id', $request->student_id)
            ->where('category', 'T')
            ->count();

        // $check_email_unique

        $count_email = User::where('email', $request->email)->count();

        if ($count_student_id > 0) {
            $response = 'id';
        } else if ($count_email > 0) {
            $response = 'email';
        } else {
            $form_data = array(
                'student_id'    => $request->student_id,
                'fname'         => $request->fname,
                'mname'         => $request->mname,
                'lname'         => $request->lname,
                'email'         => $request->email,
                'username'      => $request->student_id,
                'password'      => Hash::make('12345'),
                'category'      => 'T',
            );
            $user = User::create($form_data);
            if ($user) {
                $response = 1;
            }
        }

        return response()->json($response);
    }

    public function viewTeacher(Request $request)
    {
        // $check_id_unique
        $response = User::where('category', 'T')
            ->get();

        return response()->json($response);
    }

    public function updateTeacher(Request $request)
    {
        // $check_id_unique
        $count_student_id = User::where('student_id', $request->student_id)
            ->where('category', 'T')
            ->where('id', '!=', $request->id)
            ->count();

        // $check_email_unique
        $count_email = User::where('email', $request->email)
            ->where('id', '!=', $request->id)
            ->count();

        if ($count_student_id > 0) {
            $response = 'id';
        } else if ($count_email > 0) {
            $response = 'email';
        } else {
            $user = User::find($request->id);
            $form_data = array(
                'student_id'    => $request->student_id,
                'fname'         => $request->fname,
                'mname'         => $request->mname,
                'lname'         => $request->lname,
                'email'         => $request->email
            );
            $_user = $user->update($form_data);
            if ($_user) {
                $response = 1;
            }
        }

        return response()->json($response);
    }


    public function deleteUser(Request $request)
    {
        if ($this->isUserUsed($request->id) > 0) {
            $response = 2;
        } else {
            $user = User::find($request->id);
            $user->delete();
            $response = 1;
        }

        return response()->json($response);
    }

    function isUserUsed($user_id)
    {
        $count_attendance = Attendance::where('user_id', $user_id)->count();
        $count_attendee = Attendee::where('user_id', $user_id)->count();
        $count_act_det = ClassActivityDetail::where('user_id', $user_id)->count();
        $count_activity = ClassActivity::where('user_id', $user_id)->count();
        $count_score = ClassActivityScoring::where('user_id', $user_id)->count();
        $count_list = ClassList::where('user_id', $user_id)->count();
        $count_class = Classes::where('user_id', $user_id)->count();
        $count_comment = PostComments::where('user_id', $user_id)->count();
        $count_posts = Post::where('user_id', $user_id)->count();

        return $count_attendance + $count_attendee + $count_act_det + $count_activity + $count_score + $count_list + $count_class + $count_comment + $count_posts;
    }
}
