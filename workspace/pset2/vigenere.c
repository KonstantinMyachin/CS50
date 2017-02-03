#include <stdio.h>
#include <cs50.h>
#include <string.h>
#include <ctype.h>

int main(int argc, string argv[]) {
    if (argc != 2) {
        printf("Print the key next time.\n");
        return 1;
    }
    
    string k = argv[1];
    int klen = strlen(k);
    for (int i = 0; i < klen; i++) {
        if (!isalpha(k[i])) {
            printf("The key contains invalid character.\n");
            return 1;
        }
    }
    
    string s = GetString();

    int ki = 0;
    for (int i = 0, n = strlen(s); i < n; i++) {
        char c = s[i];
        if (!isalpha(c)) {
            printf("%c", c);
            continue;
        }
        
        if (ki > klen - 1)
            ki = 0;
            
        char kc = k[ki];
        int ci = (int) kc;
        if(isupper(kc))
            ci = ci - 65;
        else
            ci = ci - 97;
            
        ci = ci + (int) c;
        if(isupper(c)) {
            if (ci > 90)
                ci = 64 + ci - 90;
        } else if (ci > 122)
            ci = 96 + ci - 122;
            
        printf("%c", (char) ci);
        ki++;
    }
    
    printf("\n");
    return 0;
}