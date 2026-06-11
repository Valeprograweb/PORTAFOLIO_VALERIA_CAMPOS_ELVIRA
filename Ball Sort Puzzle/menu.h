int scroll_menu(int posX, int posY, int cantOpc);
void presenta_menu(int posX, int posY);
void mainMenu();
void leerImagen_menu(char nomArch[30], int **img, int f, int c);
void mostrarImg_menu(int **img, int f, int c, int posX, int posY);
void portada_menu(int a, int b);

void mainMenu(){
    
    int ren=2,col=5, ancho=7,alto=13;
    int op=0;
    int x=20,y=10;

    srand(time(NULL));

    do{
        presenta_menu(x,y);
        op = scroll_menu(x,y,4);
        system("cls");

        switch(op){
            case 1: {
            	
                nodo *listas[2][5] = {NULL};
                nodo *listas_iniciales[2][5] = {NULL};

                int colores[32];
                int i, j, k, aux = 0;
                
                // 4 bolas de cada color
                for(i = 1; i <= 8; i++) {
                    for(j = 0; j < 4; j++) {
                        colores[aux++] = i;
                    }
                }

                // Mezclar
                for(i = 0; i < 32; i++) {
                    int pos1 = rand() % 32;
                    int pos2 = rand() % 32;
                    int temp = colores[pos1];
                    colores[pos1] = colores[pos2];
                    colores[pos2] = temp;
                }

                // Distribuir en tubos
                aux = 0;
                for(i = 0; i < 2; i++) {
                    for(j = 0; j < 5; j++) {
                        if(i == 1 && j >= 3) {
                            listas[i][j] = NULL;
                            listas_iniciales[i][j] = NULL;
                        } else {
                            listas[i][j] = NULL;
                            listas_iniciales[i][j] = NULL;

                            for(k = 0; k < 4; k++) {
                                info dato;
                                dato.num = colores[aux++];
                                inserta_inicioLS(&listas[i][j], dato);
                                inserta_inicioLS(&listas_iniciales[i][j], dato);
                            }
                        }
                    }
                }

                mainjuego();
                tablero(x+2, y-4, ancho, alto, ren, col, listas);
                moverCuadro(x+2, y-3, ancho, alto, ren, col, listas, listas_iniciales);
                mainfelicidades();
                break;
            }

            case 2:
                mostrarAyuda();
                break;

            case 3:
                mostrarScore();
                break;

            case 4:
                printf("SALIR");
                break;
        }

        getch();

    } while(op != 4);
}

void presenta_menu(int posX, int posY){
       system("cls");
       char nomArch1[50] = "menuimg.txt"; 
		int f=43, c=82;
		
		int **img=NULL;
		
		int i, a=10, b=5;
		
		system ("MODE 800, 100");
		
		img=(int **)malloc(f*sizeof(int*));
		for (i = 0; i < f; i++)
		img[i]=(int*)malloc(c*sizeof(int));
		
		leerImagen_menu(nomArch1, img, f, c);
		mostrarImg_menu(img, f, c, 0, 0);
		
		getch(); 
		
       SetConsoleTextAttribute(GetStdHandle (STD_OUTPUT_HANDLE),15);
       gotoxy(posX,posY);printf("\n\n\n\n\n\n\n\n\t\t\t\t\t\t\t\t\t   1. APLICACION");
       gotoxy(posX,++posY);printf("\n\n\n\n\n\n\n\n\t\t\t\t\t\t\t\t\t   2. AYUDA");
       gotoxy(posX,++posY);printf("\n\n\n\n\n\n\n\n\t\t\t\t\t\t\t\t\t   3. SCORE");
       gotoxy(posX,++posY);printf("\n\n\n\n\n\n\n\n\t\t\t\t\t\t\t\t\t   4. SALIR");  
       printf("\n\n\n\n\n\n\n\n\t\t\t\t\t\t\t\tAlmendarez Martinez Diego Issac - 186719 ");  
       printf("\n\n\t\t\t\t\t\t\t\t     Campos Elvira Valeria - 186831 ");
       printf("\n\n\t\t\t\t\t\t\t\tUniversidad Politecnica de San Luis Potosi ");
       
       
}

int scroll_menu(int posX, int posY, int cantOpc){
    char tecla = '\0';
    int op = 1, y = posY;
 
    posX = posX - 2;
    gotoxy(posX, posY); printf("\n\n\n\n\n\n\n\n\t\t\t\t\t\t\t\t\t->");
    do {
        tecla = getch();
        SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 11);
        gotoxy(posX, y); printf("\n\n\n\n\n\n\n\n\t\t\t\t\t\t\t\t\t->");
        if (tecla == 80 && op < cantOpc) // 'P' 80 ABAJO
        {
            y++;
            op++;
        }
        if (tecla == 72 && op>1) //'H' ARRIBA
        {
            y--;
            op--;
        }
        SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 3);
        gotoxy(posX, y); printf("\n\n\n\n\n\n\n\n\t\t\t\t\t\t\t\t\t->");
 
    } while (tecla != 27 && tecla != 13);
    return (op);
}

void leerImagen_menu(char nomArch[30], int **img, int f, int c){
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

void mostrarImg_menu(int **img, int f, int c, int posX, int posY){
	
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

void portada_menu(int a, int b)
{
	HANDLE hcon;
	hcon=GetStdHandle(STD_OUTPUT_HANDLE);
	COORD dwPos;
	dwPos.X= a;
	dwPos.Y= b;
	SetConsoleCursorPosition(hcon, dwPos);
}

