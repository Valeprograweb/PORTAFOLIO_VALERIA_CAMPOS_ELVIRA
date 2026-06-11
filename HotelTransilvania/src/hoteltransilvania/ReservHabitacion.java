/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package hoteltransilvania;

import java.util.*;
import java.io.*;
import java.time.LocalDate;
import java.time.temporal.ChronoUnit;

public class ReservHabitacion extends Huesped {

    private String numR;
    private String fechaE;
    private String fechaS;
    private int numP;
    private double precioN;
    private double total;
    private String tipoHab;
    private String tipoPago;

    static ArrayList<ReservHabitacion> reservaciones = new ArrayList<>();
    static Scanner sc = new Scanner(System.in);
    private static String archivo = "reservaciones.txt";

    static int i = 1;
    static String habitaciones[] = {"Individual","Doble","Suite"};
    static double precioI = 500;
    static double precioD = 800;
    static double precioS = 1200;

    public ReservHabitacion(String nombre,String apP,String apM,String tipo,int anioNac,int mesNac,
            int diaNac,String tel,String naci,String correo,String tipoHab,String numR,String fechaE,
            String fechaS,int numP,double precioN,String tipoPago) {

        super(nombre,apP,apM,tipo,anioNac,mesNac,diaNac,tel,naci,correo);

        this.tipoHab = tipoHab;
        this.numR = numR;
        this.fechaE = fechaE;
        this.fechaS = fechaS;
        this.numP = numP;
        this.precioN = precioN;
        this.tipoPago = tipoPago;

        long dias = ChronoUnit.DAYS.between(LocalDate.parse(fechaE), LocalDate.parse(fechaS));
        this.total = dias * precioN;
    }

    public static String reservs(){
        String numero = "R" + String.format("%03d", i);
        i++;
        return numero;
    }

    public static void menu(){
        int opc;

        do{
            System.out.println("\n--- RESERVACIONES ---");
            System.out.println("1 Crear reservacion");
            System.out.println("2 Buscar reservacion");
            System.out.println("3 Cancelar reservacion");
            System.out.println("4 Mostrar reservaciones");
            System.out.println("5 Salir");

            opc = sc.nextInt();
            sc.nextLine();

            switch(opc){

                case 1:
                    crearR();
                break;

                case 2:
                    buscarR();
                break;

                case 3:
                    cancelarR();
                break;

                case 4:
                    mostrarR();
                break;
            }

        }while(opc!=5);
    }

    public static double Precios(String tipo){

        switch(tipo.toLowerCase()){

            case "individual":
                return precioI;
            case "doble":
                return precioD;
            case "suite":
                return precioS;
        }
        return 0;
    }

    public static void disponibles(LocalDate entrada, LocalDate salida){
        System.out.println("\nHabitaciones disponibles:");
        // Recorre cada tipo de habitación (Individual, Doble, Suite)
        for(String hab : habitaciones){
            // Suponemos que la habitación está disponible
            boolean disponible = true;
            // Recorre todas las reservaciones existentes
            for(ReservHabitacion r : reservaciones){
                // Verifica si la reservación es del mismo tipo de habitación
                if(r.tipoHab.equalsIgnoreCase(hab)){
                    // Convierte las fechas guardadas en texto a tipo LocalDate
                    LocalDate e = LocalDate.parse(r.fechaE);
                    LocalDate s = LocalDate.parse(r.fechaS);
                    // Verifica si las fechas se cruzan con otra reservación
                    boolean traslape = !(salida.isBefore(e) || entrada.isAfter(s));
                    // Si hay traslape significa que la habitación está ocupada
                    if(traslape){
                        disponible = false; // ya no está disponible
                        break; // sale del ciclo
                    }
                }
            }
            // Si después de revisar todas las reservaciones sigue disponible
            if(disponible){
                // se muestra la habitación disponible
                System.out.println(hab);
            }
        }
    }

    public static void crearR(){

        System.out.println("Ingrese clave del huesped:");
        String clave = sc.nextLine();

        Huesped hEncontrado = null;

        for(Huesped h : Huesped.huespedes){
            if(h.clave().equalsIgnoreCase(clave)){
                hEncontrado = h;
                break;
            }
        }
        if(hEncontrado == null){
            System.out.println("Huesped no encontrado");
            return;
        }

        System.out.println("Fecha entrada (AAAA-MM-DD):");
        LocalDate entrada = LocalDate.parse(sc.nextLine());
        System.out.println("Fecha salida (AAAA-MM-DD):");
        LocalDate salida = LocalDate.parse(sc.nextLine());

        if(salida.isBefore(entrada)){
            System.out.println("Fecha de salida invalida");
            return;
        }
        disponibles(entrada, salida);

        System.out.println("Seleccione tipo de habitacion:");
        String hab = sc.nextLine();
        
        double precio = Precios(hab);
        long dias = ChronoUnit.DAYS.between(entrada, salida);
        double total = dias * precio;
        String num = reservs();

        System.out.println("Tipo de pago:");
        System.out.println("1.- Efectivo");
        System.out.println("2.- Tarjeta");
        System.out.println("3.- Transferencia");
        int opP = sc.nextInt();
        sc.nextLine();

        String tipoPago="";

        switch(opP){
            case 1:
                tipoPago="Efectivo";
            break;
            case 2:
                tipoPago="Tarjeta";
            break;
            case 3:
                tipoPago="Transferencia";
            break;
        }

        ReservHabitacion r = new ReservHabitacion(
                hEncontrado.nombre,hEncontrado.apP,hEncontrado.apM,
                hEncontrado.tipo,hEncontrado.anioNac,hEncontrado.mesNac,
                hEncontrado.diaNac,hEncontrado.tel,hEncontrado.naci,
                hEncontrado.correo,hab,num,entrada.toString(),
                salida.toString(),1,precio,tipoPago
        );

        reservaciones.add(r);
        guardarR();

        System.out.println("Reservacion creada");
        System.out.println("Numero de reservacion: " + num);
        System.out.println("Dias: "+dias);
        System.out.println("Total: "+total);
    }

    public static void buscarR(){

        System.out.println("Numero reservacion:");
        String num = sc.nextLine();

        for(ReservHabitacion r : reservaciones){
            if(r.numR.equalsIgnoreCase(num)){
                System.out.println("Reservacion encontrada");
                System.out.println("Huesped: "+r.nombre+" "+r.apP);
                System.out.println("Entrada: "+r.fechaE);
                System.out.println("Salida: "+r.fechaS);
                System.out.println("Tipo pago: "+r.tipoPago);
                System.out.println("Total: "+r.total);
                return;
            }
        }
        System.out.println("No encontrada");
    }

    public static void cancelarR(){

        System.out.println("Numero reservacion:");
        String num = sc.nextLine();

        Iterator<ReservHabitacion> it = reservaciones.iterator();

        while(it.hasNext()){
            ReservHabitacion r = it.next();
            if(r.numR.equalsIgnoreCase(num)){

                it.remove();
                guardarR();

                System.out.println("Reservacion cancelada");

                return;
            }
        }
        System.out.println("Reservacion no encontrada");
    }

    public static void mostrarR(){

        for(ReservHabitacion r : reservaciones){

            System.out.println("\nReservacion: "+r.numR);
            System.out.println("Huesped: "+r.nombre+" "+r.apP+" "+r.apM);
            System.out.println("Habitacion: "+r.tipoHab);
            System.out.println("Entrada: "+r.fechaE);
            System.out.println("Salida: "+r.fechaS);
            System.out.println("Tipo pago: "+r.tipoPago);
            System.out.println("Total: "+r.total);
            System.out.println("-----------------------");
        }
    }

    public static void guardarR(){

        try(PrintWriter pw = new PrintWriter(new FileWriter(archivo))){

            for(ReservHabitacion r : reservaciones){

                pw.println(
                        r.nombre+"\t"+r.apP+"\t"+r.apM+"\t"+r.tipo+"\t"+r.anioNac+"\t"+r.mesNac+"\t"+
                        r.diaNac+"\t"+r.tel+"\t"+r.naci+"\t"+r.correo+"\t"+r.tipoHab+"\t"+r.numR+"\t"+
                        r.fechaE+"\t"+r.fechaS+"\t"+r.numP+"\t"+r.precioN+"\t"+r.total+"\t"+r.tipoPago
                );
            }
        }catch(IOException e){
            System.out.println("Error al guardar");
        }
    }

    public static void cargarR(){

        reservaciones.clear();

        try(BufferedReader br = new BufferedReader(new FileReader(archivo))){

            String linea;

            while((linea = br.readLine()) != null){

                String d[] = linea.split("\t");

                ReservHabitacion r = new ReservHabitacion(
                        d[0],d[1],d[2],d[3],Integer.parseInt(d[4]),
                        Integer.parseInt(d[5]),Integer.parseInt(d[6]),
                        d[7],d[8],d[9],d[10],d[11],d[12],d[13],
                        Integer.parseInt(d[14]),Double.parseDouble(d[15]),d[16]
                );
                reservaciones.add(r);
            }
            i = reservaciones.size() + 1;
        }catch(IOException e){
            System.out.println("No existe archivo");
        }
    }
}