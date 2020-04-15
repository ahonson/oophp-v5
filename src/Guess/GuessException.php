<?php

namespace arts19\Guess;

/**
 * Exception class for PersonAgeException.
 */
class GuessException extends \Exception
{
    /**
    * @return string to show an error message.
    */
    public function errorMessage()
    {
        return "A valid guess is within the range 1-100.";
    }
}
