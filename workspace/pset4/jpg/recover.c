/**
 * recover.c
 *
 * Computer Science 50
 * Problem Set 4
 *
 * Recovers JPEGs from a forensic image.
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>

bool isNewJPG();

int main(int argc, char* argv[])
{
    if (argc != 2) {
        printf("Usage: ./recover\n");
        return 1;        
    }
    
    char* infile = argv[1];
    //программа проверяется через cs50 с константой имени файла
    //char* infile = "card.raw";

    FILE* inptr = fopen(infile, "r");
    if (inptr == NULL)
    {
        printf("Could not open %s.\n", infile);
        return 2;
    }
    
    unsigned char ptr[512];
    int count = 0;
    int flag = 1;
    while(flag == 1) {
        if (count == 0)    
            flag = fread(ptr, 512, 1, inptr);
            
        if (isNewJPG(ptr)) {
            char fileName[8];
            sprintf(fileName, "%03d.jpg", count++);

            FILE* onptr = fopen(fileName, "w");
            
            if (onptr == NULL) {
                fprintf(stderr, "Could not create %s.\n", fileName);
                return 3;
            }
            
            fwrite(ptr, 512, 1, onptr);
            while((flag = fread(ptr, 512, 1, inptr)) == 1 && !isNewJPG(ptr)) {
                fwrite(ptr, 512, 1, onptr);
            }
            
            fclose(onptr);
        }
    }
    
    fclose(inptr);
    
    return 0;
}

bool isNewJPG(unsigned char buffer[]) {
    if ((int) buffer[0] == 255 && (int) buffer[1] == 216 && (int) buffer[2] == 255 && (int) (buffer[3] >> 4) == 14)
        return true;
        
    return false;
}
