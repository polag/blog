<?php

namespace DataHandle;

require_once __DIR__ . '/db.php';

use Mysqli;
use Exception;

class Books extends FormHandle
{
    public static function insertBook($form_data)
    {
        $autori = explode(',',$form_data['autore']);
            $fields = array(
            'titolo'          => $form_data['titolo'],
            'ISBN'       => $form_data['ISBN'],
            'copertina'       => $form_data['copertina'],
            'data_pubblicazione'          => $form_data['data_pubblicazione'],
            'genere'          => $form_data['genere']
            /* 'autore' => $form_data['autore'],
            'data_nascita' => $form_data['data_nascita'],
            'data_morte' => $form_data['data_morte'],
            'bio' => $form_data['bio'], */

        );


        if ($fields) {
            global $mysqli;


            $query_check = $mysqli->query("SELECT * FROM libro WHERE ISBN='".$fields['ISBN']."' AND titolo='".$fields['titolo']."'" );

            if ($query_check->num_rows == 0) {
                $query = $mysqli->prepare('INSERT INTO libro(titolo, ISBN, copertina, data_pubblicazione, genere) VALUES (?,?,?,?,?)');

                $query->bind_param('sssss', $fields['titolo'], $fields['ISBN'], $fields['copertina'], $fields['data_pubblicazione'], $fields['genere']);
                $query->execute();
                $query_id_libro = $mysqli->query("SELECT @@IDENTITY AS 'id'");
                $id_libro = $query_id_libro->fetch_assoc();
                $id_libro = $id_libro['id'];
                if ($query->affected_rows === 0) {
                    error_log('Errore MySQL: ' . $query->error_list[0]['error']);
                    header('Location: https://localhost/biblioteca/insert-book.php?stato=ko');
                    exit;
                }
                for($i=0;$i<count($autori);$i++){
                    $query_check = $mysqli->query("SELECT * FROM autore WHERE nome='".$autori[$i]."'");
                    if ($query_check->num_rows == 0) {
                        $query_autore = $mysqli->prepare('INSERT INTO autore(nome) VALUES (?)');
                        $query_autore->bind_param('s', $autori[$i]);
                        $query_autore->execute();
                        $query_id_autore = $mysqli->query("SELECT @@IDENTITY AS 'Identity'");
                        $id_autore = $query_id_autore->fetch_assoc();
                        $id_autore = $id_autore['Identity'];

                    }
                    else{
                        $autore = $query_check->fetch_assoc();
                        $id_autore = $autore['id'];

                    }
                    
                    $query_libaut = $mysqli->prepare('INSERT INTO autore_libro(id_autore,id_libro) VALUES (?,?)');
                    $query_libaut->bind_param('ii', $id_autore, $id_libro);
                    $query_libaut->execute();

                }
                header('Location: https://localhost/biblioteca/insert-book.php?stato=ok');
                exit;
            }else{
                header('Location: https://localhost/biblioteca/insert-book.php?stato=exists');
                exit;
            } 
        
           
        }
    }

    public static function selectBook($id = null, $userId = null)
    {

        global $mysqli;

        if ($id and !$userId) {
            $query = $mysqli->query('SELECT titolo, descrizione, copertina, ISBN, data_pubblicazione, genere, autore.nome
                FROM libro JOIN autore_libro ON libro.id = autore_libro.id_libro 
                JOIN autore ON autore.id = autore_libro.id_autore WHERE libro.id =' . $id);
            $results = $query->fetch_assoc();
       /*  } elseif ($userId and !$id) {
            $query = $mysqli->query('SELECT post.id, title, content, summary, post.image,  created_at,updated_at, published_at, username, published 
            FROM post JOIN user ON post.author_id = user.id WHERE user.id =' . $userId);
            $results = array();

            while ($row = $query->fetch_assoc()) {

                $results[] = $row;
            } */
       /*  } elseif ($userId and $id) {
            $query = $mysqli->query('SELECT title, content, summary, post.image, published, created_at,updated_at, published_at, username 
            FROM post JOIN user ON post.author_id = user.id WHERE user.id =' . $userId . ' AND post.id = ' . $id);
            $results = $query->fetch_assoc(); */
        } else {
            $query = $mysqli->query('SELECT titolo, descrizione, copertina, ISBN, data_pubblicazione, genere, autore.nome
            FROM libro JOIN autore_libro ON libro.id = autore_libro.id_libro 
            JOIN autore ON autore.id = autore_libro.id_autore');


            $results = array();

            while ($row = $query->fetch_assoc()) {
                $results[] = $row;
            }
        }
        return $results;
    }

    public static function updateBook($form_data, $id)
    {

        $fields = array(
            'title'          => $form_data['title'],
            'content'       => $form_data['content'],
            'summary'       => $form_data['summary'],
            'image'          => $form_data['image']

        );

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
                $query->bind_param('ssssii', $fields['title'], $fields['content'], $fields['summary'], $fields['image'], $id, $userId);
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
                    header('Location: https://localhost/biblioteca/manage-post.php?id=' . $id . '&stato=ko');
                    exit;
                }
            }

            $stato = $is_in_error ? 'ko' : 'ok';
            header('Location: https://localhost/biblioteca/manage-post.php?id=' . $id . '&stato=' . $stato . '&update=1');
            exit;
        }
    }
    public static function deleteBook($userId, $id = null)
    {
        global $mysqli;

        $is_in_error = false;

        if ($id) {
            $id = intval($id);
            try {
                $query = $mysqli->prepare('DELETE FROM post WHERE id = ? AND author_id = ?');

                if (is_bool($query)) {
                    $is_in_error = true;
                    throw new Exception('Query non valida. $mysqli->prepare ha restituito false.');
                }
                $query->bind_param('ii', $id, $userId);
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
                    header('Location: https://localhost/biblioteca/manage-post.php?id=' . $id . '&stato=ko');
                    exit;
                }
            }
            $stato = $is_in_error ? 'ko' : 'ok';
            header('Location: https://localhost/biblioteca/manage-post.php?id=' . $id . '&stato=' . $stato . '&delete=1');
            exit;
        } else {
            try {
                $query = $mysqli->prepare('DELETE FROM post WHERE author_id = ?');
                if (is_bool($query)) {
                    $is_in_error = true;
                    throw new Exception('Query non valida. $mysqli->prepare ha restituito false.');
                }

                $query->bind_param('i', $userId);
                $query->execute();
            } catch (Exception $e) {
                error_log("Errore PHP in linea {$e->getLine()}: " . $e->getMessage() . "\n", 3, 'my-errors.log');
            }

            if (count($query->error_list) > 0) {
                $is_in_error = true;
                foreach ($query->error_list as $error) {
                    error_log("Errore MySQL n. {$error['errno']}: {$error['error']} \n", 3, 'my-errors.log');
                }
                header('Location: https://localhost/biblioteca/manage-post.php?id=' . $id . '&stato=ko');
                exit;
            }


            $stato = $is_in_error ? 'ko' : 'ok';
            header('Location: https://localhost/biblioteca/manage-post.php?id=' . $id . '&stato=' . $stato . '&delete=1');
            exit;
        }
    }
    public static function publishPost($publish, $id, $userId)
    {
        global $mysqli;
        $publish          = intval($publish);
        $id          = intval($id);
        $userId          = intval($userId);
        $query = $mysqli->prepare('UPDATE post SET published = ? WHERE id = ? AND author_id = ? ');
        $query->bind_param('iii', $publish, $id, $userId);
        $query->execute();

        if ($query->affected_rows === 0) {
            error_log('Errore MySQL: ' . $query->error_list[0]['error']);
            header('Location: https://localhost/biblioteca/manage-post.php?stato=ko');
            exit;
        }


        header('Location: https://localhost/biblioteca/manage-post.php?stato=ok&publish='.$publish);
        exit;
    }
}
