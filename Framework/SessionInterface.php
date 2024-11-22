<?php

namespace Framework;


interface SessionInterface {
    public function start(); // Ensures there is one unique session per user
    public function set($key,  $value); // Sets a session value
    public function get( $key); // Gets a session value
    public function remove( $key); // Removes a session value
    public function has( $key); // Checks if a session key exists
    public function destroy(); // Destroys the session
}
