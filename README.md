# php-inotify

`文件变更监控，因变更引起的后续页面逻辑可实现抽象回调函数实现。`

## demo （example/FileInotify.php ）

## 扩展需要实现

- callFunc($result) # 监控时间后置回调
- filter(&$event) # 结果回调前置过滤

