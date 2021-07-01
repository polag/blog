<?php
namespace DataHandle;

require_once __DIR__.'/db.php';

use \DataHandle\Utils\InputSanitize;
use Mysqli;
use Exception;

class User
{
    use \DataHandle\Utils\InputSanitize;
    public static function sanitize($fields)
    {
        $errors        = array();
        $fields['username'] = self::cleanInput($fields['username']); 
        $fields['firstname'] = self::cleanInput($fields['firstname']); 
        $fields['lastname'] = self::cleanInput($fields['lastname']); 
        // Sanificare numero di telefono e verificarne la validità
        $fields['phone'] = self::cleanInput($fields['phone']);
        if (self::isPhoneNumberValid($fields['phone']) === 0) {
            $errors[] = new Exception('Phone number not valid.');
        }

        
         // Sanificare email e verificarne la validità
         if (isset($fields['email']) && $fields['email'] !== '') {
            $fields['email'] = self::cleanInput($fields['email']);
            if (!self::isEmailAddressValid($fields['email'])) {
                $errors[] = new Exception('E-mail address not valid.');
            }
        } 

        

        if (count($errors) > 0) {
            return $errors;
        }

        return $fields;  
    }
    


    public static function registerUser($form_data)
    {

        $fields = array(
            'username'        => $form_data['username'],
            'password'        => $form_data['password'],
            'password-check'  => $form_data['password-check'],
            'firstname'        => $form_data['firstname'],
            'lastname'        => $form_data['lastname'],
            'phone'        => $form_data['phone'],
            'email'        => $form_data['email'],
        );

        $fields = self::sanitize($fields);

        if ($fields[0] instanceof Exception) {
            $error_messages = '';
            foreach ($fields as $key => $error) {
                $error_messages .= $error->getMessage();
                if ($key < count($fields) - 1) {
                    $error_messages .= '|';
                }
            }
            header('Location: https://localhost/blog/registration.php?stato=errore&messages='
                . $error_messages);
            exit;
        }
        if ($fields['password'] !== $fields['password-check']) {
            header('Location: https://localhost/blog/registration?stato=errore&messages=Passwords are different');
            exit;
        }
        
        global $mysqli;
        //check if username already exists
        $query_user = $mysqli->query("SELECT username FROM user WHERE username = '" . $fields['username'] . "'");

        if ($query_user->num_rows > 0) {
            header('Location: https://localhost/blog/registration.php?stato=errore&messages=Username already in use');
            exit;
        }
        $query_user->close();
        //check if email already registered
        $query_email = $mysqli->query("SELECT email FROM user WHERE email = '" . $fields['email'] . "'");

        if ($query_email->num_rows > 0) {
            header('Location: https://localhost/blog/registration.php?stato=errore&messages=Email already registered. Do you want to <a href="/blog/login.php"> LOG IN </a> instead?');
            exit;
        }
        
        $query_email->close();
    
        $query = $mysqli->prepare('INSERT INTO user(username, firstname, lastname, email, phone, password) VALUES (?, ?,?,?,?,MD5(?))');
        $query->bind_param('ssssss', $fields['username'],$fields['firstname'],$fields['lastname'],$fields['email'],$fields['phone'], $fields['password']);
        $query->execute();

        if ($query->affected_rows === 0) {
            error_log('Error MySQL: ' . $query->error_list[0]['error']);
            header('Location: https://localhost/blog/registration.php?stato=ko');
            exit;
        }

        header('Location: https://localhost/blog/login.php?stato=ok');
        exit;
    }

    public static function loginUser($form_data)
    {

        $fields = array(
            'username'  => $form_data['username'],
            'password'  => $form_data['password']
        );

        

        global $mysqli;

        $query_user = $mysqli->query("SELECT * FROM user WHERE username = '" . $fields['username'] . "'");
        if ($query_user->num_rows === 0) {
            header("Location: https://localhost/blog/login.php?stato=errore&messages=User doesn't exist");
            exit;
        }

        $user = $query_user->fetch_assoc();

        if ($user['password'] !== md5($fields['password'])) {
            header('Location: https://localhost/blog/login.php?stato=errore&messages=Wrong password');
            exit;
        }

        return array(
            'id'  => $user['id'],
            'username' => $user['username']
        );
    }

    public static function deleteUser($userId)
    {
        global $mysqli;
        $userId = intval($userId);
        $query = $mysqli->prepare('DELETE FROM utenti WHERE id = ?');
        $query->bind_param('i', $userId);
        $query->execute();
        
        if ($query->affected_rows > 0) {
            session_destroy();
            unset($_SESSION['username']);
            header('Location: https://localhost/rubrica-paula/login.php?logout=1');
            exit; 
        } else {
            //var_dump($query);
            header('Location: https://localhost/rubrica-paula/admin.php=stato=ko');
            exit;
        }
    }

    public static function selectUser($userId)
    {
        global $mysqli;

        $query_user = $mysqli->query("SELECT * FROM user WHERE id = ". $userId );
        $user = $query_user->fetch_assoc();
        return $user;
    }

    
}
