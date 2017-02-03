/**
 * Implements a dictionary's functionality.
 */

#include <stdbool.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <ctype.h>

#include "dictionary.h"

#define SIZE 26

typedef struct node {
    char value[LENGTH + 1];
    struct node *next;
}
node;

int hashFunction(const char *key);
node *dictionaryHashTable[SIZE];
unsigned int endOfFile;

/**
 * Returns true if word is in dictionary else false.
 */
bool check(const char *word) {
    node *current = dictionaryHashTable[hashFunction(word)];
    unsigned long wordLength = strlen(word);
    while (current != NULL) {
        if (wordLength == strlen(current->value)) {
            for (int i = 0; i < wordLength; i++) {
                if (toupper(word[i]) != toupper(current->value[i]))
                    break;
                
                if (i == wordLength - 1)
                    return true;
            }
        }

        current = current->next; 
    }
    
    return false;
}

/**
 * Loads dictionary into memory. Returns true if successful else false.
 */
bool load(const char *dictionary) {
    // TODO
    FILE *dictionaryFile = fopen(dictionary, "r");
    if (dictionaryFile == NULL) {
        printf("Couldn't open %s.\n", dictionary);
        return false;
    }
    
    char wordFromDictionary[LENGTH + 1];
    
    while((endOfFile = fscanf(dictionaryFile, "%s", wordFromDictionary)) != EOF) {
        node *newNode = malloc(sizeof(node));
        if (newNode == NULL) { 
            unload();
            return false;
        }
        
        strcpy(newNode->value, wordFromDictionary);
        int index = hashFunction(wordFromDictionary);
        if (dictionaryHashTable[index] != NULL)
            newNode->next = dictionaryHashTable[index];
            
        dictionaryHashTable[index] = newNode;
    }

    fclose(dictionaryFile);
    return true;
}

/**
 * Returns number of words in dictionary if loaded else 0 if not yet loaded.
 */
unsigned int size(void) {
    int size = 0;
    if (endOfFile == EOF) {
        for (int i = 0; i < SIZE; i++) {
            node *current = dictionaryHashTable[i];
            while (current != NULL) {
                size++;
                current = current->next;
            }
        }
    }
    
    return size;
}

/**
 * Unloads dictionary from memory. Returns true if successful else false.
 */
bool unload(void) {
    for (int i = 0; i < SIZE; i++) {
        node *current = dictionaryHashTable[i];
        while (current != NULL) {
            node *temp = current;
            current = current->next;
            free(temp);
        }
    }
    
    return true;
}

int hashFunction(const char *key) {
    int hash = toupper(key[0]) - 'A';
    return hash % SIZE;
}
