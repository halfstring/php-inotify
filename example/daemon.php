<?php
require(__DIR__.'/vendor/autoload.php');

class FileInotify extends php_inotify\Inotify
{
    public function callFunc($result)
    {
        echo "callFunc\n";
        print_r($result);
        echo "\n============\n";
    }

    public function filter(&$event)
    {
        if (!preg_match('/\.swp|\.swx|~|4913$/', $event['name'])) {
            return true;
        }

        return false;
    }
}

$inotify = new FileInotify();
$inotify->addDir('./');
$inotify->run();
