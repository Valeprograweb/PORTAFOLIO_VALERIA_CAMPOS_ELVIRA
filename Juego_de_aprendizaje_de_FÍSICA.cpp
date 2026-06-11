// Berlanga Contreras Ahtziri - 186106 y Campos Elvira Valeria - 186831

#include <stdlib.h>
#include <string.h>
#include <locale.h>
#include <stdio.h>
#include <math.h>
#include <time.h>
#include <ctype.h>

#define p printf
#define s scanf

// Prototipos
void tiro_parabolico();
void tiro_vertical();
void sumatoria_fuerzas();
void energia();

int minijuego(void (*funmini)(), char nivel[], char nombre[]);
void principiante(char nombre[]);
void avanzado(char nombre[]);

void guardarEstadistica(char nombre[], char fecha[], char minijuego[], int puntos);
void verEstadisticas();
void mostrarEstadisticasPorNombre();
void mostrarEstadisticasPorNivel();
void mostrarEstadisticasPorFecha();
void convertirAMinusculas(char *str);


void problema1(int&);
void problema2(int&);
void problema3(int&);
void problema4(int&);
void problema5(int&);

void guns1(int&);
void guns2(int&);
void guns3(int&);
void guns4(int&);
void guns5(int&);

void desafiando1(int&, char[], char[]);
void desafiando2(int&, char[], char[]);
char adivina();

int main() {
    setlocale(LC_ALL, "");

    char nombre[50];
    int opc;

    printf("Ingrese un Nickname: ");
    scanf("%49s", nombre);

    do {
        system("cls"); // Si usas Linux, cambia esto por system("clear")
        printf("\n---------- MENÚ PRINCIPAL ----------\n");
        printf("1. Nivel Principiante\n");
        printf("2. Nivel Avanzado\n");
        printf("3. Ver Estadísticas\n");
        printf("4. Salir\n");
        printf("Seleccione una opción: ");
        scanf("%d", &opc);

        system("cls");

        switch (opc) {
            case 1:
                principiante(nombre);
                break;
            case 2:
                avanzado(nombre);
                break;
            case 3:
                verEstadisticas();
                break;
            case 4:
                printf("Saliendo del juego...\n");
                break;
            default:
                printf("Opción no válida. Intente de nuevo.\n");
        }
    } while (opc != 4);

    return 0;
}

// ---- MENÚS POR NIVEL ----
void principiante(char nombre[]) {
    int repetir = 1;
    while (repetir) {
        int nivel;
        printf("\n--- Nivel Principiante ---\n");
        printf("1. Desafiando la Gravedad\n");
        printf("2. Guns and Ships\n");
        printf("Seleccione un minijuego: ");
        scanf("%d", &nivel);

        system("cls");

        if (nivel == 1)
            repetir = minijuego(tiro_vertical, "Principiante", nombre);
        else if (nivel == 2)
            repetir = minijuego(tiro_parabolico, "Principiante", nombre);
        else
            printf("Opción no válida.\n");
    }
}

void avanzado(char nombre[]) {
    int repetir = 1;
    while (repetir) {
        int nivel;
        printf("\n--- Nivel Avanzado ---\n");
        printf("1. Fuerzas Discontinuas\n");
        printf("2. Energía\n");
        printf("Seleccione un minijuego: ");
        scanf("%d", &nivel);

        system("cls");

        if (nivel == 1)
            repetir = minijuego(sumatoria_fuerzas, "Avanzado", nombre);
        else if (nivel == 2)
            repetir = minijuego(energia, "Avanzado", nombre);
        else
            printf("Opción no válida.\n");
    }
}

// ---- CONTROL DE MINIJUEGOS ----
int minijuego(void (*funmini)(), char nivel[], char nombre[]) {
    int opc2;
    int intento = 1;

    do {
        funmini();
        intento++;

        printf("\n¿Qué deseas hacer ahora?");
        printf("\n1. Repetir minijuego");
        printf("\n2. Regresar al menú de nivel %s", nivel);
        printf("\n3. Regresar al menú principal");
        printf("\nSelecciona una opción: ");
        scanf("%d", &opc2);

        system("cls");

        if (opc2 == 1) continue;
        else if (opc2 == 2) return 1;
        else if (opc2 == 3) return 0;
        else {
            printf("Opción inválida. Regresando al menú principal.\n");
            return 0;
        }
    } while (opc2 == 1);

    return 0;
}

// ---- MINIJUEGOS ----
void tiro_vertical() {
	
    int acumptsdes = 0;
    char nombre[50], fecha[20];
    
     p("\t\t\tDESAFIANDO LA GRAVEDAD");
     
     p("\n\nIngrese su nombre: ");
    s("%s", &nombre);
    p("Ingrese la fecha (dd/mm/aaaa): ");
    s("%s", &fecha);
     p("\n\nEn este minijuego jugaras adivina quien con conceptos de MRU y MRUA...");
    
    desafiando1(acumptsdes, nombre, fecha);
    desafiando2(acumptsdes, nombre, fecha);
    
    p("\n\nTERMINASTE 'GUNS AND SHIPS' GANASTE %d PUNTOS!\n", acumptsdes);
    
    guardarEstadistica(nombre, fecha, "Desafiando la Gravedad", acumptsdes);
}

void desafiando1(int &acumptsdes, char nombre[], char fecha[]) {
    int ptsdes = 50, intentos = 0;
	char respdes[20] = "aceleracion"; 
	int ex = 0;

    p ("\n\nADVINA QUIEN...\nADIVINANZA 1:\n\n");
    do {	
    	char comp = 0;
		comp = adivina();
		switch (comp) {
			case '1': p ("\nNo,no soy un movimiento\n\n"); break;
			case '2': p ("\nSi,soy un componente\n\n"); break;
			case '3': p ("\nNo,no formo parte del MRU\n\n"); break;
			case '4': p ("\nSi,si formo parte del MRUA\n\n"); break;
			case '5': p ("\nNo, no estoy en ambos movimientos\n\n"); break;
			case '6': p ("\nNo, no me puedes medir en metros\n\n"); break;
			case '7': p ("\nNo, soy algo constante en el tiempo\n\n"); break;
			case '8': p ("\nNo, no soy una unidad de medida temporal\n\n"); break;
			case '9': {
				char usuario[20];
				p ("\nInserte su respuesta usando solo minisculas y sin acentuar.\n");
				s ("%s", &usuario);
				fflush(stdin);
				int result = strcmp(respdes, usuario);
				if (result == 0){
					p ("\n¡GANASTE!\n");
					ex = 1;
				}
				break;
			}
			default: {
				p ("OPCIÓN DE PREGUNTA INVALIDA, INTENTE DE NUEVO.\n");
				intentos -= 1;
				break;
			}
		}
		intentos++;
		
		if (ex == 1) break;
		
		if (intentos > 3) ptsdes -= 10;
		
		if (intentos == 7) {
			p ("EL SIGUIENTE INTENTO ES TU ULTIMA OPORTUNIDAD DE ADIVINAR.\n\n");
		}
		
	} while(intentos < 8);
	
	p ("\nLA RESPUESTA ERA: aceleracion\n\n");
	acumptsdes += ptsdes;
    p("Pts obtenidos=%d | Pts acumulados=%d\n", ptsdes, acumptsdes);

}

void desafiando2(int &acumptsdes, char nombre[], char fecha[]) {
    int ptsdes = 50, intentos = 0;
	char respdes[20] = "velocidad"; 
	int ex = 0;

    p ("\n\nADVINA QUIEN...\nADIVINANZA 2:\n\n");
    do {	
    	char comp = 0;
		comp = adivina();
		switch (comp) {
			case '1': p ("\nNo, no soy un movimiento\n\n"); break;
			case '2': p ("\nSi, soy un componente\n\n"); break;
			case '3': p ("\nSi, si formo parte del MRU\n\n"); break;
			case '4': p ("\nSi, si formo parte del MRUA\n\n"); break;
			case '5': p ("\nSi, si estoy en ambos movimientos\n\n"); break;
			case '6': p ("\nNo, no me puedes medir en metros\n\n"); break;
			case '7': p ("\nSi, si cambio respecto al tiempo\n\n"); break;
			case '8': p ("\nNo, no soy una unidad de medida temporal\n\n"); break;
			case '9': {
				char usuario[20];
				p ("\nInserte su respuesta usando solo minisculas y sin acentuar.\n");
				s ("%s", &usuario);
				fflush(stdin);
				int result = strcmp(respdes, usuario);
				if (result == 0){
					p ("\n¡GANASTE!\n");
					ex = 1;
				}
				break;
			}
			default: {
				p ("OPCIÓN DE PREGUNTA INVALIDA, INTENTE DE NUEVO.\n");
				intentos -= 1;
				break;
			}
		}
		intentos++;
		
		if (ex == 1) break;
		
		if (intentos > 3) ptsdes -= 10;
		
		if (intentos == 7) {
			p ("EL SIGUIENTE INTENTO ES TU ULTIMA OPORTUNIDAD DE ADIVINAR.\n\n");
		}
		
	} while(intentos < 8);
	
	p ("\nLA RESPUESTA ERA: velocidad\n\n");
	acumptsdes += ptsdes;
    p("Pts obtenidos=%d | Pts acumulados=%d\n", ptsdes, acumptsdes);


}

char adivina() {
	char resp1 = 0;
	p ("¿Qué deseas preguntar?");
	p ("\n\t1. ¿Eres un tipo de movimiento?");
	p ("\n\t2. ¿Eres un componente?");
	p ("\n\t3. ¿Estás en el MRU?");
	p ("\n\t4. ¿Estás en el MRUA?");
	p ("\n\t5. ¿Estás en ambos movimientos?");
	p ("\n\t6. ¿Se te puede medir en metros?");
	p ("\n\t7. ¿Se te puede comparar en distintos puntos respecto al tiempo?");
	p ("\n\t8. ¿Eres una unidad de medida temporal?");
	p ("\n\t9. Mi respuesta es...\n");
	s ("%c", &resp1);
	fflush(stdin);
	return (resp1);
}

void tiro_parabolico() {
	
    int acum = 0;
    char nombre[50], fecha[20];

    p("\n\t\t\tGUNS AND SHIPS");
    
    p("\n\nIngrese su nombre: ");
    s("%s", nombre);
    p("Ingrese la fecha (dd/mm/aaaa): ");
    s("%s", fecha);

    p("\n\nEn este minijuego resolverás problemas de tiro parabólico...");
    guns1(acum);
    guns2(acum);
    guns3(acum);
    guns4(acum);
    guns5(acum);

    p("\n\nTERMINASTE 'GUNS AND SHIPS' GANASTE %d PUNTOS!\n", acum);
    
    guardarEstadistica(nombre, fecha, "Guns and Ships", acum);
}

void guns1(int &acum){
    int pntsguns = 20, contar = 0; 
    float resp = 0;

    p ("\n\n PROBLEMA 1\n");
    p ("Un jugador lanza una pelota desde una distancia de 30 metros respecto a un edificio.\n");
    p ("La velocidad inicial del lanzamiento es de 20 m/s y el ángulo con respecto a la horizontal es de 60°.\n");
    p ("¿A qué altura golpeará la pelota el edificio si lo hace justo a los 30 metros en el eje x?\n");
    p ("Considera tu respuesta en metros. Ingresa solo el número con dos decimales como resp.\n\nR= ");
    s("%f", &resp);

    while (fabs(resp - 7) > 0.01 && contar < 3) {
        pntsguns -= 5;
        if (pntsguns < 0) pntsguns = 0;
        contar++;
        p("RESPUESTA INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%f", &resp);
    }

    if (fabs(resp - 7) <= 0.01) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pntsguns);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA 7.86 METROS. GANASTE 0 Puntos .\n");
        pntsguns = 0;
    }

    acum += pntsguns;
    p("Puntos obtenidos=%d | Puntos acumulados=%d\n", pntsguns, acum);
}

void guns2(int &acum){
    int pntsguns = 20, contar = 0;
    int resp = 0;

    p ("\n\n PROBLEMA 2\n");
    p ("Un edificio de 15 metros de altura se encuentra a 25 metros de distancia del jugador.\n");
    p ("El jugador lanza una pelota con una velocidad de 22 m/s y un ángulo de 45°.\n");
    p ("¿Golpeará la pelota el edificio o pasará por encima?\n");
    p ("Tu respuesta: Sí=1 | No=0\n\nR= ");
    s ("%d", &resp);

    while (resp != 0 && contar < 1) {
        pntsguns -= 10;
        if (pntsguns < 0) pntsguns = 0;
        contar++;
        p("resp INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%d", &resp);
    }

    if (resp == 0) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pntsguns);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA 'No'. GANASTE 0 Puntos .\n");
        pntsguns = 0;
    }

    acum += pntsguns;
    p("Puntos obtenidos=%d | Puntos acumulados=%d\n", pntsguns, acum);
}

void guns3(int &acum){
    int pntsguns = 20, contar = 0; 
    float resp = 0;

    p ("\n\n PROBLEMA 3\n");
    p ("Un jugador quiere golpear un edificio que se encuentra a 18 metros de distancia.\n");
    p ("Lanza la pelota con una velocidad inicial de 24 m/s a un ángulo de 50°.\n");
    p ("¿En qué instante de tiempo (en segundos) la pelota golpeará el edificio, si se asume que impacta justo a los 18 metros en el eje x?\n");
    p ("Ingresa solo el número con dos decimales como respuesta.\n\nR= ");
    s("%f", &resp);

    while (fabs(resp - 1) > 0.01 && contar < 3) {
        pntsguns -= 5;
        if (pntsguns < 0) pntsguns = 0;
        contar++;
        p("RESPUESTA INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%f", &resp);
    }

    if (fabs(resp - 1) <= 0.01) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pntsguns);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA 1.17 SEGUNDOS. GANASTE 0 Puntos.\n");
        pntsguns = 0;
    }

    acum += pntsguns;
    p("Puntos obtenidos=%d | Puntos acumulados=%d\n", pntsguns, acum);
}

void guns4(int &acum){
    int pntsguns = 20, contar = 0; 
    float resp = 0;

    p ("\n\n PROBLEMA 4\n");
    p ("Un jugador lanza una pelota con una velocidad de 25 m/s y un ángulo de 40° con respecto a la horizontal.\n");
    p ("¿A qué distancia del edificio debe pararse el jugador para que la pelota golpee un punto del edificio que está a 10 metros de altura?\n");
    p ("Considera tu respuesta en metros. Ingresa solo el número con un decimal como respuesta.\n\nR= ");
    s("%f", &resp);

    while (fabs(resp - 13) > 0.1 && contar < 3) {
        pntsguns -= 5;
        if (pntsguns < 0) pntsguns = 0;
        contar++;
        p("RESPUESTA INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%f", &resp);
    }

    if (fabs(resp - 13) <= 0.1) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pntsguns);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA 13.3 METROS. GANASTE 0 Puntos .\n");
        pntsguns = 0;
    }

    acum += pntsguns;
    p("Puntos obtenidos=%d | Puntos acumulados=%d\n", pntsguns, acum);
}

void guns5(int &acum){
    int pntsguns = 20, contar = 0; 
    float resp = 0;

    p ("\n\n PROBLEMA 5\n");
    p ("Un jugador está a 20 metros de un edificio y quiere golpear un punto que se encuentra a 8 metros de altura.\n");
    p ("Si lanza la pelota con un ángulo de 45°, ¿con qué velocidad debe lanzarla para que impacte exactamente en ese punto?\n");
    p ("Considera tu resp en metros por segundo. Ingresa solo el número con dos decimales como respuesta.\n\nR= ");
    s("%f", &resp);

    while (fabs(resp - 18) > 0.01 && contar < 3) {
        pntsguns -= 5;
        if (pntsguns < 0) pntsguns = 0;
        contar++;
        p("RESPUESTA INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%f", &resp);
    }

    if (fabs(resp - 18) <= 0.01) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pntsguns);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA 18.08 m/s. GANASTE 0 Puntos .\n");
        pntsguns = 0;
    }

    acum += pntsguns;
    p("Puntos  obtenidos=%d | Puntos acumulados=%d\n", pntsguns, acum);
}

void sumatoria_fuerzas() {
	
	int acumPts = 0;
	char nombre[50], fecha[20];
	
	p("\t\t\tFUERZAS DISPAREJAS");
	
	p("\n\nIngrese su nombre: ");
    s("%s", nombre);
    p("Ingrese la fecha (dd/mm/aaaa): ");
    s("%s", fecha);

    p("\n\nEn este minijuego resolveras problemas acerca de equilibrio de fuerzas...");
    printf("\n+---------------+-------------------+");
    printf("\n|%-15s| %-20s\n", "    Intentos", "Puntaje  |");
    printf("+---------------+-------------------+\n");
    printf("%-15s | %-20s\n", "| 1 ", "20 pts            |");
    printf("+---------------+-------------------+\n");
    printf("%-15s | %-20s\n", "| 2", "10 pts            |");
    printf("+---------------+-------------------+\n");
    printf("%-15s | %-20s\n", "| 3", "5 pts            |");
    printf("+---------------+-------------------+\n");
    printf("%-15s | %-20s\n", "| 4", "0 pts             |");
    printf("+---------------+-------------------+\n");

    problema1(acumPts);
    problema2(acumPts);
    problema3(acumPts);
    problema4(acumPts);
    problema5(acumPts);

    p("\n\nTERMINASTE 'FUERZAS DISPAREJAS' GANASTE %d PUNTOS!\n", acumPts);
    
    guardarEstadistica(nombre, fecha, "Fuerzas Disparejas", acumPts);

}

void problema1(int &acumPts){
    int pts = 20, cont = 0;
    float respuesta = 0;

    p ("\n\n PROBLEMA 1\n");
    p ("Un bloque de 10 kg descansa sobre un plano inclinado a 30° respecto a la horizontal.No hay fricción.\n");
    p ("¿Qué magnitud debe tener una fuerza F aplicada paralela al plano hacia arriba para mantener el bloque en equilibrio?\n");
    p ("Considera que la gravedad es la de la Tierra: 9.8 m/s²\n\nR= ");
    s ("%f", &respuesta);

    while (fabs(respuesta - 49) > 0.01 && cont < 3) {
        pts -= 5;
        if (pts < 0) pts = 0;
        cont++;
        p("RESPUESTA INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%f", &respuesta);
    }

    if (fabs(respuesta - 49) <= 0.01) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pts);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA 49 N. GANASTE 0 PTS.\n");
        pts = 0;
    }

    acumPts += pts;
    p("Pts obtenidos=%d | Pts acumulados=%d\n", pts, acumPts);
}

void problema2(int &acumPts){
    int pts = 20, cont = 0;
    float respuesta = 0;

    p ("\n\n PROBLEMA 2\n");
    p ("Un objeto de 5 kg cuelga de un resorte vertical en un planeta desconocido.\n");
    p ("El resorte se estira 0.2 metros hasta alcanzar el equilibrio. La constante del resorte es de 250 N/m.\n");
    p ("¿Cuál es el valor de la aceleración gravitacional en ese planeta?\n");
    s ("%f", &respuesta);

    while (fabs(respuesta - 10) > 0.01 && cont < 3) {
        pts -= 5;
        if (pts < 0) pts = 0;
        cont++;
        p("RESPUESTA INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%f", &respuesta);
    }

    if (fabs(respuesta - 10) <= 0.01) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pts);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA  10 m/s². GANASTE 0 PTS.\n");
        pts = 0;
    }

    acumPts += pts;
    p("Pts obtenidos=%d | Pts acumulados=%d\n", pts, acumPts);

}

void problema3(int &acumPts){
    int pts = 20, cont = 0;
    float respuesta = 0;

    p ("\n\n PROBLEMA 3\n");
    p ("Una caja de 20 kg está sobre una superficie horizontal rugosa. Se aplica una fuerza horizontal de 50 N.\n");
    p ("¿Qué valor debe tener la fuerza de fricción para mantener la caja en equilibrio?\n");
    p ("Considera que la gravedad es la de la Tierra: 9.8 m/s²\n\nR= ");
    s("%f", &respuesta);

    while (fabs(respuesta - 50) > 0.01 && cont < 3) {
        pts -= 5;
        if (pts < 0) pts = 0;
        cont++;
        p("RESPUESTA INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%f", &respuesta);
    }

    if (fabs(respuesta - 50) <= 0.01) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pts);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA 50 N. GANASTE 0 PTS.\n");
        pts = 0;
    }

    acumPts += pts;
    p("Pts obtenidos=%d | Pts acumulados=%d\n", pts, acumPts);
}

void problema4(int &acumPts){
    int pts = 20, cont = 0;
    int respuesta = 0;

    p ("\n\n PROBLEMA 4\n");
    p ("Un bloque de 15 kg está sobre una superficie horizontal con un coeficiente de fricción estática de 0.4.\n");
    p ("Se aplica una fuerza horizontal de 80 N.\n");
    p ("¿El bloque permanece en equilibrio o comenzará a moverse?\n");
    p ("Tu respuesta: Sí=1 | No=0\n\nR= ");
    s ("%d", &respuesta);

    while (respuesta != 0 && cont < 1) {
        pts -= 10;
        if (pts < 0) pts = 0;
        cont++;
        p("RESPUESTA INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%d", &respuesta);
    }

    if (respuesta == 0) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pts);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA 'No mantiene el equilibrio'. GANASTE 0 PTS.\n");
        pts = 0;
    }

    acumPts += pts;
    p("Pts obtenidos=%d | Pts acumulados=%d\n", pts, acumPts);
}

void problema5(int &acumPts){
    int pts = 20, cont = 0;
    int respuesta = 0;

    p ("\n\n PROBLEMA 5\n");
    p ("Un objeto de 8 kg cuelga del techo mediante una cuerda.\n");
    p ("De pronto, se le aplica una fuerza horizontal de 60 N al objeto.\n");
    p ("¿El objeto sigue en equilibrio o la cuerda se tensa en otra dirección?\n");
    p ("(Encuentra si la cuerda puede mantener el equilibrio considerando su tensión máxima es de 100 N).\n");
    p ("Tu respuesta: Sí=1 | No=0\n\nR= ");
    s ("%d", &respuesta);

    while (respuesta != 1 && cont < 1) {
        pts -= 10;
        if (pts < 0) pts = 0;
        cont++;
        p("RESPUESTA INCORRECTA, INTENTA DE NUEVO.\nR= ");
        s("%d", &respuesta);
    }

    if (respuesta == 1) {
        p("¡CORRECTO! GANASTE %d PUNTOS.\n", pts);
    } else {
        p("¡PERDISTE! LA RESPUESTA ERA 'Si mantiene el equilibrio'. GANASTE 0 PTS.\n");
        pts = 0;
    }

    acumPts += pts;
    p("Pts obtenidos=%d | Pts acumulados=%d\n", pts, acumPts);
}

void energia() {
    setlocale(LC_ALL, "Spanish");
    
     char nombre[50], fecha[20];
    
    p("\t\t\tENERGÍA EN ACCIÓN");
    
    p("\n\nIngrese su nombre: ");
    s("%s", nombre);
    p("Ingrese la fecha (dd/mm/aaaa): ");
    s("%s", fecha);

    char preg[10][150] = {
        "1. Aunque no soy visible, me haces trabajar,\n   cuando tú te mueves, yo empiezo a actuar.\n   Puedo ser cinética o también potencial.",
        "2. Estoy en lo alto, esperando bajar,\n   cuando caes, me transformo sin avisar.\n   Dependo de la altura y la gravedad.",
        "3. Cuando algo se mueve, me puedes notar,\n   mientras más velocidad, más me vas a encontrar.",
        "4. No se crea ni se pierde, solo cambia sin cesar,\n   en mil formas diferentes me puedes encontrar.\n   Soy una ley, muy importante en verdad.",
        "5. Si una fuerza yo aplico y algo logro mover,\n   aunque me canse un poquito, algo pude hacer.\n   Soy energía en acción, no te dejes confundir.",
        "6. De una forma a otra puedo pasar,\n   sin desaparecer ni escapar. De química a luz, de viento a calor,\n   mi arte es cambiar, soy todo un actor.",
        "7. No importa solo cuánto puedas hacer, \n   sino qué tan rápido lo puedes tener.\n   Trabajo en segundos te ayudaré a medir.",
        "8. En mí hay dos que siempre van juntas:\n   una por moverse, otra por altura.\n   Soy la suma fiel de ese par especial.",
        "9. Me estiras, me aprietas, me puedo comprimir,\n   pero en mi interior, fuerza puedo reunir.\n   Regreso a mi forma si me dejas en paz.",
        "10. Si hablas de energía y de cuánto hay,\n   yo soy la medida, eso es lo que hay.\n   En física soy rey, no me puedes negar."
    };

    char res[10][150] = {
        "energia",
        "energia potencial gravitatoria",
        "energia cinetica",
        "conservacion de la energia",
        "trabajo",
        "transformacion de energia",
        "potencia",
        "energia mecanica",
        "resorte",
        "joules"
    };

    char resp2[150];
    int total = 0, usadas[10] = {0}, ronda = 1;
    srand(time(NULL));

    while (ronda <= 5) {
        int indice;
        do {
            indice = rand() % 10;
        } while (usadas[indice]);

        usadas[indice] = 1;
        int intent = 0, acierto = 0;

        printf("\n------------------------ RONDA %d ------------------------\n", ronda);
        printf("\n%s\n", preg[indice]);

        while (!acierto && intent < 6) {
            printf("\nTu respuesta: ");
            fgets(resp2, 150, stdin);
            resp2[strcspn(resp2, "\n")] = '\0';
            intent++;

            if (strcmp(res[indice], resp2) == 0) {
                acierto = 1;
                int pts;
                if (intent <= 3) pts = 20;
                else if (intent == 4) pts = 15;
                else if (intent == 5) pts = 10;
                else pts = 5;

                total += pts;
                printf("¡Correcto!\nIntentos: %d\nPuntos obtenidos: %d\n", intent, pts);
            } else {
                printf("Incorrecto, inténtalo de nuevo.\nIntentos: %d\n", intent);
            }

            printf("Puntaje acumulado: %d\n", total);
        }

        if (!acierto) {
            printf("\n¡Se acabaron los intentos!\n");
            printf("La respuesta correcta era: %s\n", res[indice]);
        }

        ronda++;
    }

    printf("\nJuego terminado. Puntaje final: %d/100\n", total);
    
    guardarEstadistica(nombre, fecha, "Energía en Acción", total);
}

//ESTADÍSTICAS
// Función para guardar estadísticas en archivo
void guardarEstadistica(char nombre[], char fecha[], char minijuego[], int puntos) {
    FILE *archivo;
    
    // Abrir archivo en modo append (añadir al final)
    archivo = fopen("estadisticas.txt", "a");
    
    if (archivo == NULL) {
        printf("Error al abrir el archivo de estadísticas.\n");
        return;
    }
    
    // Escribir los datos en el archivo
    fprintf(archivo, "%s|%s|%s|%d\n", nombre, fecha, minijuego, puntos);
    
    fclose(archivo);
}

// Menú para ver estadísticas
void verEstadisticas() {
    int opcion;
    
    do {
        system("cls");
        printf("\n----- MENÚ DE ESTADÍSTICAS -----\n");
        printf("1. Buscar por nombre de jugador\n");
        printf("2. Buscar por nivel/minijuego\n");
        printf("3. Buscar por fecha\n");
        printf("4. Regresar al menú principal\n");
        printf("Seleccione una opción: ");
        scanf("%d", &opcion);
        
        system("cls");
        
        switch(opcion) {
            case 1:
                mostrarEstadisticasPorNombre();
                break;
            case 2:
                mostrarEstadisticasPorNivel();
                break;
            case 3:
                mostrarEstadisticasPorFecha();
                break;
            case 4:
                return;
            default:
                printf("Opción no válida. Intente de nuevo.\n");
        }
        
        if (opcion != 4) {
            printf("\nPresione Enter para continuar...");
            getchar();
            getchar();
        }
    } while (opcion != 4);
}

// Función para mostrar estadísticas por nombre
void mostrarEstadisticasPorNombre() {
    char nombreBusqueda[50];
    char nombreArchivo[50], fecha[20], minijuego[50];
    int puntos, encontrado = 0;
    int totalPuntos = 0, partidas = 0;
    
    printf("Ingrese el nombre del jugador a buscar: ");
    scanf("%49s", nombreBusqueda);
    convertirAMinusculas(nombreBusqueda);
    
    FILE *archivo = fopen("estadisticas.txt", "r");
    if (archivo == NULL) {
        printf("No hay estadísticas registradas aún.\n");
        return;
    }
    
    printf("\nEstadísticas para %s:\n", nombreBusqueda);
    printf("+------------+----------------------+-------------------+--------+\n");
    printf("| Fecha      | Minijuego            | Partidas jugadas  | Puntos |\n");
    printf("+------------+----------------------+-------------------+--------+\n");
    
    // Leer archivo línea por línea
    while (fscanf(archivo, "%49[^|]|%19[^|]|%49[^|]|%d\n", nombreArchivo, fecha, minijuego, &puntos) != EOF) {
        char nombreTemp[50];
        strcpy(nombreTemp, nombreArchivo);
        convertirAMinusculas(nombreTemp);
        
        if (strcmp(nombreTemp, nombreBusqueda) == 0) {
            printf("| %-10s | %-20s | %-17d | %-6d |\n", fecha, minijuego, 1, puntos);
            totalPuntos += puntos;
            partidas++;
            encontrado = 1;
        }
    }
    
    if (encontrado) {
        printf("+------------+----------------------+-------------------+--------+\n");
        printf("| TOTAL      |                      | %-17d | %-6d |\n", partidas, totalPuntos);
        printf("+------------+----------------------+-------------------+--------+\n");
    } else {
        printf("\nNo se encontraron estadísticas para el jugador %s.\n", nombreBusqueda);
    }
    
    fclose(archivo);
}

// Función para mostrar estadísticas por nivel/minijuego
void mostrarEstadisticasPorNivel() {
    char nivelBusqueda[50];
    char nombre[50], fecha[20], minijuego[50];
    int puntos, encontrado = 0;
    int totalPuntos = 0, partidas = 0;
    
    printf("Seleccione el nivel/minijuego a buscar:\n");
    printf("1. Guns and Ships\n");
    printf("2. Desafiando la Gravedad\n");
    printf("3. Fuerzas Disparejas\n");
    printf("4. Energía en Acción\n");
    printf("Opción: ");
    
    int opcion;
    scanf("%d", &opcion);
    
    switch(opcion) {
        case 1: strcpy(nivelBusqueda, "Guns and Ships"); break;
        case 2: strcpy(nivelBusqueda, "Desafiando la Gravedad"); break;
        case 3: strcpy(nivelBusqueda, "Fuerzas Disparejas"); break;
        case 4: strcpy(nivelBusqueda, "Energía en Acción"); break;
        default: 
            printf("Opción no válida.\n");
            return;
    }
    
    FILE *archivo = fopen("estadisticas.txt", "r");
    if (archivo == NULL) {
        printf("No hay estadísticas registradas aún.\n");
        return;
    }
    
    printf("\nEstadísticas para %s:\n", nivelBusqueda);
    printf("+----------------+------------+--------+\n");
    printf("| Nombre         | Fecha      | Puntos |\n");
    printf("+----------------+------------+--------+\n");
    
    while (fscanf(archivo, "%49[^|]|%19[^|]|%49[^|]|%d\n", nombre, fecha, minijuego, &puntos) != EOF) {
        if (strcmp(minijuego, nivelBusqueda) == 0) {
            printf("| %-14s | %-10s | %-6d |\n", nombre, fecha, puntos);
            totalPuntos += puntos;
            partidas++;
            encontrado = 1;
        }
    }
    
    if (encontrado) {
        printf("+----------------+------------+--------+\n");
        printf("| TOTAL PARTIDAS | %-10d | %-6d |\n", partidas, totalPuntos);
        printf("+----------------+------------+--------+\n");
    } else {
        printf("\nNo se encontraron estadísticas para %s.\n", nivelBusqueda);
    }
    
    fclose(archivo);
}

// Función para mostrar estadísticas por fecha
void mostrarEstadisticasPorFecha() {
    char fechaBusqueda[20];
    char nombre[50], fecha[20], minijuego[50];
    int puntos, encontrado = 0;
    int totalPuntos = 0, partidas = 0;
    
    printf("Ingrese la fecha a buscar (dd/mm/aaaa): ");
    scanf("%19s", fechaBusqueda);
    
    FILE *archivo = fopen("estadisticas.txt", "r");
    if (archivo == NULL) {
        printf("No hay estadísticas registradas aún.\n");
        return;
    }
    
    printf("\nEstadísticas para %s:\n", fechaBusqueda);
    printf("+----------------+----------------------+--------+\n");
    printf("| Nombre         | Minijuego            | Puntos |\n");
    printf("+----------------+----------------------+--------+\n");
    
    while (fscanf(archivo, "%49[^|]|%19[^|]|%49[^|]|%d\n", nombre, fecha, minijuego, &puntos) != EOF) {
        if (strcmp(fecha, fechaBusqueda) == 0) {
            printf("| %-14s | %-20s | %-6d |\n", nombre, minijuego, puntos);
            totalPuntos += puntos;
            partidas++;
            encontrado = 1;
        }
    }
    
    if (encontrado) {
        printf("+----------------+----------------------+--------+\n");
        printf("| TOTAL PARTIDAS | %-20d | %-6d |\n", partidas, totalPuntos);
        printf("+----------------+----------------------+--------+\n");
    } else {
        printf("\nNo se encontraron estadísticas para la fecha %s.\n", fechaBusqueda);
    }
    
    fclose(archivo);
}

// Función auxiliar para convertir a minúsculas
void convertirAMinusculas(char *str) {
    for(int i = 0; str[i]; i++) {
        str[i] = tolower(str[i]);
    }
}

