<?php
namespace DataHandle;

require_once __DIR__.'/db.php';

//use \DataHandle;
use Mysqli;
use Exception;

class Posts extends FormHandle
{
    //use \DataHandle;
    protected static function sanitize($fields)
    {
        /*  $errors        = array();
        /* $fields['nome'] = self::cleanInput($fields['nome']); */
        // Sanificare numero di telefono e verificarne la validità
       /*  $fields['telefono'] = self::cleanInput($fields['telefono']);
        if (self::isPhoneNumberValid($fields['telefono']) === 0) {
            $errors[] = new Exception('Numero di telefono non valido.'); */
        }

        /* // Sanificare organizzazione
        if (isset($fields['organizzazione']) && $fields['organizzazione'] !== '') {
            $fields['organizzazione'] = self::cleanInput($fields['organizzazione']);
        }
 */
       /*  // Sanificare email e verificarne la validità
        if (isset($fields['email']) && $fields['email'] !== '') {
            $fields['email'] = self::cleanInput($fields['email']);
            if (!self::isEmailAddressValid($fields['email'])) {
                $errors[] = new Exception('Indirizzo email non valido.');
            }
        } */ 

        /* // Sanificare indirizzo
        if (isset($fields['indirizzo']) && $fields['indirizzo'] !== '') {
            $fields['indirizzo'] = self::cleanInput($fields['indirizzo']);
        }

        // Sanificare compleanno e verificare che sia una data.
        if (isset($fields['compleanno']) && $fields['compleanno'] !== '') {
            $fields['compleanno'] = self::cleanInput($fields['compleanno']);
            if (strtotime($fields['compleanno'])) {
                // Converte la data nel formato previsto da MySQL.
                $fields['compleanno'] = date('Y-m-d', strtotime(str_replace('-', '/', $fields['compleanno'])));
            } else {
                $errors[] = new Exception('Data di compleanno non valida.');
            } 
        }*/
/* 
        if (count($errors) > 0) {
            return $errors;
        }

        return $fields;  */
    
    

    public static function createPost($form_data, $loggedInUserId)
    {
        if (isset($form_data['publish'])) {
            $publish = 1;
            $published_date = date('Y-m-d');
        } else {
            $publish = 0;
            $published_date = null;
        }

        $fields = array(
            'title'          => $form_data['title'],
            'content'       => $form_data['content'],
            'summary'       => $form_data['summary'],
            'image'          => $form_data['image']

        );

       // $fields = self::sanitize($fields);

    
        if ($fields) {
           global $mysqli;

            $query = $mysqli->prepare('INSERT INTO post(title, content, summary, image, published_at, published,  author_id) VALUES (?, ?, ?, ?,?, ?,?)');
            
            $query->bind_param('sssssii', $fields['title'], $fields['content'], $fields['summary'], $fields['image'], $published_date, $publish, $loggedInUserId);
            $query->execute();


            if ($query->affected_rows === 0) {
                error_log('Errore MySQL: ' . $query->error_list[0]['error']);
                header('Location: https://localhost/blog/create-post.php?stato=ko');
                exit;
            }

           
            header('Location: https://localhost/blog/create-post.php?stato=ok');
            exit;
        }
        var_dump($fields);

    }

    public static function selectPost($id = null, $userId = null)
    {

        global $mysqli;
        
        if ($id AND !$userId) {
            $query = $mysqli->query('SELECT title, content, summary, post.image, created_at, username 
                FROM post JOIN user ON post.author_id = user.id WHERE post.id =' .$id);
                $results = $query->fetch_assoc();
        } elseif ($userId AND !$id){
            $query = $mysqli->query('SELECT post.id, title, content, summary, post.image, created_at,updated_at, published_at, username 
            FROM post JOIN user ON post.author_id = user.id WHERE user.id =' .$userId);
             $results = array();

             while ($row = $query->fetch_assoc()) {
                
                 $results[] = $row;
             }
        }
        elseif($userId AND $id){
            $query = $mysqli->query('SELECT title, content, summary, post.image, created_at,updated_at, published_at, username 
            FROM post JOIN user ON post.author_id = user.id WHERE user.id =' .$userId.' AND post.id = '.$id);
            $results = $query->fetch_assoc();
        }else
        {
            $query = $mysqli->query('SELECT post.id, title, content, summary, post.image, created_at, username 
                FROM post JOIN user ON post.author_id = user.id WHERE published = 1');


            $results = array();

            while ($row = $query->fetch_assoc()) {
                $results[] = $row;
            }

            
        }
        return $results;
    }

    public static function updatePost($form_data, $id, $userId)
    {        

        $fields = array(
            'title'          => $form_data['title'],
            'content'       => $form_data['content'],
            'summary'       => $form_data['summary'],
            'image'          => $form_data['image']

        );

        $fields = self::sanitize($fields);

        if ($fields) {
            global $mysqli;

            $id          = intval($id);
            $is_in_error = false;

            try {
                $query = $mysqli->prepare('UPDATE post SET title = ?, content = ?, summary = ?, image = ? WHERE id = ? AND author_id = ? ');
                if (is_bool($query)) {
                    $is_in_error = true;
                    throw new Exception('Query non valida. $mysqli->prepare ha restituito false.');
                }
                $query->bind_param('ssssii', $fields['title'], $fields['content'],$fields['summary'],$fields['image'], $id, $userId);
                $query->execute();
            } catch (Exception $e) {
                error_log("Errore PHP in linea {$e->getLine()}: " . $e->getMessage() . "\n", 3, 'my-errors.log');
            }

            if (!is_bool($query)) {
                if (count($query->error_list) > 0) {
                    $is_in_error = true;
                    foreach ($query->error_list as $error) {
                        error_log("Errore MySQL n. {$error['errno']}: {$error['error']} \n", 3, 'my-errors.log');
                    }
                    header('Location: https://localhost/blog/edit-post.php?id=' . $id . '&stato=ko');
                    exit;
                }
                
            }

            $stato = $is_in_error ? 'ko' : 'ok';
            header('Location: https://localhost/blog/edit-post.php?id=' . $id . '&stato=' . $stato);
            exit;
        }
    }
    public static function deletePost( $userId, $id = null)
    {
       global $mysqli;

        if ($id) {
            $id = intval($id);

            $query = $mysqli->prepare('DELETE FROM post WHERE id = ? AND author_id = ?');
            $query->bind_param('ii', $id, $userId);
            $query->execute();

            

            if ($query->affected_rows > 0) {
                header('Location: https://localhost/blog/manage-post.php?stato=ok');
                exit;
            } else {
                header('Location: https://localhost/blog/manage-post.php?stato=ko');
                exit;
            }
        }/* else{

            $query = $mysqli->prepare('DELETE FROM post WHERE author_id = ?');
            $query->bind_param('i', $userId);
            $query->execute();


            if ($query->affected_rows > 0) {
                header('Location: https://localhost/blog/manage-post?statocanc=ok');
                exit;
            } else {
                header('Location: https://localhost/blog/manage-post?statocanc=ko');
                exit;
            }
        } */

    }

}
