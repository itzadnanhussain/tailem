<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;


class LoginController extends Controller
{

    ///Load_Sign_Up_Page
    public function Load_Sign_Up_Page()
    {

        $data = array();
        if(isset($_GET['msg']))
        {
            $data['msg'] = $_GET['msg'];
        }
        ///common  lines
        $data['currentFile'] = 'login';
        $data['title'] = GetTitle();
        return view('admin.login', $data);
    }



    ///Login Process
    public function Login_Process()
    {
        //login process
        if (isset($_POST)) {
            extract($_POST);
            // $username         =    safe_string($username);
            // $password         =    safe_string($password);
            $password        =    md5($password);

            //ERROR Case 0=invalid & 1=valid
            $case = 1;
            $chklogin        =    "select count(id) as loginchk from tbl_admin WHERE username=\"" . $username . "\" AND password=\"" . $password . "\" AND admin_status='1'";
            $chkloginarr    =    \App\Models\Songs::GetRawData($chklogin);

            if (isset($chkloginarr) && ($chkloginarr[0]->loginchk == 0)) {
                $string = base64_encode('Your login details are incorrect. Please check them and try again');
                return redirect('admin/login?msg='.$string);
            } else {
                //Getting ADMIN USER ID AND NAME
                $pointchk        =    "SELECT id,username,type from tbl_admin WHERE username=\"" . $username . "\" AND password=\"" . $password . "\" AND admin_status='1'";
                $rowpointchk     =    \App\Models\Songs::GetRawData($pointchk);
                $rowpointchk     =     (array)$rowpointchk[0];

                $id                 =    $rowpointchk["id"];
                $username        =    trim($rowpointchk["username"]);
                $login_user_type =    $rowpointchk["type"];
                //---------------------------------------------------- 
                session()->put('reviewsite_cpadmin_id', $id);
                session()->put('reviewsite_cpadmin_uname', $username);
                session()->put('reviewsite_cpadmin_type', $login_user_type);

                //login logs
                $qry = "insert into tbl_login_logs set login_user_id='" . session()->get('reviewsite_cpadmin_id') . "',
		        login_date='" . time() . "',login_ip='" . $_SERVER['REMOTE_ADDR'] . "' ";
                \App\Models\Songs::GetRawData($qry);
                return redirect('admin/index');
            }
        }
    }


    ///Logout_Process
    public function Logout_Process()
    {
        session()->invalidate();
        session()->regenerateToken();
        return redirect('admin/login');
    }
}
