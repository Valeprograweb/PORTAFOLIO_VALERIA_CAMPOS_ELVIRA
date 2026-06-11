#define ALTO_N 2
#define ANCHO_N 3
#define COLOR_N 15
#define INDICADOR_COLOR 11 
#define INDICADOR_POS_OFFSET -1 

typedef struct {
    int num; // Color de la bola
    int x, y; // Coordenadas actuales en la consola
} info;
 
struct reg {
    info dato;
    struct reg *sig;
};

typedef struct reg nodo;

int menu();
int verificarTorreCompleta(nodo *cab);
void imprimirIndicadorVictoria(int x, int y, int borrar);
nodo *crea_nodoLS(info dato);
void inserta_inicioLS(nodo **cab,info dato);//referencia
void recorreLS(nodo *cab, int x, int y);
nodo *busquedaLS(nodo *cab,int numero);
void inserta_finalLS(nodo **cab,info dato);
void elim_inicioLS(nodo **cab);
void elim_finalLS(nodo **cab);
void inserta_ordLS(nodo **cab,info dato);
void elimina_espLS(nodo **cab,info dato);
void imprime_nodo(info dato, int x, int y, int borrar);
void crea_lista(nodo **cab, int nodos);
void tablero(int posX,int posY, int ancho, int alto, int rens, int cols);
void moverCuadro(int posX, int posY, int ancho, int alto, int ren, int col, nodo *listas[2][5], nodo *listas_iniciales[2][5]);
void liberarLista(nodo* cab);
nodo* copiarLista(nodo* original);
int victoria(nodo *listas[2][5]);
void temporizador(int tiempo_segundos);
int cuenta_nodo(nodo *cab);
int mainjuego();
void leerImagen_juego(char nomArch[30], int **img, int f, int c);
void mostrarImg_juego(int **img, int f, int c, int posX, int posY);
void portada_juego(int x, int y);
int mainfelicidades();

nodo *crea_nodoLS(info dato)
{
	nodo *nuevo=NULL;
	nuevo=(nodo*)malloc(sizeof(nodo));//generar espacio
	nuevo->dato=dato;
	nuevo->dato.x=-1;
	nuevo->dato.y=-1;
	nuevo->sig=NULL;

	return nuevo;	
}
 
int verificarTorreCompleta(nodo *cab) {
    int contador = cuenta_nodo(cab);

    // Debe tener exactamente 4 bolas
    if (contador != 4) {
        return 0;
    }

    // Verificar que todas sean del mismo color
    if (cab != NULL) {
        int color_base = cab->dato.num;
        nodo *actual = cab->sig;

        while (actual != NULL) {
            if (actual->dato.num != color_base) {
                return 0; // Color diferente encontrado
            }
            actual = actual->sig;
        }
        return 1; // 4 nodos y todos del mismo color
    }
    return 0;
}

void imprimirIndicadorVictoria(int x, int y, int borrar) {
    HANDLE h = GetStdHandle(STD_OUTPUT_HANDLE);
    
    // Calcular la posición Y justo encima del tubo
    int indicador_y = y + INDICADOR_POS_OFFSET; 
    int indicador_x = x + 2; // Centro del cuadro

    SetConsoleTextAttribute(h, borrar ? 0 : INDICADOR_COLOR);
    gotoxy(indicador_x, indicador_y);
    printf(" %c ", 219); // Puedes cambiar el carácter o la forma
    SetConsoleTextAttribute(h, 7); // Restaurar a blanco/gris
}
 
// Inserta un nodo al inicio de una lista simplemente enlazada
void inserta_inicioLS(nodo **cab, info dato)
{
    nodo *nuevo=NULL; // Apuntador para el nuevo nodo
    nuevo = crea_nodoLS(dato);// Se crea un nodo con la información recibida
    nuevo->sig = *cab;// El nuevo nodo apunta al que antes era la cabeza
    *cab = nuevo;// La cabeza ahora es el nuevo nodo
}

// Recorre la lista y dibuja cada nodo en la pantalla
void recorreLS(nodo *cab, int x, int y)
{
    nodo *aux=NULL;// Auxiliar para recorrer la lista

    // Recorre nodo por nodo
    for(aux=cab; aux!=NULL; aux=aux->sig, y=y+3){// Cada nodo baja 3 espacios en Y
        aux->dato.x = x;// Guarda coordenada X en el nodo
        aux->dato.y = y;// Guarda coordenada Y en el nodo
        // Dibuja el nodo (cuadro de color con número)
        imprime_nodo(aux->dato, x, y, 0);
    }
}
// Busca un nodo con un valor específico (numero)
nodo *busquedaLS(nodo *cab, int numero)
{
    nodo *aux=NULL;                     

    for(aux=cab; aux!=NULL; aux=aux->sig){
        if(aux->dato.num == numero){// Si el número coincide
            return aux;// Retorna el nodo encontrado
        }
    }
    return aux;// Si no se encontró, retorna NULL
}

 
// Inserta un nodo al final de la lista
void inserta_finalLS(nodo **cab, info dato)
{
    nodo *nuevo = crea_nodoLS(dato);// Crear nuevo nodo
    nodo *aux = *cab;// Auxiliar apuntando a la cabeza

    if (*cab == NULL) {// Si la lista está vacía
        *cab = nuevo;// El nuevo nodo es la cabeza
    } else {
        while (aux->sig != NULL) {// Avanza hasta el último nodo
            aux = aux->sig;
        }
        aux->sig = nuevo;// Enlaza el último con el nuevo
    }
}

// Elimina el nodo al inicio de la lista
void elim_inicioLS(nodo **cab)
{
    nodo *aux=NULL;

    if(*cab!=NULL){// Si la lista no está vacía
        aux=*cab;// aux apunta al primer nodo
        *cab = aux->sig;// La nueva cabeza es el segundo nodo
        free(aux);// Se libera la memoria del nodo eliminado
    }
}
 
// Elimina el nodo al final de la lista
void elim_finalLS(nodo **cab)
{
    nodo *ult=NULL, *ant=NULL;

    if(*cab==NULL){                   
        printf("\nLISTA VACIA");
    } else {
        // Recorre hasta el último nodo
        for(ult=*cab,ant=NULL; ult->sig!=NULL; ult=ult->sig){
            ant=ult;
        }

        if(ant==NULL)                  
            *cab=NULL;
        else 
            ant->sig=NULL;// El penúltimo ahora es el último

        printf("\nDato eliminado: %d", ult->dato.num);
        free(ult);// Liberar memoria
    }
}
 
// Inserta un nodo de manera ordenada por el campo num
void inserta_ordLS(nodo **cab, info dato)
{
    nodo *aux=NULL, *ant=NULL, *nuevo=NULL;
    nuevo = crea_nodoLS(dato);// Crear nodo nuevo

    // Si la lista está vacía o debe ir al inicio
    if(*cab==NULL || (*cab)->dato.num > dato.num){
        nuevo->sig = *cab;
        *cab = nuevo;
    } else {
        // Se busca la posición correcta
        for(aux=*cab, ant=NULL; aux!=NULL && aux->dato.num < dato.num; aux=aux->sig){
            ant=aux;
        }

        nuevo->sig = aux; // Inserta entre ant y aux
        ant->sig = nuevo;
    }
}
 
// Elimina un nodo específico según el número en dato.num
void elimina_espLS(nodo **cab, info dato)
{
    nodo *aux=NULL, *ant=NULL;
    int find=0;

    if(*cab==NULL)
        printf("no existe el dato");// Lista vacía

    // Caso especial: eliminar el primero
    else if((*cab)->dato.num == dato.num)
        elim_inicioLS(&(*cab));

    else {
        // Buscar el nodo a eliminar
        for(aux=*cab; aux!=NULL; aux=aux->sig){ 
            if(aux->dato.num == dato.num){
                ant->sig = aux->sig;   // Se salta el nodo
                printf("Eliminado %d", aux->dato.num);
                find = 1;
                break;
            }
            ant = aux;// Avanza el apuntador del anterior
        }

        if(find==1) free(aux); // Se libera la memoria
        else printf("no existe");
    }
}

 
void imprime_nodo(info dato, int x, int y, int borrar){
	
    int color;
    
    if(borrar == 1)
        color = 0;       // negro
    else
        color = dato.num;    // pintar cuadro — AHORA depende de borrar
    if(borrar == 1)
        cuadro(x, y+1, ANCHO_N, ALTO_N, 0);  
    else
        cuadro(x, y+1, ANCHO_N, ALTO_N, COLOR_N);
    SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), color);
    gotoxy(x+1, y+2);
    printf("%c%c", 219, 219);
    SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 7);
}
 
// Crea una lista con n nodos aleatorios (colores del 1 al 15)
void crea_lista(nodo **cab, int nodos)
{
    int i;
    info dato;

    for(i=0; i<nodos; i++){
        dato.num = 1 + rand()%15;      // Número aleatorio entre 1 y 15
        inserta_inicioLS(&*cab, dato); // Inserta al inicio
    }
}

// Dibuja el tablero y dibuja todas las listas contenidas en cada casilla
void tablero(int posX,int posY, int ancho, int alto, int rens, int cols, nodo *listas[2][5]){

    int i, j, x, y, nodoX, nodoY;

    // Recorre renglones
    for(i=0, y=posY, nodoY=posY+1; i<rens; i++, y=y+alto+ESPY, nodoY = y+1){

        // Recorre columnas
        for(j=0, x=posX, nodoX=posX+2; j<cols; j++, x=x+ancho+ESP, nodoX+=10){

            // Dibuja la celda del tablero
            cuadro(x, y+1, ancho, alto, COLOR_TABLERO);

            // Dibuja la lista dentro de esa celda
            recorreLS(listas[i][j], nodoX, nodoY);
        }
    }
}
 
void moverCuadro(int posX, int posY, int ancho, int alto, int ren, int col, nodo *listas[2][5], nodo *listas_iniciales[2][5]) {

    char tecla = 0;

    info dato;

    nodo *aux = NULL; // Puntero al nodo FLOTANTE (la bola o grupo que se mueve)

    int x = posX, y = posY, color_torre = 10, borrar_torre = 15;
    int i = 0, j = 0; // i: fila (ren), j: columna (col)
    int cont_torre = -1;
    int origen_i = -1, origen_j = -1;
    int flotante_x = -1, flotante_y = -1;
    
    // VARIABLES DE TIEMPO
    clock_t inicio;
    int tiempo_transcurrido = 0;
    
    // Iniciar medición del tiempo
    inicio = clock();
    
    // Dibujar el cursor inicial
    cuadro(x, y, ancho, alto, color_torre);

    do {
        // 1. DIBUJAR/BORRAR INDICADORES DE VICTORIA DE TORRES
        int x_tablero, y_tablero;
        // Asumiendo que posY es el borde superior del tablero (y-1 de la primera fila de tubos)
        for (int row = 0, y_tablero = posY; row < ren; row++, y_tablero = y_tablero + alto + ESPY) { 
            for (int col_idx = 0, x_tablero = posX; col_idx < col; col_idx++, x_tablero = x_tablero + ancho + ESP) {
                if (verificarTorreCompleta(listas[row][col_idx])) {
                    imprimirIndicadorVictoria(x_tablero, y_tablero, 0); // Dibuja
                } else {
                    imprimirIndicadorVictoria(x_tablero, y_tablero, 1); // Borra
                }
            }
        }
        
        // 2. VERIFICAR VICTORIA TOTAL
        if(victoria(listas)) {
            // Calcular tiempo final
            tiempo_transcurrido = (clock() - inicio) / CLOCKS_PER_SEC;
            
            // Guardar Score
            guardarScore(tiempo_transcurrido);
            
            // Mostrar pantalla de victoria
            temporizador(tiempo_transcurrido);
            mainfelicidades();
            break;
        }

        // Leer la tecla
        tecla = getch();

        // Lógica de Reinicio
        if(tecla == 32 || tecla == 'r' || tecla == 'R') {
            // REINICIAR TABLERO
            for(int k = 0; k < ren; k++) {
                for(int l = 0; l < col; l++) {
                    liberarLista(listas[k][l]);
                    listas[k][l] = copiarLista(listas_iniciales[k][l]);
                }
            }
            // Reiniciar tiempo
            inicio = clock();
            // Redibujar todo
            system("cls");
             mainjuego();
            // Nota: Aquí estás pasando posY-1 en tu código original, mantengo esa convención
            tablero(posX, posY - 1, ancho, alto, ren, col, listas); 
            
            // Resetear variables de control
            i = 0; j = 0;
            x = posX; y = posY;
            aux = NULL;
            cont_torre = -1;
            origen_i = -1; origen_j = -1;
            flotante_x = -1; flotante_y = -1;
            cuadro(x, y, ancho, alto, color_torre);
            
            continue;
        }
        
        // Borrar cursor anterior antes de mover
        cuadro(x, y, ancho, alto, borrar_torre);

        switch(tecla) {

            case RIGHT:
                if(j < col-1){
                    x = x + ancho + ESP;
                    j++;    
                }       
                break;

            case LEFT:
                if(j > 0){
                    x = x - ancho - ESP;
                    j--;    
                }       
                break;

            case UP:
                if(i > 0){
                    y = y - alto - ESPY;
                    i--;    
                }       
                break;
                
            case DOWN:
                if(i < ren-1){
                    y = y + alto + ESPY;
                    i++;    
                }       
                break;
                
            case ENTER:
                if(cont_torre > -1){ // SEGUNDO ENTER (DESTINO)
                    
                    if(origen_i == i && origen_j == j){
                        // Mismo tubo - cancelar movimiento
                        imprime_nodo(aux->dato, flotante_x, flotante_y, 1); // Borrar flotante
                        imprime_nodo(aux->dato, aux->dato.x, aux->dato.y, 0); // Redibujar en origen
                        aux = NULL;
                        cont_torre = -1;
                        break;
                    } 
                    
                    // --- Lógica de Verificación y Movimiento ---
                    
                    // 1. Obtener información del grupo a mover
                    int grupo_size = 0;
                    if (listas[origen_i][origen_j] != NULL) {
                        nodo *temp_g = listas[origen_i][origen_j];
                        int color_grupo = temp_g->dato.num;
                        
                        while(temp_g != NULL && temp_g->dato.num == color_grupo) {
                            grupo_size++;
                            temp_g = temp_g->sig;
                        }

                        // 2. Verificar reglas de movimiento
                        int espacio_destino = 4 - cuenta_nodo(listas[i][j]);
                        
                        // a) Verificar espacio
                        if(espacio_destino < grupo_size) {
                            // No hay espacio suficiente para el grupo
                            imprime_nodo(aux->dato, flotante_x, flotante_y, 1);
                            imprime_nodo(aux->dato, aux->dato.x, aux->dato.y, 0);
                            aux = NULL;
                            cont_torre = -1; 
                            break;
                        }
                        
                        // b) Verificar coincidencia de color (si el destino no está vacío)
                        if(listas[i][j] != NULL && color_grupo != listas[i][j]->dato.num) {
                            // El color superior no coincide con el grupo
                            imprime_nodo(aux->dato, flotante_x, flotante_y, 1);
                            imprime_nodo(aux->dato, aux->dato.x, aux->dato.y, 0);
                            aux = NULL;
                            cont_torre = -1;
                            break;
                        }
                        
                        // 3. Ejecutar el MOVER GRUPO (válido)
                        
                        int espacios_ocupados = cuenta_nodo(listas[i][j]);
                        
                        // Array para guardar coordenadas del origen antes de eliminar
                        int coordenadas_x[4], coordenadas_y[4];
                        
                        // Recorrer el grupo a mover
                        for(int k = 0; k < grupo_size; k++) {
                            // Coordenadas para borrar en origen
                            coordenadas_x[k] = listas[origen_i][origen_j]->dato.x;
                            coordenadas_y[k] = listas[origen_i][origen_j]->dato.y;

                            // 3.1. Calcular posición Y de destino
                            // Y-base (borde inferior) es y + alto - 4 (aproximado, según tu lógica de recorreLS)
                            // La posición Y disminuye a medida que se agregan nodos (3 unidades por nodo)
                            int xDest = x + 2; // Centro del tubo actual (destino)
                            int yDest = (y + alto - 4) - (espacios_ocupados * 3);
                            
                            // 3.2. Mover: insertar en destino (inserta al inicio)
                            info nueva_info = listas[origen_i][origen_j]->dato; // Copiar dato
                            inserta_inicioLS(&listas[i][j], nueva_info);
                            
                            // 3.3. Actualizar coordenadas del nodo recién insertado
                            listas[i][j]->dato.x = xDest;
                            listas[i][j]->dato.y = yDest;
                            
                            // 3.4. Dibujar en destino
                            imprime_nodo(listas[i][j]->dato, xDest, yDest, 0);
                            espacios_ocupados++;
                            
                            // 3.5. Eliminar del origen (elimina del inicio)
                            elim_inicioLS(&listas[origen_i][origen_j]);
                        }
                        
                        // 4. Limpieza Visual
                        
                        // Borrar la bola que estaba flotando
                        imprime_nodo(aux->dato, flotante_x, flotante_y, 1);
                        
                        // Borrar visualmente las bolas del origen usando las coordenadas guardadas
                        for(int k = 0; k < grupo_size; k++) {
                            // Se asume que el cuadro completo del tubo está dibujado, solo borra la bola
                            info bola_vacia; bola_vacia.num = 0;
                            imprime_nodo(bola_vacia, coordenadas_x[k], coordenadas_y[k], 1); 
                        }
                        
                        // 5. Resetear variables de selección
                        aux = NULL;
                        cont_torre = -1;
                        origen_i = -1;
                        origen_j = -1;
                        flotante_x = -1;
                        flotante_y = -1;
                    }
                    
                } else {
                    // PRIMER ENTER - Seleccionar origen
                    if(listas[i][j] != NULL){
                        aux = listas[i][j]; // La bola superior
                        origen_i = i;
                        origen_j = j;
                        
                        // Calcular posición flotante (por encima del tubo)
                        flotante_x = x + 2; 
                        flotante_y = y - (ESPY - 1); 
                        
                        // Dibujar la bola flotando
                        imprime_nodo(aux->dato, flotante_x, flotante_y, 0);
                        
                        // Borrar visualmente la bola de su posición original
                        imprime_nodo(aux->dato, aux->dato.x, aux->dato.y, 1);

                        cont_torre++; // Indica que una bola está flotando
                    }
                }
                break;
        }       
        
        // Volver a dibujar el cursor en la posición actual
        cuadro(x, y, ancho, alto, color_torre);
        
    } while(tecla != ESC);
}
 
int cuenta_nodo(nodo *cab)
{
	nodo *aux=cab;
	int cont=0;

	while(aux!=NULL){
		aux=aux->sig;
		cont++;
	}
	return cont;
}
// Función para copiar una lista 
nodo* copiarLista(nodo* original) 
{
    if (original == NULL) return NULL;//Si la lista original es NULL, no hay nada que copiar -> retorna NULL

    nodo* nueva_lista = NULL;// Puntero a la cabeza de la nueva lista (inicialmente vacío)
    nodo* actual = original; //'actual' recorrerá la lista original
    nodo* ultimo = NULL;//'ultimo' mantiene el último nodo agregado en la nueva lista

    //Recorremos todos los nodos de la lista original
    while (actual != NULL) {
        nodo* nuevo_nodo = crea_nodoLS(actual->dato); // Crear un nuevo nodo copiando 'dato' del nodo actual
        // crea_nodoLS ya asigna memoria y copia 'dato' (x,y inicializados a -1)
        if (nueva_lista == NULL) {//  Si la nueva lista está vacía, este nuevo nodo será la cabeza
            nueva_lista = nuevo_nodo;
        } else { //Si ya existe al menos un nodo, enlazar el último con el nuevo
            ultimo->sig = nuevo_nodo;
        }
        ultimo = nuevo_nodo;// Actualizar 'ultimo' para que apunte al nuevo nodo
        actual = actual->sig;//Avanzar en la lista original
    }

    return nueva_lista; //Retornar la cabeza de la lista recién creada (copia)
}

// Función para liberar una lista (libera memoria de todos los nodos)
void liberarLista(nodo* cab) 
{
    nodo* actual = cab;           

    while (actual != NULL) {
        nodo* temp = actual;//Guardar el nodo actual en 'temp' (para poder liberarlo)
        actual = actual->sig;//Avanzar al siguiente antes de liberar (para no perder la referencia)
        free(temp);//Liberar la memoria del nodo previamente guardado
    }
}

int victoria(nodo *listas[2][5]) {
    // Verificar que tenemos exactamente 8 tubos llenos y 2 vacíos
    int tubosLlenos = 0;
    int tubosVacios = 0;

    for(int i = 0; i < 2; i++) {
        for(int j = 0; j < 5; j++) {
            if(listas[i][j] == NULL) {
                tubosVacios++;
                continue;
            }
            // Contar cuántas bolas hay en este tubo
            int contador = cuenta_nodo(listas[i][j]);
            // Si tiene 4 bolas, verificar que sean del mismo color
            if(contador == 4) {
                int color = listas[i][j]->dato.num;
                nodo *actual = listas[i][j];
                int mismoColor = 1;
                // Verificar que todas las bolas sean del mismo color
                while(actual != NULL) {
                    if(actual->dato.num != color) {
                        mismoColor = 0;
                        break;
                    }
                    actual = actual->sig;
                }
                if(mismoColor) {
                    tubosLlenos++;
                }
            }
        }
    }
    // Victoria si tenemos 8 tubos llenos correctamente y 2 vacíos
    return (tubosLlenos == 8 && tubosVacios == 2);
}
 
void temporizador(int tiempo_segundos) {
    // Mostrar mensaje de victoria centrado
    int centro_x = 74;
    int centro_y = 17;

    SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 10); // Verde

    gotoxy(centro_x, centro_y);

    printf("\n\n\n\n");

    SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 15); // Blanco

    // Mostrar solo el tiempo

    int minutos = tiempo_segundos / 60;

    int segundos = tiempo_segundos % 60;

    gotoxy(centro_x, centro_y + 5);

    printf("Tiempo total: %02d:%02d          ", minutos, segundos);

    gotoxy(centro_x, centro_y + 7);

    printf("Presiona cualquier tecla para continuar...");

    getch();

}
// =============================================
int mainfelicidades() {
	
	char nomArch2[50] = "felicitaciones.txt"; 
	int f=48, c=80;
	
	int **img=NULL;
	
	int i, x=10, y=5;
	
	system ("MODE 180, 180");
	
	img=(int **)malloc(f*sizeof(int*));
	for (i = 0; i < f; i++)
	img[i]=(int*)malloc(c*sizeof(int));
	
	leerImagen_juego(nomArch2, img, f, c);
	mostrarImg_juego(img, f, c, 0, 0);
	
	getch(); // espera ENTER antes de continuar
	
	return 0;
}

int mainjuego() {
	
	char nomArch1[50] = "juego2.txt"; 
	int f=44, c=83;
	
	int **img=NULL;
	
	int i, x=10, y=5;
	
	system ("MODE 180, 180");
	
	img=(int **)malloc(f*sizeof(int*));
	for (i = 0; i < f; i++)
	img[i]=(int*)malloc(c*sizeof(int));
	
	leerImagen_juego(nomArch1, img, f, c);
	mostrarImg_juego(img, f, c, 0, 0);
	
	getch(); // espera ENTER antes de continuar
	
	return 0;
}

void leerImagen_juego(char nomArch[30], int **img, int f, int c){
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

void mostrarImg_juego(int **img, int f, int c, int posX, int posY){
	
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

void portada_juego(int x, int y)
{
	HANDLE hcon;
	hcon=GetStdHandle(STD_OUTPUT_HANDLE);
	COORD dwPos;
	dwPos.X= x;
	dwPos.Y= y;
	SetConsoleCursorPosition(hcon, dwPos);
}
