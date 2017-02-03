#include <stdio.h>
#include <cs50.h>
#include <string.h>
#include <stdlib.h>
#include <ctype.h>

int main(int argc, string argv[]) {
    if (argc != 2) {
        printf("Print the key next time.\n");
        return 1;
    }
        
    int k = atoi(argv[1]);
    if (k < 0) {
        printf("Key (%i) must be a non-negative integer.\n", k);
        return 1;
    }
    
    if (k >= 26)
        k = k % 26;

    string p = GetString();

    for (int i = 0, n = strlen(p); i < n; i++) {
        if (!isalpha(p[i])) {
            printf("%c", p[i]);
        } else {
            int c = (int) p[i] + k;
            
            if (isupper(p[i])) {
                if (c > 90)
                    c = 64 + c - 90;
            } else if (c > 122)
                c = 96 + c - 122;
                
            printf("%c", (char) c);
        }
    }
    
    printf("\n");
    return 0;
}