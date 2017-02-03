/**
 * helpers.c
 *
 * Computer Science 50
 * Problem Set 3
 *
 * Helper functions for Problem Set 3.
 */
       
#include <cs50.h>

#include "helpers.h"

bool binarySearch(int value, int values[], int start, int end) {
    int n = end - start;
    if (n < 2) {
        if (value == values[start])
            return true;
        else
            return false;
    } else {
        int middle = n / 2;
        if (value < values[middle])
            return binarySearch(value, values, 0, middle);
        else if (value == values[middle])
            return true;
        else 
            return binarySearch(value, values, middle + 1, end);
    }
}

/**
 * Returns true if value is in array of n values, else false.
 */
bool search(int value, int values[], int n)
{
    // TODO: implement a searching algorithm
    if (n <= 0)
        return false;
    
    return binarySearch(value, values, 0, n);
}

/**
 * Sorts array of n values.
 */
void sort(int values[], int n)
{
    // TODO: implement an O(n^2) sorting algorithm
    for (int i = 0; i < n; i++) {
        for (int j = i; j > 0 ;j--) {
            if(values[j] < values[j - 1]) {
                int tmp = values[j - 1];
                values[j - 1] = values[j];
                values[j] = tmp;
            }
        }
    }

    return;
}