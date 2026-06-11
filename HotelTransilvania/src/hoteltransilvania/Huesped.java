/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package hoteltransilvania;

import java.util.*;
import java.io.*;

public class Huesped extends Monstruo{

    protected String tel;
    protected String naci;
    protected String correo;

    static ArrayList<Huesped> huespedes = new ArrayList<>();
    static Scanner sc = new Scanner(System.in);
    private static String archivo = "huespedes.txt";

    public Huesped(String nombre,String apP,String apM,String tipo,
                   int anioNac,int mesNac,int diaNac,
                   String tel,String naci,String correo){

        super(nombre,apP,apM,tipo,anioNac,mesNac,diaNac);

        this.tel = tel;
        this.naci = naci;
        this.correo = correo;
    }

    public static void menu(){
        int opc;

        do{
            System.out.println("\n----- H U E S P E D E S -----");
            System.out.println("1. Registrar huesped");
            System.out.println("2. Buscar huesped por clave");
            System.out.println("3. Modificar huesped");
            System.out.println("4. Eliminar huesped");
            System.out.println("5. Mostrar todos los huespedes");
            System.out.println("6. Ordenar lista de huespedes");
            System.out.println("7. Salir");

            opc = sc.nextInt();
            sc.nextLine();

            switch(opc){

                case 1:
                    registrar();
                break;

                case 2:
                    buscar();
                break;

                case 3:
                    modificar();
                break;

                case 4:
                    eliminar();
                break;

                case 5:
                    mostrar();
                break;

                case 6:
                    ordenar();
                break;
            }

        }while(opc!=7);
    }

    public static void registrar(){

        System.out.println("Nombre:");
        String nombre = sc.nextLine();
        System.out.println("Apellido paterno:");
        String apP = sc.nextLine();
        System.out.println("Apellido materno:");
        String apM = sc.nextLine();
        System.out.println("Tipo:");
        String tipo = sc.nextLine();
        System.out.println("Anio de nacimiento:");
        int anio = sc.nextInt();
        System.out.println("Mes de nacimiento:");
        int mes = sc.nextInt();
        System.out.println("Dia de nacimiento:");
        int dia = sc.nextInt();
        sc.nextLine();
        System.out.println("Telefono:");
        String tel = sc.nextLine();
        System.out.println("Nacionalidad:");
        String nac = sc.nextLine();
        System.out.println("Correo");
        String correo = sc.nextLine();
        sc.nextLine();
        Huesped h = new Huesped(nombre,apP,apM,tipo,anio,mes,dia,tel,nac,correo);

        huespedes.add(h);

        guardar();

        System.out.println("Huesped registrado");
        System.out.println("Clave: "+h.clave());
    }

    public static void guardar(){

        try(PrintWriter pw = new PrintWriter(new FileWriter(archivo))){

            for(Huesped h : huespedes){
                pw.println( h.nombre + "\t" + h.apP + "\t" + h.apM + "\t" + h.tipo + "\t" +h.anioNac + "\t" + 
                h.mesNac + "\t" + h.diaNac + "\t" + h.tel + "\t" + h.naci + "\t" + h.correo + "\t"
                );
            }
        }catch(IOException e){
            System.out.println("Error al guardar archivo");
        }
    }

    public static void cargar(){

        huespedes.clear();

        try(BufferedReader br = new BufferedReader(new FileReader(archivo))){

            String linea;
            
            while((linea = br.readLine()) != null){

                String datos[] = linea.split("\t");

                String nombre = datos[0];
                String apP = datos[1];
                String apM = datos[2];
                String tipo = datos[3];
                int anio = Integer.parseInt(datos[4]);
                int mes = Integer.parseInt(datos[5]);
                int dia = Integer.parseInt(datos[6]);
                String tel = datos[7];
                String nac = datos[8];
                String correo = datos[9];

                Huesped h = new Huesped(nombre,apP,apM,tipo,anio,mes,dia,tel,nac,correo);

                huespedes.add(h);
            }
        }catch(IOException e){
            System.out.println("No existe el archivo");
        }
    }

    public static void buscar(){

        System.out.println("Ingrese clave:");
        String clave = sc.nextLine();

        for(Huesped h : huespedes){

            if(h.clave().equalsIgnoreCase(clave)){

                System.out.println("Huesped encontrado:");
                System.out.println("Nombre: "+h.nombre+" "+h.apP+" "+h.apM);
                System.out.println("Telefono: "+h.tel);
                System.out.println("Nacionalidad: "+h.naci);
                System.out.println("Dias estancia: "+h.correo);
                return;
            }
        }
        System.out.println("Huesped no encontrado");
    }

    public static void modificar(){

        System.out.println("Ingrese clave:");
        String clave = sc.nextLine();

        for(Huesped h : huespedes){

            if(h.clave().equalsIgnoreCase(clave)){

                System.out.println("Nuevo telefono:");
                h.tel = sc.nextLine();

                System.out.println("Nueva nacionalidad:");
                h.naci = sc.nextLine();

                System.out.println("Nuevo correo:");
                h.correo = sc.nextLine();
                sc.nextLine();

                guardar();

                System.out.println("Datos actualizados");
                return;
            }
        }
        System.out.println("Huesped no encontrado");
    }

    public static void eliminar(){

        System.out.println("Ingrese clave:");
        String clave = sc.nextLine();

        Iterator<Huesped> it = huespedes.iterator();

        while(it.hasNext()){

            Huesped h = it.next();

            if(h.clave().equalsIgnoreCase(clave)){

                it.remove();

                guardar();

                System.out.println("Huesped eliminado");
                return;
            }
        }
        System.out.println("Huesped no encontrado");
    }

    public static void mostrar(){

        if(huespedes.isEmpty()){
            System.out.println("No hay huespedes registrados");
            return;
        }

        System.out.println("\n----- LISTA DE HUESPEDES -----");

        for(Huesped h : huespedes){

            System.out.println("Clave: "+h.clave());
            System.out.println("Nombre: "+h.nombre+" "+h.apP+" "+h.apM);
            System.out.println("Tipo: "+h.tipo);
            System.out.println("Telefono: "+h.tel);
            System.out.println("Nacionalidad: "+h.naci);
            System.out.println("Correo: "+h.correo);
            System.out.println("------------------------------");
        }
    }

    public static void ordenar(){
        Collections.sort(huespedes, Comparator.comparing(h -> h.nombre));
        System.out.println("Lista ordenada por nombre");
    }
}