<?php
namespace DataHandle;

require_once __DIR__.'/db.php';

use Mysqli;
use Exception;

class Comment{
    
    public static function selectComments($id)
    {

        global $mysqli;
        
       
            $query = $mysqli->query('SELECT comment.id, comment.content, user.username, user.image, comment.date, comment.user_id 
                FROM comment 
                JOIN user ON comment.user_id = user.id 
                JOIN post ON comment.post_id = post.id
                WHERE post.id =' .$id);
                
        

            $results = array();

            while ($row = $query->fetch_assoc()) {
                $results[] = $row;
            }
        
        return $results;
    }

     public static function countComments($id)
    {
        global $mysqli;
       
        $query = $mysqli->query('SELECT count(*) as quantity FROM comment where post_id = ' .$id);
        $result = $query->fetch_assoc();

        return $result;
    } 

    public static function createComment($content, $id, $loggedInUserId)
    {
        global $mysqli;
        
       
        $query = $mysqli->prepare('INSERT INTO comment(content, user_id, post_id) VALUES (?, ?, ?)');
        
        $query->bind_param('sii', $content, $loggedInUserId,  $id);
        $query->execute();

        if ($query->affected_rows === 0) {
            error_log('Errore MySQL: ' . $query->error_list[0]['error']);
            header('Location: https://localhost/biblioteca/index.php?stato=ko');
            exit;
        }


        header('Location: https://localhost/biblioteca/post-view.php?stato=ok&comment=1&id='.$id);
        exit;


    }


    public static function deleteComment($id, $loggedInUserId, $postId)
    {
        global $mysqli;
        $id = intval($id);
        $loggedInUserId = intval($loggedInUserId);
        $postId = intval($postId);
       
        $query = $mysqli->prepare('DELETE FROM comment WHERE id = ? AND user_id = ? AND post_id= ?');
        
        $query->bind_param('iii', $id,$loggedInUserId,$postId);
        $query->execute();

        if ($query->affected_rows === 0) {
            error_log('Errore MySQL: ' . $query->error_list[0]['error']);
            header('Location: https://localhost/biblioteca/post-view.php?stato=ko');
            exit;
        }


        header('Location: https://localhost/biblioteca/post-view.php?stato=ok&comment=1&id='.$postId);
        exit;



    }


    
}
