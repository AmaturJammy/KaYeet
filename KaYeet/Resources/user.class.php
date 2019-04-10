<?php
class User{
    protected $data = [];
    protected $db;
    public function __construct(){
        $this->db = DB::getInstance();
    }
    public function register( $data = [] ) {
        //create query to insert user in db
        $sql = 'INSERT INTO user (Name,Password,EmailAddress) VALUES(:screenName, :password, :email)';
        //rewrite user-data to params-array, because we only need one password
        $params = ['screenName' => $data['screenName'], 'password' => password_hash($data['password'], PASSWORD_BCRYPT), 'email' => $data['email']];
        //run insert query
        $result = $this->db->run( $sql, $params );
        return $result;
    }
    public function checkLogin() 
    {
        global $message;
        
        if( isset( $_REQUEST['email'] ) && isset( $_REQUEST['password'] ) ) {
            $password = $_REQUEST['password'];
            $user = $this->db->run( 'SELECT * FROM user WHERE EmailAddress = ?', [$_REQUEST['email']])->fetch();
            if(is_array($user) && password_verify($password, $user['Password'])) {
                $this->data = $user;
                $_SESSION['user'] = $user;
                return true;
            }else{
                $message = "Wachtwoord is fout";
            }
        } else if( isset( $_SESSION['user'] ) ) {
            //To-do: populate user-object with user-data from session, return true
            $this->data = $_SESSION['user'];
            return true;
        }
        //fallback, in case user-info is not submitted via loginform and not available in session
        return false;
    }  
    public function logout() {
        $_SESSION['user'] = null;  
    }
    public function getValue($key = '') {
        if(array_key_exists($key, $this->data)){
            return $this->data[$key];
        }
        return 'error';
    }
}
?>