#include <stdio.h>
#include <cs50.h>
#include <math.h>

int main(void) {
    printf("O hai! How much change is owed?\n");
    float f = GetFloat();
    
    while (f < 0) {
        printf("How much change is owed?\n");
        f = GetFloat();
    }
    
    int i = round(100 * f);
    int count = 0;
    
    int c;
    if (i >= 25) {
        count += i / 25;
        i -= count * 25;
    }
    
    if (i >= 10) {
        c = i / 10;
        count += c;
        i -= c * 10;
    }
    
    if (i >= 5) {
        c = i / 5;
        count += c;
        i -= c * 5;
    }
    
    count += i;


    printf("%i\n", count);
}