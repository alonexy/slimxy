## slimxy
```
基于Slim框架 【https://www.slimframework.com/docs/】
利用composer不断扩展
打造适合自己的php开发框架


实现aop结构
实现路由
实现中间件
实现模版应用
实现cli
实现任务队列
实现env

增加 Swoole 支持http Server
php bin/Slimxy
```
### resque

```
QUEUE – 这个是必要的，会决定 worker 要执行什么任务，重要的在前，例如 QUEUE=notify,mail,log 。也可以设定為 QUEUE=* 表示执行所有任务。
APP_INCLUDE – 可选，加载文件用的。可以设成 APP_INCLUDE=require.php ，在 require.php 中引入所有 Job 的 Class即可。
COUNT – 设定 worker 数量，预设是1 COUNT=5 。
LOGGING, VERBOSE – 设定 log， VERBOSE=1 即可。
VVERBOSE – 比较详细的 log， VVERBOSE=1 debug 的时候可以开出来看。
INTERVAL – worker 检查 queue 的间隔，预设是五秒 INTERVAL=5 。
PIDFILE – 如果你是开单 worker，可以指定 PIDFILE 把 pid 写入，例如 PIDFILE=/var/run/resque.pid 。

```
