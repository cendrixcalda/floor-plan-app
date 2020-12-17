<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\User;

class UserController extends Controller
{
    public function show(Request $request){
        return view('user');
    }

    public function getColumns(){
        $columns = Schema::getColumnListing('users');

        return json_encode($columns);
    }

    public function getUsers(Request $request){

        $length = $request->input('length');
        $search = $request->input('search');
        $search = json_decode($search, true);


        $users = User::when($search, function ($query) use ($search) {
            foreach ($search as $key => $value) {
                $query->where($key, 'like', $value . '%');
            }
        })
        ->paginate($length);

        return ['data' => $users, 'length' => $length, 'requestCounter' => $request->input('requestCounter')];
    }

    public function postUser(Request $request){
        $data = $request->post();

        if (!isset($data['details']['username'])){ 
            $notifMessage = "Username is required.";
            $notifType = "warning";
            
            return ["notifMessage" => $notifMessage, "notifType" => $notifType];
        } elseif (!isset($data['details']['plain_password'])){ 
            $notifMessage = "Password is required.";
            $notifType = "warning";

            return ["notifMessage" => $notifMessage, "notifType" => $notifType];
        } elseif (strlen($data['details']['username']) < 8){ 
            $notifMessage = "Username must be at least 8 characters long.";
            $notifType = "warning";

            return ["notifMessage" => $notifMessage, "notifType" => $notifType];
        } elseif (strlen($data['details']['plain_password']) < 8){ 
            $notifMessage = "Password must be at least 8 characters long.";
            $notifType = "warning";

            return ["notifMessage" => $notifMessage, "notifType" => $notifType];
        } elseif (preg_match('/^\S.*\s.*\S$/', $data['details']['username'])){ 
            $notifMessage = "Whitespace is not allowed. Please remove whitespace in username.";
            $notifType = "warning";

            return ["notifMessage" => $notifMessage, "notifType" => $notifType];
        } elseif (preg_match('/^\S.*\s.*\S$/', $data['details']['plain_password'])){ 
            $notifMessage = "Whitespace is not allowed. Please remove whitespace in password.";
            $notifType = "warning";

            return ["notifMessage" => $notifMessage, "notifType" => $notifType];
        } else {
            //Check if username already exists
            $usernameCount = User::where('username', $data['details']['username'])->count();
            if($usernameCount > 0){
                $notifMessage = "Username is taken.";
                $notifType = "warning";

                return ["notifMessage" => $notifMessage, "notifType" => $notifType];
            }
            
            foreach ($data['details'] as $detailsKey => $details) {
                $data['details'][$detailsKey] = json_decode(trim($details));
            }

            $data['details']['password'] = bcrypt($data['details']['plain_password']);

            try {
                $user = User::create($data['details']);

                $notifMessage = "New user was added successfully.";
                $notifType = "success";
            } catch (Exception $ex) {
                $notifMessage = $ex->getMessage();
                $notifType = "error";
            }
            
            return ["notifMessage" => $notifMessage, "notifType" => $notifType];
        }
    }

    public function putUser(Request $request){
        $id = $request->post('id');
        $key = $request->post('key');
        $value = $request->post('value');

        try {
            if($key == 'username') {
                if(!$value) {
                    $notifMessage = "Username is required.";
                    $notifType = "warning";

                    return ["notifMessage" => $notifMessage, "notifType" => $notifType];
                } else if(strlen($value) < 8) {
                    $notifMessage = "Username must be at least 8 characters long.";
                    $notifType = "warning";

                    return ["notifMessage" => $notifMessage, "notifType" => $notifType];
                } else if(preg_match('/^\S.*\s.*\S$/', $value)) {
                    $notifMessage = "Whitespace is not allowed. Please remove whitespace in username.";
                    $notifType = "warning";

                    return ["notifMessage" => $notifMessage, "notifType" => $notifType];
                }

                //Check if username already exists
                $usernameCount = User::where('username', $value)->count();
                if($usernameCount > 0){
                    $notifMessage = "Username is taken.";
                    $notifType = "warning";

                    return ["notifMessage" => $notifMessage, "notifType" => $notifType];
                }
            } else if($key == 'plain_password') {
                if(!$value) {
                    $notifMessage = "Password is required.";
                    $notifType = "warning";

                    return ["notifMessage" => $notifMessage, "notifType" => $notifType];
                } else if(strlen($value) < 8) {
                    $notifMessage = "Password must be at least 8 characters long.";
                    $notifType = "warning";

                    return ["notifMessage" => $notifMessage, "notifType" => $notifType];
                } else if(preg_match('/^\S.*\s.*\S$/', $value)) {
                    $notifMessage = "Whitespace is not allowed. Please remove whitespace in password.";
                    $notifType = "warning";

                    return ["notifMessage" => $notifMessage, "notifType" => $notifType];
                }

            } else if($key == 'adss_content_manager_access' || $key == 'floor_plan_access' || $key == 'floor_plan_edit_privilege') {
                $user = User::find($id);
                if($user->user_type == 'Admin') {
                    $notifMessage = "Cannot change access rights of user with admin type.";
                    $notifType = "error";

                    return ["notifMessage" => $notifMessage, "notifType" => $notifType];
                }
            }

            $user = User::find($id);

            $user->update([$key => $value]);
            
            if($key == 'floor_plan_access' && $value == 0) {
                $user->update(['floor_plan_edit_privilege' => 0]);
            }

            if($key == 'plain_password') {
                $user->update(['password' => bcrypt($value)]);
            }

            $notifMessage = "User was updated successfully.";
            $notifType = "success";
        } catch (Exception $ex) {
            $notifMessage = $ex->getMessage();
            $notifType = "error";
        }
        
        return ["notifMessage" => $notifMessage, "notifType" => $notifType];
    }

    public function deleteUser(Request $request){
        $id = $request->post('id');

        try {
            $user = User::find($id);
            if($user->user_type == 'Admin') {
                $notifMessage = "Cannot delete user of admin type.";
                $notifType = "error";

                return ["notifMessage" => $notifMessage, "notifType" => $notifType];
            }
            $user->delete();
            
            $notifMessage = "User was removed successfully.";
            $notifType = "success";
        } catch (Exception $ex) {
            $notifMessage = $ex->getMessage();
            $notifType = "error";
        }
        
        return ["notifMessage" => $notifMessage, "notifType" => $notifType];
    }
}
