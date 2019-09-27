<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Department;
use App\Location;
use App\AccessControl;
use App\Module;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;
use Redirect;
use Excel;

class UserController extends Controller
{
    public function index()
    {

        // $users = User::all();
        $users = User::allUser();

        return view('users.lists', compact('users'));
    }

    public function create()
    {

        $roles = Role::orderBy('role', 'ASC')->pluck('role', 'id');
        $departments = Department::orderBy('department', 'ASC')->pluck('department', 'id');
        $locations = Location::pluck('location', 'id');
        $companies = ['Charter Chemical and Coating Corp.' => 'Charter Chemical and Coating Corp.', 'Davies Paints Philippines Inc.' => 'Davies Paints Philippines Inc.', 'MAINCOAT' => 'MAINCOAT', 'ZENKEM' => 'ZENKEM', '2K3 Industries Inc.' => '2K3 Industries Inc.'];
        $superiors = User::getSuperior();
        $superiors[0] = 'NO SUPERIOR';

        return view('users.create', compact('roles', 'departments', 'locations', 'companies', 'superiors'));
    }

    public function store(Request $request)
    {

        $myRole = Role::findOrFail($request->role_id);
        $username = strtolower($request->first_name[0] . $request->last_name);
        $user = new User();
        $user->first_name = strtoupper($request->first_name);
        $user->last_name = strtoupper($request->last_name);
        $user->middle_initial = strtoupper($request->middle_initial);
        $user->username = $username;
        $user->position = $myRole->role;
        $user->employee_number = $request->employee_number;
        if (!empty($request->email)) {
            $user->email = $request->email;
        } else {
            $user->email = "";
        }
        $user->password = \Hash::make($request->password);
        $user->active = "1";
        $user->dept_id = $request->dept_id;
        $user->location_id = $request->location_id;
        $user->role_id = $request->role_id;
        if (empty($request->cellno)) {
            $user->cellno = "";
        } else {
            $user->cellno = $request->cellno;
        }
        if (empty($request->localno)) {
            $user->localno = "";
        } else {
            $user->localno = $request->localno;
        }

        $user->mystatus = '';
        $user->company = $request->company;
        $user->superior = $request->superior_id;

        if ($request->hasFile('image')) {
            $file = Input::file('image');
            if (!empty($file)) {
                $destinationPath = public_path() . '/uploads/users/' . $request->get('employee_number');
                if (!\File::exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $filename = $file->getClientOriginalName();
                $file->move($destinationPath, $filename);

                $user->image = $filename;
            }
        } else {

            $user->image = "";
        }
        $user->save();

        $rid = $request->get('role_id');
        $postdata = [];

        if ($rid == 1) {

            // $postdata = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
            $postdata = [22, 23, 27, 29, 31, 33, 37, 38];
        } elseif ($rid == 2) {

            // $postdata = [7,8,9,10,13,15,17,18,21,23];
            $postdata = [22, 23, 27, 29, 31, 33, 37, 38];
        } elseif ($rid == 3) {

            // $postdata = [7,9,10,13,15,17,18,19];
            $postdata = [22, 23, 27, 29, 31, 33, 37, 38];
        } elseif ($rid == 4) {

            // $postdata = [7,9,10,13,15,17];
            $postdata = [22, 23, 27, 29, 31, 33, 37, 38];
        } elseif ($rid == 5) {

            // $postdata = [7,9,10,13,15,17,20,22];
            $postdata = [22, 23, 27, 29, 31, 33, 37, 38];
        } elseif ($rid == 7) {

            // $postdata = [7,9,10,13,15,17]; 
            $postdata = [22, 23, 27, 29, 31, 33, 37, 38];
        }
        if (!empty($postdata)) {
            foreach ($postdata as $postd) {
                $access = new AccessControl();

                $access->user_id = $user->id;
                $access->module_id = $postd;
                $access->save();
            }
        }

        return redirect('users')->with('is_success', 'User was successfully saved');
    }

    public function edit($id)
    {

        $user = User::findOrFail($id);
        $roles = Role::pluck('role', 'id');
        $departments = Department::pluck('department', 'id');
        $locations = Location::pluck('location', 'id');
        $companies = ['Charter Chemical and Coating Corp.' => 'Charter Chemical and Coating Corp.', 'Davies Paints Philippines Inc.' => 'Davies Paints Philippines Inc.', 'MAINCOAT' => 'MAINCOAT', 'ZENKEM' => 'ZENKEM', '2K3 Industries Inc.' => '2K3 Industries Inc.'];
        $superiors = User::getSuperior();

        return view('users.edit', compact('user', 'roles', 'departments', 'locations', 'companies', 'superiors'));
    }

    public function update(Request $request, $id)
    {


        $role = Role::findOrFail($request->role_id);

        $user = User::findOrFail($id);
        $user->first_name = strtoupper($request->first_name);
        $user->last_name = strtoupper($request->last_name);
        $user->middle_initial = strtoupper($request->middle_initial);
        $user->username = $request->username;
        $user->position = $role->role;
        $user->employee_number = $request->employee_number;
        if (!empty($request->email)) {
            $user->email = $request->email;
        } else {
            $user->email = "";
        }
        $user->active = "1";
        $user->dept_id = $request->dept_id;
        $user->location_id = $request->location_id;
        $user->role_id = $request->role_id;
        if (empty($request->cellno)) {
            $user->cellno = "";
        } else {
            $user->cellno = $request->cellno;
        }
        if (empty($request->localno)) {
            $user->localno = "";
        } else {
            $user->localno = $request->localno;
        }
        $user->mystatus = '';
        $user->company = $request->company;

        if (empty($request->superior_id)) {
            $user->superior = 0;
        } else {
            $user->superior = $request->superior_id;
        }


        if ($request->hasFile('image')) {

            $old_files = public_path() . '/uploads/users/' . $request->get('employee_number') . '/' . $user->image; // get all file names                                
            if (is_file($old_files)) {
                unlink($old_files); // delete file
            }
            $file = Input::file('image');
            if (!empty($file)) {
                $destinationPath = public_path() . '/uploads/users/' . $request->get('employee_number');
                $filename = $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $user->image = $filename;
            }
        } else {

            $user->image = "";
        }
        $user->update();

        return redirect('users')->with('is_update', 'User was successfully saved');
    }
    public function reset_password($payload)
    {

        $users = User::FullDetails();

        return view('users.reset_password', compact('users'));
    }

    public function reset_password_update(Request $request)
    {

        $user = User::findOrFail($request->get('user_id'));
        $user->password = \Hash::make($request->password);
        $user->update();

        return redirect('users')->with('is_reset', 'User was successfully saved');
    }

    public function activate($id)
    {

        $user = User::findOrFail($id);

        if ($user->active > 0) {

            $user->active = 0;
        } else {

            $user->active = 1;
        }
        $user->update();
        return redirect('users');
    }

    public function access_control($id)
    {

        // $modules = Module::all();
        $modules = Module::getAll();
        $access_control = AccessControl::byUser($id);
        $user = User::findOrFail($id);

        return view('users.access_control', compact('modules', 'access_control', 'user'));
    }
    public function access_control_store(Request $request)
    {

        $id = $request->get('id');
        $postdata = $request->get('module_id');
        $sub = $request->sub;

        AccessControl::where('user_id', $id)->delete();

        if ($sub == 1) {
            if (!empty($postdata)) {
                foreach ($postdata as $postd) {
                    $access = new AccessControl();

                    $access->user_id = $id;
                    $access->module_id = $postd;
                    $access->save();
                }
            }
        }
        // hr
        elseif ($sub == 2) {
            $postdatas = [37, 38, 27, 29, 31, 33, 22, 23, 64, 68, 75, 28, 30, 32, 34, 35, 36, 57];
            foreach ($postdatas as $pd) {
                $access = new AccessControl();
                $access->user_id = $id;
                $access->module_id = $pd;
                $access->save();
            }
        }
        // it
        elseif ($sub == 3) {
            $postdatas = [37, 38, 27, 29, 31, 33, 22, 23, 64, 68, 75, 24, 25, 12, 13, 14, 15, 16, 17, 18, 19, 20, 46, 48];
            foreach ($postdatas as $pd) {
                $access = new AccessControl();
                $access->user_id = $id;
                $access->module_id = $pd;
                $access->save();
            }
        }
        // admin
        elseif ($sub == 4) {
            $postdatas = [37, 38, 27, 29, 31, 33, 22, 23, 64, 68, 75, 39, 40, 41, 42, 43, 44, 63];
            foreach ($postdatas as $pd) {
                $access = new AccessControl();
                $access->user_id = $id;
                $access->module_id = $pd;
                $access->save();
            }
        }
        // default users
        elseif ($sub == 5) {
            $postdatas = [37, 38, 27, 29, 31, 33, 22, 23, 64, 68, 75];
            foreach ($postdatas as $pd) {
                $access = new AccessControl();
                $access->user_id = $id;
                $access->module_id = $pd;
                $access->save();
            }
        }

        return redirect('users')->with('is_added', 'Success');
    }

    public function import(Request $request)
    {

        set_time_limit(0);
        ini_set('memory_limit', -1);

        if ($request->file('userfile')) {

            $path = $request->file('userfile')->getRealPath();
            \Excel::load(Input::file('userfile'), function ($reader) {
                foreach ($reader->toArray() as $row) {
                    $check = User::where('employee_number', $row['empno'])->count();
                    if ($check < 1) {

                        $role = Role::where('role', $row['role'])->first();
                        $dept = Department::where('department', $row['department'])->first();
                        $location = Location::where('location', $row['location'])->first();
                        $trimlastname = str_replace(' ', '', $row['lastname']);
                        $rlastname = str_replace('.', '', $trimlastname);

                        if (empty($role)) {

                            $nr = [];
                            $nr['role'] = $row['role'];
                            $nr['description'] = $row['role'];
                            $role = new Role($nr);
                            $role->save();
                        }
                        if (empty($location)) {
                            $nl = [];
                            $nl['location'] = $row['location'];
                            $location = new Location($nl);
                            $location->save();
                        }
                        if (empty($dept)) {
                            $nd = [];
                            $nd['department'] = $row['department'];
                            $dept = new Department($nd);
                            $dept->save();
                        }
                        $newuser = new User();
                        $newuser->employee_number = $row['empno'];
                        $newuser->first_name = strtoupper($row['firstname']);
                        $newuser->last_name = strtoupper($row['lastname']);
                        $newuser->middle_initial = strtoupper($row['middlename'][0]);
                        $newuser->username  = strtolower($row['firstname'][0] . $rlastname);
                        $newuser->password = \Hash::make('password');
                        $newuser->position = $row['position'];
                        $newuser->company = $row['company'];
                        $newuser->location_id = $location->id;
                        $newuser->email  = "";
                        $newuser->active = 1;
                        $newuser->super_admin = 0;
                        $newuser->dept_id  = $dept->id;
                        $newuser->role_id = $role->id;
                        $newuser->image = "";
                        $newuser->mystatus = "";
                        $newuser->email_pass = "";
                        $newuser->cellno  = "";
                        $newuser->localno = "";
                        $newuser->online  = 0;
                        $newuser->superior = $row['superior'];
                        $newuser->save();
                    }
                }
            });
            return redirect('users')
                ->with('class', 'alert-success')
                ->with('message', 'Customer list successfuly updated');
        }
    }

    public function user_reset_pass($payload)
    {

        return view('users.reset_password_user');
    }

    public function reset_password_update_user(Request $request)
    {
        if ($request->password == $request->con_password) {
            $this->validate($request, [
                'password' => 'required|min:6',
            ]);
            $user = User::findOrFail(Auth::id());
            $user->password = \Hash::make($request->password);
            $user->update();

            return redirect('user/reset/password.php')->with('is_reset', 'Password changed');
        }
        return redirect('user/reset/password.php')->with('con_pass_error', 'Confirm Password and password not matched');
    }

    public function change_profile_picture_index()
    {
        return view('users.change_profile_picture');
    }

    public function change_profile_picture(Request $request)
    {

        if ($request->hasFile('image')) {
            $user = User::findOrFail(Auth::id());
            $file = Input::file('image');
            $destinationPath = public_path() . '/uploads/users/' . $user->employee_number;
            $filename = $file->getClientOriginalName();
            Input::file('image')->move($destinationPath, $filename);

            $user->image = $filename;
            $user->update();
            return redirect()->back()->with('is_success', 'Success');
        }
    }
}
