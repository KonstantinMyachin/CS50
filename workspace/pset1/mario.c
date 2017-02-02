#include <stdio.h>
#include <cs50.h>

int main(void) {
    printf("Height: ");
    
    int count = GetInt();
    while(count > 23 || count < 0) {
        printf("Height: ");
        count = GetInt();
    }
    
    int line = 0;
    while (line != count) {
        for (int i = 1; i < count - line; i++) {
            printf(" ");
        }
        
        for (int i = 0; i <= line + 1; i++) {
            printf("#");
        }
        
        printf("\n");
        line++;
    }

}