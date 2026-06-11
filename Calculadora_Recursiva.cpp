#include <iostream>
using namespace std;

void calculadora() {
    double num1, num2, res;
    char op, continuar;

    cout << "Ingresa el primer número: ";
    cin >> num1;
    cout << "Ingresa el segundo número: ";
    cin >> num2;
    cout << "Elige una operación (+, -, *, /): ";
    cin >> op;

    if (op == '+') {
        res = num1 + num2;
        cout << "Resultado: " << res<< endl;
    }
    if (op == '-') {
        res = num1 - num2;
        cout << "Resultado: " << res << endl;
    }
    if (op == '*') {
        res = num1 * num2;
        cout << "Resultado: " << res << endl;
    }
    if (op == '/') {
        if (num2 != 0) {
            res = num1 / num2;
            cout << "Resultado: " << res << endl;
        } else {
            cout << "Error: División entre cero no permitida." << endl;
        }
    }
    cout << "¿Quieres hacer otra operación? (s/n): ";
    cin >> continuar;

    if (true) {
        calculadora();
    }
}

int main() {
    calculadora();
    return 0;
}
