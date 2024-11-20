<?php 

namespace Framework;

class SessionManager {

    public function start() { //ensures there is ONE unique session PER user
        if (session_status() == PHP_SESSION_NONE){ //check to see if there is a session 
            session_start(); //if not start the session

        }
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return $_SESSION[$key] ?? null;
    }

    public function remove($key) {
        unset($_SESSION[$key]);
    }

    public function has($key) {
        return isset($_SESSION[$key]);
    }

    public function destroy() {
        session_unset();
        session_destroy();
    }
}