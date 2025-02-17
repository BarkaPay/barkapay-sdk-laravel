<?php

if (!function_exists('logMessage')) {
    /**
     * Log a message to a specific log type and category.
     *
     * @param mixed  $message   The message to log. Can be a string or an array.
     * @param string $category  The category or repository to log the message under.
     * @param string $type      The type of log (e.g., 'info', 'errors', 'warnings').
     */
    function logMessage($message, $category, $type = 'info')
    {
        // Base directory for logs
        $baseDir = dirname(__DIR__, 1) . "/../storage/logs/BARKAPAY/{$type}/" . $category;

        // Directory structure based on date and time
        $date = date('Y-m-d');
        $hourBlock = ceil(date('H') / 6) * 6;
        $filename = "{$date}-{$hourBlock}.log";
        $path = "$baseDir/$date";

        // Create directories if they do not exist
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // Full log file path
        $filePath = "$path/$filename";

        // Write log entry
        file_put_contents($filePath, formatLogEntry($message), FILE_APPEND);
    }
}
if (!function_exists('formatLogEntry')) {
    /**
     * Format a log entry for writing to a file.
     *
     * @param mixed $message The message to format. Can be a string or an array.
     *
     * @return string The formatted log entry.
     */
    function formatLogEntry($message)
    {
        if (is_array($message)) {
            $message = json_encode($message, JSON_PRETTY_PRINT);
        }

        return date('Y-m-d H:i:s') . " - " . $message . PHP_EOL;
    }
}


if (!function_exists('logError')) {
    /**
     * Log an error message.
     *
     * @param mixed  $message   The error message to log.
     * @param string $category  The category or repository to log the error under.
     */
    function logError($message, $category = 'General')
    {
        logMessage($message, $category, 'errors');
    }
}

if (!function_exists('logInfo')) {
    /**
     * Log an informational message.
     *
     * @param mixed  $message   The informational message to log.
     * @param string $category  The category or repository to log the message under.
     */
    function logInfo($message, $category)
    {
        logMessage($message, $category, 'info');
    }
}

if (!function_exists('logWarning')) {
    /**
     * Log a warning message.
     *
     * @param mixed  $message   The warning message to log.
     * @param string $category  The category or repository to log the warning under.
     */
    function logWarning($message, $category)
    {
        logMessage($message, $category, 'warnings');
    }
}
