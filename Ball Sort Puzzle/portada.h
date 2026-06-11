#include <stdio.h>
#include <stdlib.h>
#include <windows.h>
#include <conio.h>

void leerImagen(char nomArch[30], int **img, int f, int c);
void mostrarImg(int **img, int f, int c, int posX, int posY);
void portada(int x, int y);

int mainportada() {
	
	char nomArch1[50] = "juego.txt"; 
	int f=34, c=83;
	
	int **img=NULL;
	
	int i, x=10, y=5;
	
	system ("MODE 800, 100");
	
	img=(int **)malloc(f*sizeof(int*));
	for (i = 0; i < f; i++)
	img[i]=(int*)malloc(c*sizeof(int));
	
	leerImagen(nomArch1, img, f, c);
	mostrarImg(img, f, c, 0, 0);
	
	getch(); // espera ENTER antes de continuar
	
	return 0;
}

void leerImagen(char nomArch[30], int **img, int f, int c){
	FILE *arch = NULL;
	int i, j ;
	arch=fopen(nomArch, "r");
	if (arch){
		for (i = 0; i < f; i++)
			for (j = 0; j < c; j++)
				fscanf(arch,"%d\t",&img[i][j]);
		fclose(arch);
	}
}

void mostrarImg(int **img, int f, int c, int posX, int posY){
	
	HANDLE h = GetStdHandle ( STD_OUTPUT_HANDLE );
	int i, j, x, y;
	
	for (i = 0, y = posY; i < f; i++, y++)
	{
		for(j = 0, x = posX; j < c; j++, x+=2)
		{
			SetConsoleTextAttribute ( h, img[i][j]);
			gotoxy(x,y);
			printf("%c%c",219,219);
			//Sleep(10);
		}
		printf("\n");
	}
}

void portada(int x, int y)
{
	HANDLE hcon;
	hcon=GetStdHandle(STD_OUTPUT_HANDLE);
	COORD dwPos;
	dwPos.X= x;
	dwPos.Y= y;
	SetConsoleCursorPosition(hcon, dwPos);
}

