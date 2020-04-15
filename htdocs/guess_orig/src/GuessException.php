<?php

/**
 * Exception class for PersonAgeException.
 */
class GuessException extends Exception
{
    public function errorMessage()
    {
        return "A valid guess is within the range 1-100.";
    }
}
