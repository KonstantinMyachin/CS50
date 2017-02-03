#include <stdio.h>
#include <cs50.h>
#include <ctype.h>
#include <string.h>

int main(void) {
    string s = GetString();
    for (int i = 0, n = strlen(s); i < n; i++) {
        if (i == 0)
            printf("%c", toupper(s[i]));
        else if (isspace(s[i - 1]))
            printf("%c", toupper(s[i]));
    }
    
    printf("\n");
}