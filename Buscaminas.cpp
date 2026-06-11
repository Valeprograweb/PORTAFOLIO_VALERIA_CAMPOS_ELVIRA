#include <iostream> // Biblioteca para entrada y salida
#include <cstdlib>  // Biblioteca para funciones aleatorias
#include <ctime>    // Biblioteca para manejar tiempo (semilla aleatoria)
using namespace std;

// Función para generar bombas aleatoriamente en el tablero
void Bomba(int matriz[10][10], int filas, int columnas, int limite, double proba) {
    int bombas = 0; // Contador de bombas colocadas

    // Coloca bombas hasta alcanzar el límite especificado
    while (bombas < limite) {
        int fila = rand() % filas;       // Genera una fila aleatoria
        int columna = rand() % columnas; // Genera una columna aleatoria

        // Si la celda está vacía y cumple la probabilidad, coloca una bomba
        if (matriz[fila][columna] == 0 && (rand() / double(RAND_MAX)) < proba) {
            matriz[fila][columna] = 1; // Marca la celda como bomba (1)
            bombas++;                  // Incrementa el contador de bombas
        }
    }
    cout << "Cantidad de bombas: " << bombas << endl; // Muestra la cantidad de bombas generadas
}

// Función para calcular cuántas bombas rodean cada celda
void calcularbombas(int matriz[10][10], int filas, int columnas, int resultado[10][10]) {
    // Coordenadas relativas para las 8 celdas vecinas
    int dx[] = {-1, -1, -1, 0, 0, 1, 1, 1};
    int dy[] = {-1, 0, 1, -1, 1, -1, 0, 1};

    // Recorre cada celda del tablero
    for (int i = 0; i < filas; i++) {
        for (int j = 0; j < columnas; j++) {
            if (matriz[i][j] == 1) {
                resultado[i][j] = -1; // Marca las celdas con bomba como -1
            } else {
                int contador = 0; // Contador para bombas vecinas

                // Revisa las 8 celdas vecinas
                for (int k = 0; k < 8; k++) {
                    int nx = i + dx[k]; // Calcula la fila de la vecina
                    int ny = j + dy[k]; // Calcula la columna de la vecina

                    // Si la vecina está dentro del tablero y tiene una bomba, incrementa el contador
                    if (nx >= 0 && nx < filas && ny >= 0 && ny < columnas && matriz[nx][ny] == 1) {
                        contador++;
                    }
                }
                resultado[i][j] = contador; // Asigna el número de bombas vecinas a la celda
            }
        }
    }
}

// Función para mostrar el tablero visible al jugador
void Tablero(int visible[10][10], int filas, int columnas) {
    // Imprime encabezados de columnas
    cout << "   ";
    for (int j = 0; j < columnas; j++) {
        cout << j << " "; // Encabezado con números de columnas
    }
    cout << endl;

    // Recorre cada fila del tablero
    for (int i = 0; i < filas; i++) {
        cout << i << " "; // Muestra el número de fila
        if (i < 10) cout << " "; // Alinea correctamente los números

        for (int j = 0; j < columnas; j++) {
            // Muestra el contenido de cada celda
            if (visible[i][j] == 0) {
                cout << "_|"; // Casilla oculta
            } else if (visible[i][j] == -1) {
                cout << "* "; // Bomba revelada
            } else {
                cout << visible[i][j] << " "; // Número de bombas cercanas
            }
        }
        cout << endl;
    }
}

// Función para manejar la selección de una celda y actualizar el tablero
void Resultado(int resultado[10][10], int visible[10][10], int x, int y, int filas, int columnas) {
    if (resultado[x][y] == -1) { // Si el jugador selecciona una bomba
        cout << "¡GAME OVER!.\n";
        visible[x][y] = -1; // Revela la bomba en el tablero visible
    } else {
        // Coordenadas relativas para las 8 celdas vecinas
        int dx[] = {-1, -1, -1, 0, 0, 1, 1, 1};
        int dy[] = {-1, 0, 1, -1, 1, -1, 0, 1};
        int mostradas = 0; // Contador de casillas reveladas

        // Revisa las celdas vecinas
        for (int k = 0; k < 8; k++) {
            int nx = x + dx[k];
            int ny = y + dy[k];

            // Revela celdas vecinas que no tengan bombas y que estén ocultas
            if (nx >= 0 && nx < filas && ny >= 0 && ny < columnas && resultado[nx][ny] != -1 && visible[nx][ny] == 0) {
                visible[nx][ny] = resultado[nx][ny];
                mostradas++;
            }
        }

        visible[x][y] = resultado[x][y]; // Revela la celda seleccionada

        cout << "Se revelaron " << mostradas << " casillas alrededor de (" << x << ", " << y << ").\n";
    }
}

int main() {
    srand(time(0)); // Inicializa la semilla para generar números aleatorios

    // Inicialización de variables
    int filas = 10;
    int columnas = 10;
    int limite = 25;         // Límite de bombas
    double proba = 0.4;      // Probabilidad de bomba
    int matriz[10][10] = {0}; // Tablero interno (bombas)
    int resultado[10][10] = {0}; // Tablero con conteo de bombas cercanas
    int visible[10][10] = {0}; // Tablero visible para el jugador

    clock_t start = clock(); // Inicia el temporizador del juego

    Bomba(matriz, filas, columnas, limite, proba); // Coloca bombas en el tablero
    calcularbombas(matriz, filas, columnas, resultado); // Calcula las bombas vecinas

    while (true) {
        Tablero(visible, filas, columnas); // Muestra el tablero visible

        int x = -1, y = -1; // Coordenadas del jugador
        char entrada[20];   // Cadena para capturar la entrada
        int espacios = 0;   // Contador de espacios en la entrada

        cout << "Ingresa las coordenadas (x y): ";
        cin.getline(entrada, 20); // Lee toda la línea

        // Verifica la cantidad de espacios en la entrada
        for (int i = 0; entrada[i] != '\0'; i++) {
            if (entrada[i] == ' ') {
                espacios++;
            }
        }

        if (espacios != 1) { // Si hay más de un espacio, muestra un error
            cout << "Error: Debes ingresar exactamente una coordenada separada por un solo espacio.\n";
            continue;
        }

        // Extrae las coordenadas y valida los rangos
        if (sscanf(entrada, "%d %d", &x, &y) != 2 || x < 0 || x >= filas || y < 0 || y >= columnas) {
            cout << "Error: Coordenadas inválidas. Intenta de nuevo.\n";
            continue;
        }

        system("cls"); // Limpia la pantalla
        Resultado(resultado, visible, x, y, filas, columnas); // Procesar la selección del jugador

        if (resultado[x][y] == -1) break; // Terminarr el juego si selecciona una bomba
    }

    clock_t end = clock(); // Finaliza el temporizador
    double elapsed_time = double(end - start) / CLOCKS_PER_SEC; // Calcula el tiempo jugado

    system("cls");
    cout << "Tablero final:\n";
    Tablero(resultado, filas, columnas); // Mostrar el tablero final

    cout << "Tiempo total de juego: " << elapsed_time << " segundos.\n"; // Mostrar el tiempo total del juego

    return 0;
}
