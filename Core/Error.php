<?php

namespace Core;

class Error
{
    /**
     * ErrorHandler. Convert all errors to Exception by throw an ErrorException.
     * @param int $level Error level
     * @param string $message Error message
     * @param string $file Filename the error was raised in
     * @param int $line Line number in the file
     * @throws \ErrorException
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() != 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler.
     *
     * @param \Exception $exception
     */
    public static function exceptionHandler($exception)
    {
        // Code is 404(not found) or 500(general error)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);

        if (\App\Config::SHOW_ERRORS) {

            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception:" . $exception->getMessage() . "</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " .
                $exception->getLine() . "</p>";
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);

            $message = "Uncaught exception: '" . get_class($exception) . "''";
            $message .= "with message '" . $exception->getMessage() . "''";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line '" . $exception->getLine();

            error_log($message);

//            if ($code == 404) {
//                echo "<h1>Page not found</h1>";
//            } else {
//                echo "<h1>An error occurred</h1>";
//            }

            View::renderTemplate("$code.twig");
        }

    }
}