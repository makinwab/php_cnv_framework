<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/2/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */


class User extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    public function index()
    {
        //Set the testing template file location
        $this->template->template_file = 'user/index';

        //Using the html helper class
        $tryout = HTMLHelpers::Heading('Try out', 1);
        $foot = Htmlhelpers::Para('copyright', ['style' =>"color:crimson;"]);

        if(Session::get('admin') == 1)
        {
            $usertype = "Administrator";
        }
        else
        {
            $usertype = "User";
        }
        $id = Session::get('id');

        $user = new UserDao(["id" => $id]);
        $username = $user->username;
        //Get user type for redirection
        if(Session::get('admin') != 1)
        {
            header("Location:".URL."user/others/".$username);
        }

        if(array_key_exists('submit',$_POST))
        {
            if(!empty($_POST['uname']) && !empty($_POST['pwd']) && isset($_POST['usertype']))
            {
                $user_name = $_POST['uname'];
                $password = $_POST['pwd'];
                $type = $_POST['usertype'];

                Session::seterror($this->createuser($user_name,$password,$type));
            }
            else
            {
                Session::seterror('Please fill the fields appropriately');
            }

        }
            $error = Auth::handleError();
            $this->template->entries[] = (object)[
            'user' => $usertype,
            'username' => $username,
            'error' => $error,
            'createuser' => URL.'user/index',
            'viewusers' => URL.'user/viewusers',
            'logout' => URL.'user/logout',
            'here' => URL."user/details/me/you",
            'paginate' => URL."paginate/index"
            ];
            $extra = (object)['header'=>(object)['try' => $tryout],
                            'footer' => (object)['foot' => $foot]];

            $name = $this->template->generate_markup($extra);
            echo $this->view->render($name);
    }

    public function others($username)
    {

        //Set the testing template file location
        $this->template->template_file = 'user/others';
        $this->template->entries = [
        (object)['link' => 'user/details/me/you', 'name' => 'Here'],
        (object)['link' => LOGOUT, 'name' => 'logout']
        ];
        $extra = (object)['header' => (object)['header_stuff' => $username]];

        $name = $this->template->generate_markup($extra);
        echo $this->view->render($name);
    }

    public function createuser($username,$password,$type)
    {

        return $this->model->createuser($username,$password,$type);

    }

   public function details($me,$you)
    {
        $this->view->me = "$you $me";
        echo $this->view->me;
        header("Location:".URL."user");
    }

    public function viewusers()
    {
        $this->template->template_file = 'user/viewusers';
        $allusers = $this->model->viewusers();
        $error = Auth::handleError();
        $extra = (object)[
                'header' => (object)['error' => $error, 'jquery' => URL."public/js/jquery.min.js", 'custom' => URL."public/js/custom.js"],
                'footer' => (object)['back' => URL."user", 'logout' => LOGOUT]
                ];

        foreach ($allusers as $key => $value) {
            $user_type = ($value->admin == 1)?'admin':'user';
            $this->template->entries[] = (object)['id' => $value->id, 'username' => $value->username,
                                                 'password' => $value->password, 'admin' => $user_type,
                                                 'edit' => URL."user/edit/".$value->id, 'delete' => URL."user/deleteuser/".$value->id
                                                 ];
        }

        $name = $this->template->generate_markup($extra);
        echo $this->view->render($name);
    }

    public function edit($user_id)
    {
        $edituser = $this->model->edit($user_id);
        $this->template->template_file = 'user/edit';
        $error = Auth::handleError();
        $aselected = '';
        $uselected = '';
        if($edituser->admin == 1)
        {
            $aselected = 'selected';
        }

        if($edituser->admin == 0)
        {
            $uselected = 'selected';
        }

        $this->template->entries[] = (object)[
            'error' => $error,
            'id' => $edituser->id,
            'username' => $edituser->username,
            'admin' => $edituser->admin,
            'editlink' =>  URL."user/editsave/".$edituser->id,
            'aselected' => $aselected,
            'uselected' => $uselected,
            'home' => URL."user",
            'users' =>  URL."user/viewusers",
            'logout' => LOGOUT
        ];

        $name = $this->template->generate_markup();
        echo $this->view->render($name);
    }

    public function editsave($user_id)
    {
        if(array_key_exists('submit',$_POST))
        {
            $user_data = [];
            $user_data['username'] = $_POST['uname'];
            $user_data['password'] = $_POST['pwd'];
            $user_data['admin'] = $_POST['usertype'];

            Session::seterror($this->model->editsave($user_id, $user_data));

            header("Location:".URL."user/viewusers");
        }
    }

    public function deleteuser($user_id)
    {
        Session::seterror($this->model->deleteuser($user_id));
        header("Location:".URL."user/viewusers");
    }

    public function logout()
    {
        Session::destroy();
        header("Location:".URL."index");
    }

}
