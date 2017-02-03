/**
 * generate.c
 *
 * Computer Science 50
 * Problem Set 3
 *
 * Generates pseudorandom numbers in [0,LIMIT), one per line.
 *
 * Usage: generate n [s]
 *
 * where n is number of pseudorandom numbers to print
 * and s is an optional seed
 */
 
#define _XOPEN_SOURCE

#include <cs50.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>

// constant
#define LIMIT 65536

int main(int argc, string argv[])
{
    // Проверка, запущена ли программа с 2-мя или 3-мя аргументами. Если нет - вывод сообщения об ошибке и выход из программы
    if (argc != 2 && argc != 3)
    {
        printf("Usage: generate n [s]\n");
        return 1;
    }

    // Преобразования 2-го аргумента (строка) в число. Если нельзя преобразовать, функция atoi вернет 0.
    int n = atoi(argv[1]);

    // Если программа запущена с 3 аргументами, то для генерации "псевдослучайных" чисел в функцию drand48е задается "семя" - 3ий аргумент (число, 
    // преобразованное из строки). В противном случае, "семя" становится равно текущему времени в секундах, в текущей локации. В этом случае, 
    // набор случайных чисел никогда не повторится, так как кол-во секунды с начала Эры никогда не повторится.
    if (argc == 3)
    {
        srand48((long int) atoi(argv[2]));
    }
    else
    {
        srand48((long int) time(NULL));
    }

    // Генерирует и выводит на экран набор случайных чисел, полученных путем умножения "псевдослучайнного" действителього
    // числа в диапазоне от 0.0 до 1.0 умноженного на постоянную переменную LIMIT = 65536, в кол-ве равном 2-ому аргументу,
    // подданному на вход программе.
    for (int i = 0; i < n; i++)
    {
        printf("%i\n", (int) (drand48() * LIMIT));
    }

    // success
    return 0;
}