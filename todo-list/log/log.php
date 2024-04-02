<?php
    // Load configs
    require_once __DIR__ . '/../config.php';

    // Load Monolog component
    require_once __ROOT__ . '/vendor/autoload.php';

    // import Monolog logger
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    use \Monolog\Formatter\LineFormatter;

    // create a log channel
    $log = new Logger('secureApplication');

    // Create a formatter
    $formatter = new LineFormatter(null, null, false, true);

    // Create a Log-File Handler and assign the formatter
    // Logs and creates a new logfile for every day
    $handler = new StreamHandler(__ROOT__ . '/log/log.' . date("Y.m.d") . '.txt');
    $handler->setFormatter($formatter);

    $log->pushHandler($handler);
?>
