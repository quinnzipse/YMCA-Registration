<?php

/**
 * Class User
 *
 * Abstraction of our the average User.
 */
class User
{
    public function __construct(int $userID)
    {

    }

    function register($classID){
        // TODO: Implement this function to allow users to register for classes.
    }

    function isFree($classID){
        // TODO: Check to see if the user is registered for another class during this time.
    }

    // TODO: Steal getUser from auth.php
    // TODO: Create a function that save user to database.
}