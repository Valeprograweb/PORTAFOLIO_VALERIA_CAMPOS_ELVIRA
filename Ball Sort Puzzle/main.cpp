//Campos Elvira Valeria - 186831
// Amnendárez Martínez Diego Issac - 186719

#include<stdio.h>
#include<windows.h>
#include<conio.h>
#include<time.h>
#include<stdlib.h>

#define COLOR_TABLERO 15
#define COLOR_CUADRO 3

#define ESP 3
#define ESPY 6
#define RIGHT 77//M
#define LEFT 75//K
#define UP 72//H
#define DOWN 80//P
#define ESC 27//ESCAPE
#define ENTER 13//ENTER

#include"funciones.h"
#include"score.h"
#include"listaS.h"
#include"ayuda.h"
#include"menu.h"
#include"portada.h"

int main(){
	Nombre_Jugador();
    mainportada();
    mainMenu();
    getch();
    return 0;
}

