/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Main.java to edit this template
 */
package hoteltransilvania;
import java.util.Scanner;
/**
 *
 * @author Valeria Campos Elvira
 */
public class HotelTransilvania {

    public static void main(String[] args) {

        Scanner entrada = new Scanner(System.in);
        int opc;
        
        Huesped.cargar();
        ReservHabitacion.cargarR();
        Personal Empleado = new Personal();

        do {
            System.out.println("\nH O T E L    T R A N S I L V A N I A");
            System.out.println("1. Registrar Huesped");
            System.out.println("2. Reservar Habitacion");
            System.out.println("3. Reservar Actividades");
            System.out.println("4. Personal");
            System.out.println("5. Salir");

            opc = entrada.nextInt();

            switch (opc) {
                case 1:
                    Huesped.menu();
                    break;
                case 2:
                    ReservHabitacion.menu();
                    break;
                case 3:
                    ReservActividades.mostrarMenu();
                    break;
                case 4:
                    Empleado.menu();
                    break;
            }
        } while (opc!= 5);
    } 
}
