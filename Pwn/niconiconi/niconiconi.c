#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <fcntl.h>
#include <unistd.h>

char flag_buffer[1024] = {0};
int flag_len = 0;

int init_func()
{
    setvbuf(stdin, 0, 2, 0);
    setvbuf(stdout, 0, 2, 0);
    setvbuf(stderr, 0, 2, 0);

    return 0;
}

unsigned long long resolve_address(const char *addr_str)
{
    char bin_str[256] = {0};
    int i = 0;
    while (addr_str[i] != '\0')
    {
        if (strncmp(&addr_str[i], "co", 2) == 0)
        {
            strcat(bin_str, "0");
            i += 2;
        }
        else if (strncmp(&addr_str[i], "ni", 2) == 0)
        {
            strcat(bin_str, "1");
            i += 2;
        }
        else
        {
            i++;
        }
    }
    return strtoull(bin_str, NULL, 2);
}

int main()
{
    init_func();
    int fd = open("/flag", O_RDONLY);
    flag_len = read(fd, flag_buffer, sizeof(flag_buffer) - 1);
    close(fd);
    flag_buffer[flag_len] = '\0';

    char addr_str[512] = {0};
    printf("nico nico ni?\n");
    scanf("%[^\n]", addr_str);

    unsigned long long addr = resolve_address(addr_str);
    printf("%s\n", (char *)addr);

    return 0;
}