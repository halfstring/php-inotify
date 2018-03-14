<?php

namespace php_inotify;

/**
 * Class traitDir
 *
 * @package \php_inotify
 */
trait TraitDir
{
    private $watchDirs = [];
    private $wds       = [];

    public function addDir($dir, $mask = IN_MODIFY | IN_CREATE | IN_DELETE, $r = false)
    {
        $key = md5($dir);

        if (!isset($this->watchDirs[$key])) {
            $wd                    = inotify_add_watch($this->inotify, $dir, $mask);
            $this->wds[$wd]        = $dir;
            $this->watchDirs[$key] = array(
                'wd'   => $wd,
                'path' => $dir,
                'mask' => $mask,
            );
        }

        return $this;
    }

    public function addDirs($dirs)
    {
        foreach ($dirs as $dir) {
            $this->addDir($dir);
        }

        return $this;
    }

    public function removeDir($dir)
    {
        $key = md5($dir);
        if (isset($this->watchDirs[$key])) {
            $wd = $this->watchDirs[$key]['wd'];
            if (inotify_rm_watch($this->inotify, $wd)) {
                unset($this->watchDirs[$key]);
            }
        }

        return $this;
    }

    private function _getDir($wd)
    {
        if (is_array($this->watchDirs)) {
            foreach ($this->watchDirs as $item) {
                if ($wd == $item['wd']) {
                    return $item['path'];
                }
            }
        }

        return '';
    }

}
