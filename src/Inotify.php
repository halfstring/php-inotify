<?php

namespace php_inotify;

/**
 * Class Inotify
 *
 * @package \\${NAMESPACE}
 */
abstract class Inotify
{
    use TraitDir;

    private $inotify = null;

    public function __construct()
    {
        $this->inotify = inotify_init();
    }

    /**
     * 监控回调处理函数
     *
     * @param $result
     *
     * @return mixed
     * @author Kalep ( kalepsong@gmail.com )
     */
    abstract function callFunc($result);

    /**
     * 过滤回调
     *
     * @return mixed
     * @author Kalep ( kalepsong@gmail.com )
     */
    abstract function filter(&$res);

    public function run()
    {
        swoole_event_add($this->inotify, function () {
            $events = inotify_read($this->inotify);
            if ($events) {
                foreach ($events as $event) {
                    if ($this->filter($event)) {
                        $this->callFunc([
                            'dir'   => $this->_getDir($event['wd']),
                            'event' => $event,
                        ]);
                    }
                }
            }
        });

        swoole_event_wait();
    }


}
