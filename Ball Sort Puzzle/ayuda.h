void leerImagen_score(char nomArch[30], int **img, int f, int c);
void mostrarImg_score(int **img, int f, int c, int posX, int posY);
void portada_score(int x, int y);
void mostrarAyuda();

void mostrarAyuda() {

    // === 1. Cargar y mostrar imagen de SCORE como fondo de AYUDA ===
    char nomArchA[50] = "score.txt"; 
    int f = 42, c = 84;

    int **img = (int**) malloc(f * sizeof(int*));
    for (int i = 0; i < f; i++)
        img[i] = (int*) malloc(c * sizeof(int));

    system("cls");
    system("MODE 180, 60");

    leerImagen_score(nomArchA, img, f, c);
    mostrarImg_score(img, f, c, 0, 0);

    for (int i = 0; i < f; i++) free(img[i]);
    free(img);

    // === 2. Poner cursor en un área segura dentro del cuadro negro ===
    // (MISMA POSICIÓN QUE USAMOS PARA SCORE)
    int x = 20;
    int y = 10;

    portada_score(x, y);

    // === 3. Imprimir el texto de ayuda encima del fondo ===
    SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 15); // Blanco

    printf("\n\n\n\n\t\t\t\t\t\t\t\tBienvenido a nuestro juego BALLSORT\n\n");
    printf("\t\t\t\t\t\t\tTu objetivo es mover cada una de las pelotas al mismo tubo.\n\n");

    printf("\t\t\t\t\t\t\t=== Controles del Juego ===\n\n");
    printf("\t\t\t\t\t\t\t  - Flecha izquierda: Mover el cuadro a la IZQUIERDA\n");
    printf("\t\t\t\t\t\t\t  - Flecha derecha:  Mover el cuadro a la DERECHA\n");
    printf("\t\t\t\t\t\t\t  - Flecha abajo:    Mover el cuadro ABAJO\n");
    printf("\t\t\t\t\t\t\t  - Flecha arriba:   Mover el cuadro ARRIBA\n");
    printf("\t\t\t\t\t\t\t  - ENTER: Confirmar accion\n\n");

    printf("\t\t\t\t\t\t\t=== Reglas ===\n\n");
    printf("\t\t\t\t\t\t\t1. El juego esta regulado por un temporizador,\n");
    printf("\t\t\t\t\t\t\t   por lo que el record de juego depende del tiempo.\n");
    printf("\t\t\t\t\t\t\t2. Si la maestra esta leyendo esto, esta PROHIBIDO\n");
    printf("\t\t\t\t\t\t\t   intentar tronar el programa.\n\n");

    printf("\t\t\t\t\t\t\t\tPresiona ENTER para volver al menu principal...\n");

    // === 4. Esperar ENTER ===
    fflush(stdin);  // muy importante
    getchar();
    getchar();
}

void leerImagen_score(char nomArch[30], int **img, int f, int c){
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

void mostrarImg_score(int **img, int f, int c, int posX, int posY){
	
	HANDLE h = GetStdHandle ( STD_OUTPUT_HANDLE );
	int i, j, x, y;
	
	for (i = 0, y = posY; i < f; i++, y++)
	{
		for(j = 0, x = posX; j < c; j++, x+=2)
		{
			SetConsoleTextAttribute ( h, img[i][j]);
			gotoxy(x,y);
			printf("%c%c",219,219);
		}
		printf("\n");
	}
}

void portada_score(int x, int y)
{
	HANDLE hcon;
	hcon=GetStdHandle(STD_OUTPUT_HANDLE);
	COORD dwPos;
	dwPos.X= x;
	dwPos.Y= y;
	SetConsoleCursorPosition(hcon, dwPos);
}
