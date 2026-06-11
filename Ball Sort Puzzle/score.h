#define MAX_RECORDS 10

// Declaraciones de funciones existentes
void cuadroDoble(int posX,int posY,int ancho,int alto,int color);
void leerImagen_start(char nomArch[30], int **img, int f, int c);
void mostrarImg_start(int **img, int f, int c, int posX, int posY);
void portada_start(int x, int y);
int mainstart();
void guardarScore(int nuevo_tiempo);
void mostrarScore();

typedef struct
{
	char nombre[50];
	int tiempo_segundos; 
}infoABB; // Contiene los datos del Score

typedef struct nodoABB
{
	infoABB dato; ;// aky esta toda la informacion
	struct nodoABB *izquierda; 
	struct nodoABB *derecha;  // apuntador al sig nodo	
} nodoABB;


nodoABB *raiz_score = NULL;

char nombreJugador[50];

nodoABB* crearNodo(infoABB dato) {
	nodoABB *nuevo=NULL;
	nuevo=(nodoABB*)malloc(sizeof(nodoABB));
	nuevo->dato = dato;
	nuevo->izquierda = NULL;
	
	nuevo->derecha = NULL;
	return nuevo;
}

void insertarScore(nodoABB **raiz, infoABB dato) {
	nodoABB *nuevo = NULL;
	if (*raiz == NULL) { // base
		nuevo = crearNodo(dato);
		*raiz = nuevo;
	} else {
		if (dato.tiempo_segundos < (*raiz)->dato.tiempo_segundos)
			insertarScore(&(*raiz)->izquierda, dato);
		else // Mayor o igual va a la derecha
			insertarScore(&(*raiz)->derecha, dato);
	}
}

void liberarABB(nodoABB* nodo) {
	if (nodo != NULL) {
		liberarABB(nodo->izquierda);
		liberarABB(nodo->derecha);
		free(nodo);
	}
}


void guardarInorden(nodoABB* nodo, FILE* archivo, int* count) {
	if (nodo != NULL && *count < MAX_RECORDS) {
		guardarInorden(nodo->izquierda, archivo, count);

		if (*count < MAX_RECORDS) {
			fprintf(archivo, "%s %d\n", nodo->dato.nombre, nodo->dato.tiempo_segundos);
			(*count)++;
		}

		if (*count < MAX_RECORDS)
			guardarInorden(nodo->derecha, archivo, count);
	}
}



void Nombre_Jugador() {
	
	mainstart(); 
	HANDLE h = GetStdHandle(STD_OUTPUT_HANDLE);
	
	// Dimensiones y posición del cuadro
	int posX = 60;
	int posY = 17;
	int ancho = 55;
	int alto = 5;

	cuadro(posX, posY, ancho, alto, 11); 
	
	SetConsoleTextAttribute(h, 15);	
	int mensajeX = posX + (ancho - 19) / 2;
	gotoxy(mensajeX, posY + 1);
	printf("Escribe tu nombre:");
	
	gotoxy(posX + 25, posY + 3);
	SetConsoleTextAttribute(h, 15);	
	
	fflush(stdin);
	fgets(nombreJugador, 50, stdin);
    size_t len = strlen(nombreJugador);
    if (len > 0 && nombreJugador[len-1] == '\n') {
        nombreJugador[len-1] = '\0';
    }

	SetConsoleTextAttribute(h, 7);
}

void guardarScore(int nuevo_tiempo) {
	FILE *archivo;
	infoABB infoTemp; 
	int tiempoTemp; 
	char nombreTemp[50];
    

	archivo = fopen("marcador.txt", "r");
	if (archivo != NULL) {
		liberarABB(raiz_score);
		raiz_score = NULL;

		while (fscanf(archivo, "%s %d", nombreTemp, &tiempoTemp) == 2) {
			strcpy(infoTemp.nombre, nombreTemp);
			infoTemp.tiempo_segundos = tiempoTemp;
	
			insertarScore(&raiz_score, infoTemp); 
		}
		fclose(archivo);
	}

	// . Insertar el nuevo score
	infoABB nuevo_dato;
	strcpy(nuevo_dato.nombre, nombreJugador); 
	nuevo_dato.tiempo_segundos = nuevo_tiempo;
	insertarScore(&raiz_score, nuevo_dato);

	//  Guardar en archivo los TOP 10
	archivo = fopen("marcador.txt", "w");
	if (archivo != NULL) {
		int count = 0;
		guardarInorden(raiz_score, archivo, &count);
		fclose(archivo);
	}
	// . Liberar memoria
	liberarABB(raiz_score);
	raiz_score = NULL;
}

void mostrarScore() {
	FILE *archivo;
	infoABB infoTemp;
	int tiempoTemp; 
	char nombreTemp[50];
	int num_records = 0;

	system("cls");

	// . Cargar datos guardados
	archivo = fopen("marcador.txt", "r");
	if (archivo != NULL) {
		liberarABB(raiz_score);
		raiz_score = NULL;

		while (fscanf(archivo, "%s %d", nombreTemp, &tiempoTemp) == 2) {
			strcpy(infoTemp.nombre, nombreTemp);
			infoTemp.tiempo_segundos = tiempoTemp;
			insertarScore(&raiz_score, infoTemp);
			num_records++;
		}
		fclose(archivo);
	}

	HANDLE h = GetStdHandle(STD_OUTPUT_HANDLE);


	int posX = 60;
	int posY = 7;
	int ancho = 50;
	int alto = (num_records == 0) ? 6 : (6 + num_records);


	cuadro(posX, posY, ancho, alto, 9); 
	cuadro(60, 2, 50, 4, 11); 

	SetConsoleTextAttribute(h, 6);
	int titulo = 80;	
	gotoxy(titulo, 4);	
	printf("RANKING");

	SetConsoleTextAttribute(h, 11);
	gotoxy(posX + 5, posY + 2);
	printf("POS   NOMBRE            TIEMPO  SEGUNDOS");

	if (num_records == 0) {
		SetConsoleTextAttribute(h, 12);
		gotoxy(posX + 8, posY + 5);
		printf("Aun no hay registros guardados.");
	} else {
		int count = 0;
		int fila = posY + 4;

		// Uso de nodoABB, izquierda/derecha
		nodoABB* stack[50]; 
		int top = -1;
		nodoABB* actual = raiz_score;

		while (actual != NULL || top != -1) {
			while (actual != NULL) {
				stack[++top] = actual;
				actual = actual->izquierda;
			}

			actual = stack[top--];

			int t = actual->dato.tiempo_segundos; 
			int min = t / 60;
			int seg = t % 60;

			if(count < MAX_RECORDS){ 
				SetConsoleTextAttribute(h, 15);
				gotoxy(posX + 5, fila++);
				printf("%2d    %-15s  %2d:%02d      %-6d",
						count + 1, actual->dato.nombre, min, seg, t); 
				count++;
			} else {
                break;
            }
			
			actual = actual->derecha;
		}
	}

	SetConsoleTextAttribute(h, 6);
	gotoxy(posX + 10, posY + alto + 2);
	printf("Presiona ENTER para regresar...");

	liberarABB(raiz_score);
	raiz_score = NULL;

	getchar(); 
    if(num_records > 0 || raiz_score == NULL) getchar(); 
}


int mainstart() {
	
	char nomArch1[50] = "start.txt";	
	int f=36, c=84;
	
	int **img=NULL;
	
	int i, x=10, y=5;
	
	system ("MODE 800, 100");
	
	img=(int **)malloc(f*sizeof(int*));
	for (i = 0; i < f; i++)
	img[i]=(int*)malloc(c*sizeof(int));
	
	leerImagen_start(nomArch1, img, f, c);
	mostrarImg_start(img, f, c, 0, 0);
	
	getch(); 
	
	return 0;
}

void leerImagen_start(char nomArch[30], int **img, int f, int c){
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

void mostrarImg_start(int **img, int f, int c, int posX, int posY){
	
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

void portada_start(int x, int y)
{
	HANDLE hcon;
	hcon=GetStdHandle(STD_OUTPUT_HANDLE);
	COORD dwPos;
	dwPos.X= x;
	dwPos.Y= y;
	SetConsoleCursorPosition(hcon, dwPos);
}

void cuadroDoble(int posX,int posY,int ancho,int alto,int color){
	int i;
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), color);

	// horizontales
	for (i = 0; i < ancho; i++) {
		gotoxy(posX + i, posY);
		printf("%c", 205);	 // =
		gotoxy(posX + i, posY + alto);
		printf("%c", 205);	 // =
	}
	// verticales
	for (i = 0; i < alto; i++) {
		gotoxy(posX, posY + i);
		printf("%c", 186);	 // ||
		gotoxy(posX + ancho, posY + i);
		printf("%c", 186);	 // ||
	}
	// esquinas
	gotoxy(posX, posY);	 		 printf("%c", 201); // +
	gotoxy(posX + ancho, posY);		 printf("%c", 187); // +
	gotoxy(posX, posY + alto);		 printf("%c", 200); // +
	gotoxy(posX + ancho, posY + alto);printf("%c", 188); // +
}
