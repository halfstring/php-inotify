# php-inotify

`使用场景：自动监控文件变更，扩展各自回调以使用后续的触发逻辑。例如，如果有文件变更，某服务重启之类。`

## demo （example/FileInotify.php ）

## 扩展需要实现

- callFunc($result) # 监控时间后置回调
- filter(&$event) # 结果回调前置过滤

## 场景举例

 \> php ./swoole.com | xargsphp ./daemon.php
