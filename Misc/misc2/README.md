# telnet&简单流量分析

---

为什么要用telnet偷偷干坏事呢，让我们看看做了什么：
1.攻击者用户名密码是多少            eg：admin/123456
2.攻击者第一条命令是什么            eg：ifconfig
3.对方家目录倒数第二个文件是什么     eg：home
4.flag的目录是什么                 eg：/root

提交flag（每个答案拼接然后md5加密），
eg：admin/123456_ifconfig_home_/root
flag{f42e42141e7aefcd6d8653829f2867c7}
> By Ruxi
