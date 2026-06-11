#include <iostream>
#include <windows.h>
#include <locale.h>
using namespace std;
int introduccion(),menu(),dos(),tres(),cuatro();

main() {
    setlocale(LC_CTYPE, "Spanish");
    system("cls");
    int a;

    cout<< "  MM   MM " <<"       A       "<< " NN     N   "<< "UU   UU "<<"       A       "<< "LL      "<<endl;
    cout<< "  M M M M " <<"      A A      "<< " N NN   N   "<< "UU   UU "<<"      A A      "<< "LL      "<<endl;
    cout<< "  M  M  M " <<"     AAAAA     "<< " N  NN  N   "<< "UU   UU "<<"     AAAAA     "<< "LL      "<<endl;
    cout<< "  M     M " <<"    AA   AA    "<< " N   NN N   "<< "UU   UU "<<"    AA   AA    "<< "LL      "<<endl;
    cout<< "  M     M " <<"   AA     AA   "<< " N    NNN   "<< " UUUUU  "<<"   AA     AA   "<< "LLLLLL  "<<endl;
    cout<<endl<<endl;
    cout << "                    CCCCCCCC  "<< "        ++      "<< "          ++      "<< endl;
    cout << "                   CC       "<< "          ++      "<< "          ++      " << endl;
    cout << "                   CC       "<< "          ++      "<< "          ++      "  << endl;
    cout << "                   CC       "<< "          ++      "<< "          ++      "  << endl;
    cout << "                   CC       "<< "    ++++++++++++++"<< "    ++++++++++++++      "  << endl;
    cout << "                   CC       "<< "    ++++++++++++++"<< "    ++++++++++++++      "  << endl;
    cout << "                   CC       "<< "          ++      "<< "          ++      "  << endl;
    cout << "                   CC       "<< "          ++      "<< "          ++      "  << endl;
    cout << "                   CC       "<< "          ++      "<< "          ++      "  << endl;
    cout << "                   CC       "<< "          ++      "<< "          ++      "  << endl;
    cout << "                    CCCCCCCC "<< "         ++      "<< "          ++      "  << endl;

    cout<<endl<<endl;
    cout<<"Selecciona la acción que desees hacer"<<endl;
    cout<<"1)Menú"<<endl;
    cout<<"2)Salir"<<endl;
    cin>>a;

    if(a==1)
        menu();
    if(a==2)
        exit(0);

    system ("pause");
    return(0);
}


menu()
 {setlocale(LC_CTYPE, "Spanish");
     int opcion;

     system("cls");
    cout << "||||||||| MANUAL C++ |||||||||\n"<<endl;

    cout << " Menú Principal \n"<<endl;
    cout << "1. Variables y Namespace\n";
    cout << "2. Estructura selectiva o condicional (CICLO IF)\n";
    cout << "3. Estructura ciclíca o interactiva (DO, WHILE, FOR)\n";
    cout << "4. Arreglos\n";
    cout << "5. Portada\n";

    cout<<"Opción elegida  ";
    cin >> opcion;

    if (opcion==5)
    main();
    if (opcion==1)
    introduccion();
    if (opcion==2)
    dos();
    if (opcion==3)
    tres();
    if (opcion==4)
    cuatro();

return(1);
 }

introduccion()
{
    int respuesta;
    setlocale(LC_CTYPE, "Spanish");
    system("cls");
    cout<< "VARIABLES Y NAMESPACE++\n";
    cout << "---------------------------------" << endl;
    cout<< "Sistema de almacenamiento de información dentro de ls memoria de acuerdo a un tipo de dato."<<endl;
    cout<< "Cada variable tiene un tipo, nombre y valor."<<endl<<endl;
    cout<<"TIPOS DE DATOS"<<endl;
    cout <<"-------------------------------------" << endl;
	cout<<"int : valores enteros sin decimales (2 o 4 bytes)."<<endl;
	cout<<"float: numeros con decimales con 6-7 decimales de precisión (4 bytes)."<<endl;
	cout<<"char: usado para almacenar 1 sola letra (1 byte)."<<endl;
    cout<<"bool: usado para almacenar valor de cierto(1) o falso(0) (1 byte)."<<endl;
    cout<<"double: numeros con decimales con 15 decimales de presición (8 bytes)."<<endl<<endl;
	cout<<"ALCANCE DE VARIABLES"<<endl;
    cout <<"-------------------------------------" << endl;
    cout<<"Local: declarado dentro de una función o bloque donde solamente pueden ser accesados por estos."<<endl;
    cout<<"Globales: declarado fuera de las funciones, pueden ser accesados en cualquier parte del programa."<<endl<<endl;    
    cout<< "NAMESPACE"<<endl;
    cout <<"-------------------------------------" << endl;
    cout<< "Región o bloque que proporciona un alcance a los identificadores es decir nombre de tipos, funciones, variables entre otros dentro de el."<<endl;
    cout<< "También es utilizado para organizar código en grupos lógicos para prevenir la colisión de nombres."<<endl<<endl;
    cout<<"NAMESPACE SINTAXIS"<<endl;
    cout <<"-------------------------------------" << endl;
    cout<<"namespace nombreDelNamespace// Codigo"<<endl;
    cout<<"En esta sintaxis estamos viendo que estamos creando un namespace con el nombre de"<<endl;
    cout<<"“nombreDelNamespace”, gracias a esto todo el código que ponemos a continuación dentro de esta"<<endl<<endl;
    cout<<"	EJEMPLO"<<endl;
    cout<<"-------------------------------------" << endl;
    cout<<"namespace saludo1 {"<<endl;
	cout<<"void mensaje() "<<endl;
	cout<<"std::cout << Hola mundo\n;}}";
	cout<<"void mensaje() {"<<endl;
	cout<<"std::cout << Adios mundo\n;}"<<endl<<endl;
    cout<<endl<<"¿Que deseas hacer?"<<endl;
    cout<<"1) Menú"<<endl;
    cin>>  respuesta;

    if(respuesta==1)
        menu();
    system ("pause");

    return(2);
}

dos(){
    int opcion,op,op2;
    setlocale(LC_CTYPE, "Spanish");
    system("cls");

    cout<<"ESTRUCTURA SELECTIVA O CONDICIONAL"<<endl<<endl;
    cout <<"-------------------------------------" << endl;
    cout<< "Son sentencias de programación que nos permiten elegir entre dos a más opciones o caminos."<<endl;
    cout<< "La elección se hace mediante la evaluación de un criterio."<<endl;
    cout<< "La sentencia solo se ejecuta si se cumple la condición."<<endl<<endl;
    cout<<endl<<"¿Qué deseas saber en específico?"<<endl;
    cout<<"1)Simple"<<endl;
    cout<<"2)Compuesta"<<endl;
    cout<<"3)Múltiple"<<endl;
    cin>>op;
    system ("cls");

    if (op==1){
setlocale(LC_CTYPE, "Spanish");
        cout<<"ESTRUCTURA SIMPLE"<<endl<<endl;
        cout <<"-------------------------------------" << endl;
        cout<<"El concepto de la estructura de control selectiva simple if (si) evaluará una"<<endl;
        cout<<"expresión lógica, y en caso de que sea verdadero se realizará las instrucciones"<<endl;
        cout<<"dentro de su bloque de instrucciones"<<endl<<endl;
        cout<<"¿Deseas ver un ejemplo?"<<endl;
        cout<<"1)Si"<<endl;
        cout<<"2)No"<<endl;
        cin>>op2;
    if (op2==1)
            cout<<"EJEMPLO SIMPLE"<<endl<<endl;
            cout <<"-------------------------------------" << endl;
            cout<<"     #include <iostream>//uso de librerias"<<endl<<endl;
            cout<<"     using namespace std;//uso de memoria"<<endl<<endl;
            cout<<"     int main()//inicio del programa"<<endl<<endl;
            cout<<"     int numero;//definición de variable"<<endl<<endl;
            cout<<"     cout<<ingresa un numero"<<endl<<endl;
            cout<<"     cin>>numero;//uso de variable"<<endl<<endl;
            cout<<"     if(numero%2==0){"<<endl<<endl;
            cout<<"     cout<<es un numero par} //imprime el resultado"<<endl<<endl;
            cout<<"     else{"<<endl<<endl;
            cout<<"     cout<<es un numero impar} //imprime resultado"<<endl<<endl;
            cout<<"     return (0)"<<endl<<endl;
        }
    if (op==2){
        setlocale(LC_CTYPE, "Spanish");
        cout<<"ESTRUCTURA COMPUESTA (SWITCH)"<<endl;
        cout <<"-------------------------------------" << endl;
        cout<<"// En C++, una estructura es igual que una clase salvo que sus miembros son públicos de forma predeterminada"<<endl;
        cout<<"¿Deseas ver un ejemplo?"<<endl;
        cout<<"1)Si"<<endl;
        cout<<"2)No"<<endl;
        cin>>op2;
    if (op2==1)
        setlocale(LC_CTYPE, "Spanish");
        system ("cls");
        cout<<"EJEMPLO"<<endl;
        cout <<"-------------------------------------" << endl;
        cout<<"#include <iostream>//uso de librerias"<<endl;
        cout<<"using namespace std;//uso de memoria"<<endl;
        cout<<"int main()//inicio de programa "<<endl;
        cout<<"int opcion = 2;// Declaración e inicialización de una variable"<<endl;
        cout<<"switch (opcion)// Estructura selectiva múltiple usando switch"<<endl;
        cout<<"  case 1:"<<endl;
        cout<<"cout << ""Seleccionaste la opción 1" "//caso 1 """<<endl;
        cout<<" break;"<<endl;
        cout<<" case 2:// caso 2"<<endl;
        cout<<"cout <<""Seleccionaste la opción 2"""<<endl;
        cout<<"break;"<<endl;
        cout<<"case 3//caso 3"<<endl;
        cout<<"cout << ""Seleccionaste la opción 3"<<endl;
        cout<<"break; //romper el ciclo"<<endl;
        cout<<"default:"<<endl;
        cout<<"cout<<Opción no válida"<<endl;
        cout<<"break;"<<endl;
        cout<<"return 0"<<endl;
}
    if (op==3){
        setlocale(LC_CTYPE, "Spanish");
        cout<<"ESTRUCTURA MÚLTIPLE (SWITCH)"<<endl;
        cout <<"-------------------------------------" << endl;
        cout<<"Las estructuras selectivas múltiples permiten escoger uno de varios caminos posibles"<<endl;
        cout<<"Para la estructura condicional múltiple se proponen las palabras clave Seleccionar-caso en pseudocódigo"<<endl;
        cout<<"misma que se implementa en lenguaje C utilizando las palabras reservadas switch-case"<<endl<<endl;
        cout<<"¿Deseas ver un ejemplo?"<<endl;
        cout<<"1)Si"<<endl;
        cout<<"2)No"<<endl;
        cin>>op2;
   if (op2==1)
            system ("cls");
            cout<<"EJEMPLO"<<endl;
            cout <<"-------------------------------------" << endl;
            cout<<"#include <iostream>//uso de librerias"<<endl;
            cout<<"using namespace std;//uso de memoria"<<endl;
            cout<<"int main()//inicio de programa "<<endl;
            cout<<"int opcion = 2;// Declaración e inicialización de una variable"<<endl;
            cout<<"switch (opcion)// Estructura selectiva múltiple usando switch"<<endl;
            cout<<"  case 1:"<<endl;
            cout<<"cout << ""Seleccionaste la opción 1" "//caso 1 """<<endl;
            cout<<" break;"<<endl;
            cout<<" case 2:// caso 2"<<endl;
            cout<<"cout <<""Seleccionaste la opción 2"""<<endl;
            cout<<"break;"<<endl;
            cout<<"case 3//caso 3"<<endl;
            cout<<"cout<<Seleccionaste la opción 3"<<endl;
            cout<<"break; //romper el ciclo"<<endl;
            cout<<"default:"<<endl;
            cout<<"cout<<Opción no válida"<<endl;
            cout<<"break;"<<endl;
            cout<<"return 0"<<endl;
            }
    setlocale(LC_CTYPE, "Spanish");
    cout<<endl<<"¿Qué deseas hacer?"<<endl;
    cout<<"1) Menú"<<endl;
    cout<<"2) Salir"<<endl;
    cin>>  opcion;

    if(opcion==1)
        menu();
    if(opcion==2)
        exit(0);
system ("pause");
return(3);
}

tres()
{
    int opcion,op,op2;
    setlocale(LC_CTYPE, "Spanish");
    system("cls");

    cout<<"ESTRUCTURA CICLÍCA O INTERACTIVA (BUCLES)"<<endl<<endl;
    cout <<"-------------------------------------" << endl;
    cout<<"Un ciclo o bucle permite repetir una o varias instrucciones cuantas veces lo necesitemos"<<endl;
    cout<<"¿Sobre que deseas saber en específico?"<<endl;
    cout<<"1)Ciclo While"<<endl;
    cout<<"2)Ciclo Do While"<<endl;
    cout<<"3)Ciclo For"<<endl;
    cin>>op;
    system ("cls");
    if (op==1){
        setlocale(LC_CTYPE, "Spanish");
        cout<<"CICLO WHILE"<<endl;
        cout <<"-------------------------------------" << endl;
        cout<<"El bucle while se utiliza para repetir un bloque de código mientras una condición sea verdadera."<<endl;
        cout<<"Su ejecución depende del valor de verdad de una condición dada, verdadera o falso, nada más."<<endl;
        cout<<"De este modo los ciclos while, son mucho mßs efectivos para condiciones indeterminadas"<<endl<<endl;
        cout<<"¿Deseas ver un ejemplo?"<<endl;
        cout<<"1)Si"<<endl;
        cout<<"2)No"<<endl;
        cin>>op2;
    if (op2==1)
         setlocale(LC_CTYPE, "Spanish");
         system ("cls");
        cout<<"EJEMPLO"<<endl<<endl;
        cout <<"-------------------------------------" << endl;
        cout<<"Queremos hacer que nuestro programa le pida a un usuario una serie de números cualquiera y que"<<endl;
        cout<<"solo dejaremos de hacerlo cuando el usuario ingrese un número mayor a 100."<<endl<<endl;
        cout<<"SOLUCIÓN: Para solucionar esto, debemos tener clara cuál va a ser la condición que se debe cumplir para que"<<endl;
        cout<<"el ciclo este pidiendo el numero contantemente, el ciclo se va a detener solo cuando el numero ingresado sea mayor que"<<endl;
        cout<<"100 así que la condición para que se siga ejecutando es que el numero sea menor a 100,"<<endl<<endl;
        cout<<"int numero;"<<endl<<"cin >> numero;"<<endl<<"while(numero <= 100)"<<endl<<"{"<<endl<<"cout <<  Ingrese un numero ;"<<endl<<"cin >> numero;}"<<endl;
        system("pause");
            }
    if (op==2){
         setlocale(LC_CTYPE, "Spanish");
        cout<<"CICLO DO WHILE"<<endl;
        cout << "----------------" << endl;
        cout << "El bucle do-while es similar al bucle while, pero garantiza que el bloque de código se ejecute al menos"<<endl;
        cout<<"una vez antes de verificar la condición." << endl<<endl;
        cout<<"¿Deseas ver un ejemplo?"<<endl;
        cout<<"1)Si"<<endl;
        cout<<"2)No"<<endl;
        cin>>op2;
    if (op2==1)
        setlocale(LC_CTYPE, "Spanish");
            system ("cls");
            cout<<"EJEMPLO"<<endl<<endl;
            cout <<"-------------------------------------" << endl;
            cout<<"Queremos hacer que nuestro programa le pida a un usuario una serie de números cualquiera y que solo"<<endl;
            cout<<"dejaremos de hacerlo cuando el usuario ingrese un número mayor a 100"<<endl<<endl;
            cout<<"SOLUCIÓN: Para solucionar esto, debemos tener clara cuál va a ser la condición que se debe cumplir para que"<<endl;
            cout<<"el ciclo este pidiendo el numero constantemente. El ciclo se va a detener solo cuando el numero ingresado sea"<<endl;
            cout<<"mayor que 100, así que la condición para que se siga ejecutando es que el numero sea menor a 100"<<endl<<endl;
            cout<<"int numero;"<<endl<<"do"<<endl<<"{"<<endl<<"cout <<  Ingrese un numero ;"<<endl<<"cin >> numero;"<<endl<<"}"<<endl<<"while(numero <= 100);"<<endl<<endl;
            system("pause");
            }
    if (op==3){
        setlocale(LC_CTYPE, "Spanish");
        cout<<"CICLO FOR"<<endl;
        cout <<"-------------------------------------" << endl;
        cout << "El bucle for se utiliza para repetir un bloque de código un número específico de veces." << endl<<endl;
        cout<<"¿Deseas ver un ejemplo?"<<endl;
        cout<<"1)Si"<<endl;
        cout<<"2)No"<<endl;
        cin>>op2;
	if (op2==1)
            setlocale(LC_CTYPE, "Spanish");
            system ("cls");
            cout<<"EJEMPLO"<<endl;
            cout <<"-------------------------------------" << endl;
            cout<<"Deseamos sacar los números pares entre el numero 50 y el 100"<<endl<<endl;
            cout<<"SOLUCIÓN: Tenemos entonces que el valor inicial para nuestro ciclo es el numero 50 y el valor final es el 100,"<<endl;
            cout<<"además, dado que necesitamos los números pares vamos a ir de dos en dos, así que el tamaño del paso va a ser 2,"<<endl;
            cout<<"teniendo estos 3 componentes identificados, estamos listos para crear nuestro ciclo for así"<<endl<<endl;
            cout<<"for(int i=50;i<=100;i+=2)"<<endl<<"{//Notemos que escribir i+=2 es similar a escribir i = i + 2"<<endl<<"cout << i << endl;}"<<endl<<endl;
            system("pause");
            }
     setlocale(LC_CTYPE, "Spanish");
    cout<<endl<<"¿Qué deseas hacer?"<<endl;
    cout<<"1) Menú"<<endl;
    cout<<"2) Salir"<<endl;
    cin>>  opcion;

    if(opcion==1)
        menu();
    if(opcion==2)
        exit(0);
system ("pause");

return(4);
}

cuatro()
{
 int opcion,op,op2;

    setlocale(LC_CTYPE, "Spanish");
    system("cls");
    cout<<" ARREGLOS\n\n";
    cout <<"-----------------------------------------------------------------------------------------------------------------" << endl;
    cout<<" Podemos definir un arreglo (array) como un contenedor que almacena datos."<<endl;
    cout<<" Dichos datos tienen que ser del mismo tipo."<<endl;
    cout<<"¿Sobre que deseas saber en específico?"<<endl;
    cout<<"1)Arreglos de una dimensión"<<endl;
    cout<<"2)Areglos bidimensionales"<<endl;
    cin>>op;
    system ("cls");

    if (op==1){
         setlocale(LC_CTYPE, "Spanish");
        cout<<"  ARREGLOS DE UNA DIMENSIÓN\n\n";
        cout <<"-----------------------------------------------------------------------------------------------------------------" << endl;
        cout<<" Aqui tomamos el aspecto que tenemos X espacios/contenedores para almacenar informacion, como enteros, flotantes, dobles, etc "<<endl;
        cout<<" en aspecto de programacion, en aspecto real, podriamos decir que son contenedores enfocados a solamente libros.\n\n";
        cout<<endl<<"¿Deseas ver un ejemplo?"<<endl;
        cout<<"1)Si"<<endl;
        cout<<"2)No"<<endl;
        cin>>op2;
        if (op2==1)
        setlocale(LC_CTYPE, "Spanish");
            system ("cls");
            cout<<"EJEMPLO"<<endl;
            cout <<"-------------------------------------------------------------" << endl;
			cout <<"Utilizando un ciclo para inicializarlo, anexo ejemplo:" << endl;
            cout<<"#include <iostream> \n\n";
            cout<<"using namespace std; \n\n";
            cout<<"int main() \n";
            cout<<"{ \n";
            cout<<"     int miEnteros[5];";
            cout<<"     for (size_t index=0; index < 5; index++) { \n";
            cout<<"     miEnteros[index] = 0;}";
            cout<<"     retrun 0;}"<<endl<<endl;
            cout <<"Declarar cada valor inicial al declarar, anexo ejemplo:" << endl;
            cout<<"#include <iostream> \n\n";
            cout<<"using namespace std; \n\n";
            cout<<"int main() \n";
            cout<<"{ \n";
            cout<<"     int miEnteros[5] = {0, 0, 0, 0, 0};";
            cout<<"     retrun 0;}"<<endl<<endl;
            cout <<"Declarar cada valor inicial al declarar, anexo ejemplo:" << endl;
            cout<<"#include <iostream> \n\n";
            cout<<"using namespace std; \n\n";
            cout<<"int main() \n";
            cout<<"{ \n";
            cout<<"     int miEnteros[5] = {0};";
            cout<<"     retrun 0;}"<<endl<<endl;
            
            }
    if (op==2){
        setlocale(LC_CTYPE, "Spanish");
        cout<<" ARREGLOS BIDIMENSIONALES";
        cout <<"-----------------------------------------------------------------------------------------------------------------" << endl;
        cout<<" Estructura de datos que almacena múltiples elementos, organizados en renglones y columnas. Se dice que son bidimensionales porque para acceder \n";
        cout<<" a una posición de una matriz se requieren de dos índices, el índice de la fila y el índice de la columna  \n";
        cout<<" Para crear una matriz en JAVA se utiliza el tipo y corchetes cuadrados dobles \n";
        cout<<"¿Deseas ver un ejemplo?"<<endl;
        cout<<"1)Si"<<endl;
        cout<<"2)No"<<endl;
        cin>>op2;
        if (op2==1)
        setlocale(LC_CTYPE, "Spanish");
        system ("cls");
        cout<<"EJEMPLO"<<endl;
        cout <<"-----------------------------------------------------------------------------------------------------------------" << endl;
        cout<<"#include <iostream> \n";
        cout<<"#include <cstring> \n\n";
        cout<<"using namespace std; \n\n";
        cout<<"main () \n";
        cout<<"{ \n";
        cout<<"     const int filas = 3; \n\n";
        cout<<"     const int columnas = 4"<<endl;
        cout<<"     {5, 6, 7, 8},\n";
        cout<<"     {9, 10, 11, 12}};\n";
        cout<<"     for (int i = 0; i < filas; i++) { \n";
        cout<<"     for (int j = 0; j < columnas; j++) { \n";
        cout<<"     cout << matriz[i][j] << " ";}\n";
        cout<<"return (0); \n";
        cout<<"} \n";
            }

setlocale(LC_CTYPE, "Spanish");

    cout<<endl<<"¿Qué deseas hacer?"<<endl;
    cout<<"1) Menú"<<endl;
    cout<<"2) Salir"<<endl;
    cin>>  opcion;

    if(opcion==1)
        menu();
    if(opcion==2)
        exit(0);
system ("pause");

return(4);
}
