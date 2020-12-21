<?php
/**
 * Created by Alex Negoita
 * IDE: PHP Storm
 * Date: 6/25/2019
 * Time: 2:02 PM
 * PHP Version 7
 */

namespace rpa\erektorcore;
use PDO;
use rpa\erektorcoreToken;

class Tracker extends \Core\Model
{
    private $id;
    private $ip;
    private $session;
    private $user_agent;
    private $referer;
    private $page;
    private $cookie_exp = '';


    function __construct()
    {

        if ( isset($_COOKIE['vis']) && !empty($_COOKIE['vis'])) {
            $token              = new Token($_COOKIE['vis']);
            $this->token        = $token->getValue();
            $this->hash         = $token->getHash();
        } else {
            $token              = new Token();
            $this->token        = $token->getValue();
            $this->hash         = $token->getHash();
        }


        $this->id;

        $this->ip           = $_SERVER['REMOTE_ADDR'];
        $this->user_agent   = $_SERVER['HTTP_USER_AGENT'];
        $this->page         = $_SERVER['REQUEST_URI'];
        $this->referer      = $_SERVER['HTTP_REFERER'] ?? NULL;
        $this->session      = session_id();

        $this->cookie_exp   = time() + 60*60*24*45; // 45 days

        $this->run();
    }


    public function run()
    {
        if ( !isset($_COOKIE['vis']) ) {

            setcookie('vis', $this->token, $this->cookie_exp, '/');
            $this->addNewVisitor();

        } else{

            setcookie('vis', $this->token, $this->cookie_exp, '/');
            $old_user = $this->findUserByToken($this->token);
            if ($old_user) {
                $this->id = $old_user->id;
                $this->addNewView($this->id);
            }

        }
    }


    private function findUserByToken($token)
    {

        $token = new Token($token);
        $hashed_token = $token->getHash();

        $sql = "SELECT * FROM viewers WHERE cookie_token = :cookie_token";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':cookie_token', $hashed_token, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    private function addNewView($id)
    {

        $sql = "INSERT INTO views
                (viewer_id, referer, page)
                VALUES
                (:viewer_id, :referer, :page)";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':viewer_id', $id);
        $stmt->bindParam(':referer', $this->referer);
        $stmt->bindParam(':page', $this->page);

        return $stmt->execute();
    }

    private function addNewVisitor()
    {
        $token = New Token($this->token);
        $hased_token = $token->getHash();



        $sql = "INSERT INTO viewers 
                (ip, session, user_agent, cookie_token) 
                VALUES
                (:ip, :session, :user_agent, :cookie_token);";

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':ip', $this->ip, PDO::PARAM_STR);
        $stmt->bindValue(':session', $this->session, PDO::PARAM_STR);
        $stmt->bindValue(':user_agent', $this->user_agent, PDO::PARAM_STR);
        $stmt->bindValue(':cookie_token', $hased_token, PDO::PARAM_STR);

        $stmt->execute();

        $this->id = $db->lastInsertId();

        $sql2 = "INSERT INTO views
                (viewer_id, referer, page) 
                VALUES
                (:viewer_id, :referer, :page)";

        $stmt = $db->prepare($sql2);

        $stmt->bindValue(':viewer_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':referer', $this->referer, PDO::PARAM_STR);
        $stmt->bindValue(':page', $this->page, PDO::PARAM_STR);

        $stmt->execute();

    }

    public function validate(): bool
    {
        return empty($this->errors) ?? false;
    }
}