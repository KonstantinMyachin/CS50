#include <stdio.h>
#include <cs50.h>

int main(void) {
    printf("minutes: ");
    int i = GetInt();
    printf("bottles: %i\n", i * 12);
}