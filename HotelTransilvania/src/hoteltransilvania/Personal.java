/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package hoteltransilvania;
import java.io.*;
import java.util.*;

/**
 *
 * @author Katia
 */
public class Personal {

    static ArrayList<Empleado> lista = new ArrayList<>();
    static Scanner sc = new Scanner(System.in);
    private static String archivo = "personal.txt";
    
    public Personal() {
        cargar();
    }

    // 2. Método para GUARDAR en el archivo
    public static void guardar() {
        try (PrintWriter pw = new PrintWriter(new FileWriter(archivo))) {
            for (Empleado e : lista) {
                // Escribimos los datos separados por tabuladores (\t)
                pw.println(e.clave() + "\t" + e.nombre + "\t" + e.apP + "\t" + e.apM + "\t" + e.tipo + "\t"
                        + e.anioNac + "\t" + e.mesNac + "\t" + e.diaNac + "\t"
                        + e.antiguedad + "\t" + e.cargo + "\t" + e.rfc + "\t"
                        + e.vacs + "\t" + e.salario + "\t");
            }
        } catch (IOException ex) {
            System.out.println("Error al guardar en el archivo de personal.");
        }
    }
    public static void cargar() {
        lista.clear();
        try (BufferedReader br = new BufferedReader(new FileReader(archivo))) {
            String linea;
            while ((linea = br.readLine()) != null) {
                String[] d = linea.split("\t");
                // Reconstruimos el objeto Empleado con los datos del archivo
                String clave = d[0];
                String nombre = d[1];
                String apP = d[2];
                String apM = d[3];
                String tipo = d[4];
                int anioNac = Integer.parseInt(d[5]);
                int mesNac = Integer.parseInt(d[6]);
                int diaNac = Integer.parseInt(d[7]);
                int antiguedad = Integer.parseInt(d[8]);
                String cargo = d[9];
                String rfc = d[10];
                int vacs = Integer.parseInt(d[11]);
                int salario = Integer.parseInt(d[12]);

                // 3. Creamos el objeto con el constructor largo
                Empleado e = new Empleado(nombre, apP, apM, tipo, anioNac, 
                                        mesNac, diaNac, antiguedad, cargo, 
                                        rfc, vacs, salario);
                lista.add(e);
            }
        } catch (IOException ex) {
            System.out.println("Archivo no encontrado");
        }
    }
    public void menu(){

        int opc;
        do{
            System.out.println("\n----- PERSONAL -----");
            System.out.println("1 Registrar empleado");
            System.out.println("2 Buscar empleado");
            System.out.println("3 Modificar empleado");
            System.out.println("4 Eliminar empleado");
            System.out.println("5 Mostrar empleados");
            System.out.println("6 Salir");

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
            }
        }while(opc!=6);
    }

    public static void registrar(){
        int opc, mesNac, diaNac, anioNac, salario=0, vacaciones, antiguedad;
        String nombre="", apP="", apM="", mesNacS="", cargo="", rfc="", tipo="";
        
        Scanner sc = new Scanner(System.in);
        System.out.println("Datos del empleado");
        
        //Nombre
        System.out.print("Nombre de pila: ");
        nombre = sc.nextLine();
        
        //Apellido Paterno
        System.out.print("Apellido Paterno: ");
        apP = sc.nextLine();
        
        //Apellido Materno
        System.out.print("Apellido Materno: ");
        apM = sc.nextLine();
        
        //Mes de nacimiento
        System.out.print("Mes de nacimiento en numero (Ej. 1, 2, ..., 12): ");
        mesNac = sc.nextInt();
        while (mesNac > 12 || mesNac < 1){
            System.out.println("Dato invalido, ingresa de nuevo un valor");
            System.out.print("Mes de nacimiento en numero (Ej. 1, 2, ..., 12): ");
            mesNac = sc.nextInt();
        }
        switch (mesNac){
            case 1:
                mesNacS = "Enero";
                break;
            case 2:
                mesNacS = "Febrero";
                break;
            case 3:
                mesNacS = "Marzo";
                break;
            case 4:
                mesNacS = "Abril";
                break;
            case 5:
                mesNacS = "Mayo";
                break;
            case 6:
                mesNacS = "Junio";
                break;
            case 7:
                mesNacS = "Julio";
                break;
            case 8:
                mesNacS = "Agosto";
                break;
            case 9:
                mesNacS = "Septiembre";
                break;
            case 10:
                mesNacS = "Octubre";
                break;
            case 11:
                mesNacS = "Noviembre";
                break;
            case 12:
                mesNacS = "Diciembre";
                break;
        }

        //Día de nacimiento
        System.out.print("Dia de nacimiento en numero (Ej. 1, 2, ...): ");
        diaNac = sc.nextInt();
        switch(mesNac){
            //Meses con 31 días
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                while (diaNac > 31 || diaNac < 1){
                    System.out.println("Dato invalido, "+mesNacS+" solo tiene 31 días, ingresa de nuevo un valor");
                    System.out.print("Dia de nacimiento en numero (Ej. 1, 2, ..., 31): ");
                    diaNac = sc.nextInt();
                }
                break;
            //Meses con 30 días
            case 4:
            case 6:
            case 9:
            case 11:
                while (diaNac > 30 || diaNac < 1){
                    System.out.println("Dato invalido, "+mesNacS+" solo tiene 30 días, ingresa de nuevo un valor");
                    System.out.print("Dia de nacimiento en numero (Ej. 1, 2, ..., 30): ");
                    diaNac = sc.nextInt();
                }
                break;
            //Meses con 28 días
            case 2:
                while (diaNac > 28 || diaNac < 1){
                    System.out.println("Dato invalido, "+mesNacS+" solo tiene 28 días, ingresa de nuevo un valor");
                    System.out.print("Dia de nacimiento en numero (Ej. 1, 2, ..., 28): ");
                    diaNac = sc.nextInt();
                }
                break;
        }   
        
        //Año de nacimiento
        System.out.print("Anio de nacimiento en numero: ");
        anioNac = sc.nextInt();
        
        //Tipo Monstruo
        System.out.println("Tipo de monstruo");
        System.out.println("1. Zombie");
        System.out.println("2. Bruja");
        opc = sc.nextInt();
        while (opc > 2 || opc < 1){
            System.out.println("Dato incorrecto, ingresa de nuevo un valor");
            System.out.println("1. Zombie");
            System.out.println("2. Bruja");
            opc = sc.nextInt();
        }
        if (opc == 1){
            tipo = "Zombie";
        } else if(opc == 2){
            tipo = "Bruja";
        }
        
        //Antigüedad
        System.out.print("Anios de antiguedad en numero: ");
        antiguedad = sc.nextInt();
        while (antiguedad < 0){
            System.out.println("Dato incorrecto, ingresa de nuevo un valor");
            System.out.print("Anios de antiguedad en numero: ");
            antiguedad = sc.nextInt();
        }
        
        //Vacaciones
        if (antiguedad < 16){
            vacaciones = 90;
        } else if (antiguedad >= 16 && antiguedad < 31){
            vacaciones = 180;
        } else if (antiguedad >= 31 && antiguedad < 46){
            vacaciones = 270;
        } else {
            vacaciones = 365;
        }
        
        //Cargo y salario
        System.out.println("Cargo del empleado");
        System.out.println("1. Gerente del Hotel");
        System.out.println("Recepcion y Atencion al Huesped");
        System.out.println("2. Recepcionista");
        System.out.println("3. Conserje");
        System.out.println("4. Botones");
        System.out.println("5. Operador de PBX");
        System.out.println("Limpieza y Pisos");
        System.out.println("6. Camarista");
        System.out.println("7. Mozo de areas publicas");
        System.out.println("8. Lavandero");
        System.out.println("Alimentos y Bebidas");
        System.out.println("9. Chef ejecutivo");
        System.out.println("10. Cocinero");
        System.out.println("11. Mesero");
        System.out.println("12. Bartender");
        System.out.println("Mantenimiento");
        System.out.println("13. Tecnico de mantenimiento");
        System.out.println("14. Jardinero");
        System.out.println("15. Piscinero");
        System.out.println("Seguridad (Guardia de seguridad)");
        System.out.println("16. Guardia de seguridad");
        System.out.println("Ventas y Marketing (Director de ventas)");
        System.out.println("17. Director de ventas");
        opc = sc.nextInt();
        while (opc > 17 || opc < 1){
            System.out.println("Dato incorrecto, ingresa de nuevo un valor");
            System.out.println("1. Gerente del Hotel");
            System.out.println("Recepcion y Atencion al Huesped");
            System.out.println("2. Recepcionista");
            System.out.println("3. Conserje");
            System.out.println("4. Botones");
            System.out.println("5. Operador de PBX");
            System.out.println("Limpieza y Pisos");
            System.out.println("6. Camarista");
            System.out.println("7. Mozo de areas publicas");
            System.out.println("8. Lavandero");
            System.out.println("Alimentos y Bebidas");
            System.out.println("9. Chef ejecutivo");
            System.out.println("10. Cocinero");
            System.out.println("11. Mesero");
            System.out.println("12. Bartender");
            System.out.println("Mantenimiento");
            System.out.println("13. Tecnico de mantenimiento");
            System.out.println("14. Jardinero");
            System.out.println("15. Piscinero");
            System.out.println("Seguridad (Guardia de seguridad)");
            System.out.println("16. Guardia de seguridad");
            System.out.println("Ventas y Marketing (Director de ventas)");
            System.out.println("17. Director de ventas");
            opc = sc.nextInt();
        }
        switch(opc){
            case 1:
                cargo = "Gerente del Hotel";
                salario = 35000;
            break;
            case 2:
                cargo = "Recepcionista";
                salario = 10000;
            break;
            case 3:
                cargo = "Conserje";
                salario = 10000;
            break;
            case 4:
                cargo = "Botones";
                salario = 10000;
            break;
            case 5:
                cargo = "Operador de PBX";
                salario = 10000;
            break;
            case 6:
                cargo = "Camarista";
                salario = 8000;
            break;
            case 7:
                cargo = "Mozo de areas publicas";
                salario = 8000;
            break;
            case 8:
                cargo = "Lavandero";
                salario = 8000;
            break;
            case 9:
                cargo = "Chef ejecutivo";
                salario = 15000;
            break;
            case 10:
                cargo = "Cocinero";
                salario = 15000;
            break;
            case 11:
                cargo = "Mesero";
                salario = 15000;
            break;
            case 12:
                cargo = "Bartender";
                salario = 15000;
            break;
            case 13:
                cargo = "Tecnico de mantenimiento";
                salario = 10000;
            break;
            case 14:
                cargo = "Jardinero";
                salario = 10000;
            break;
            case 15:
                cargo = "Piscinero";
                salario = 10000;
            break;
            case 16:
                cargo = "Guardia de seguridad";
                salario = 10000;
            break;
            case 17:
                cargo = "Director de ventas";
                salario = 30000;
            break;
        }

        //RFC
        String anio, mes, dia, clave;
        char[] homoclave = new char[3];
        String caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        Random random = new Random();
        
        char nom = Character.toUpperCase(nombre.charAt(0));
        String paterno = (apP.substring(0, 2)).toUpperCase();
        char materno = Character.toUpperCase(apM.charAt(0));
        anio = String.valueOf(anioNac);
        
        if (mesNac < 10){
            mes = "0" + String.valueOf(mesNac);
        }else{
            mes = String.valueOf(mesNac);
        }
        if (diaNac < 10){
            dia = "0" + String.valueOf(diaNac);
        }else{
            dia = String.valueOf(diaNac);
        }
        
        for (int i = 0; i < homoclave.length; i++) {
            int pos = random.nextInt(caracteres.length());
            homoclave[i] = caracteres.charAt(pos);
        }
        clave = String.valueOf(homoclave);
        rfc = paterno+materno+nom+(anio).substring(2)+mes+dia+clave;        
               

        
        Empleado e = new Empleado(nombre,apP,apM,tipo,anioNac,mesNac,diaNac,antiguedad,cargo,rfc,vacaciones,salario);
        lista.add(e);

        guardar();
        
        System.out.println("Clave empleado: "+e.clave());
    }

    public static void buscar(){

        System.out.println("Ingrese clave:");
        String clave = sc.nextLine();

        for(Empleado e: lista){

            if(e.clave().equalsIgnoreCase(clave)){
                System.out.println("Nombre: "+e.nombre+" "+e.apP+" "+e.apM);
                System.out.println("Cargo: "+e.cargo);
                System.out.println("Salario: "+e.salario);
                return;
            }
        }
        System.out.println("Empleado no encontrado");
    }

    public static void modificar() {
        System.out.println("Ingrese clave:");
        String clave = sc.nextLine();

        for (Empleado e : lista) {
            if (e.clave().equalsIgnoreCase(clave)) {
                System.out.println("Nuevo cargo:");
                e.cargo = sc.nextLine();
                System.out.println("Nuevos anios de antiguedad:");
                e.antiguedad = sc.nextInt();
                sc.nextLine(); // Limpiar buffer
                
                // Llamada a guardar después de modificar
                guardar(); 
                System.out.println("Datos actualizados.");
                return;
            }
        }
        System.out.println("Empleado no encontrado");
    }

    public static void eliminar() {
        System.out.println("Ingrese clave:");
        String clave = sc.nextLine();
        Iterator<Empleado> emp = lista.iterator();

        while (emp.hasNext()) {
            Empleado e = emp.next();
            if (e.clave().equalsIgnoreCase(clave)) {
                emp.remove();
                // Llamada a guardar después de eliminar
                guardar(); 
                System.out.println("Empleado eliminado");
                return;
            }
        }
        System.out.println("Empleado no encontrado");
    }

    public static void mostrar(){
        if(lista.isEmpty()) {
            System.out.println("No hay empleados en la lista.");
            return;
        }
        // ..intf permanece igual) ...
        System.out.printf("%-15s %-15s %-15s %-15s %-15s %-15s %-15s %-30s %-15s %-15s %-15s\n",
                    "Clave", "Nombre", "A. Paterno", "A. Materno", "Dia", "Mes", "Anio", "Cargo", "Salario", "Vacaciones", "RFC");
        System.out.println("---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------");
        for(Empleado e: lista){
            System.out.printf("%-15s %-15s %-15s %-15s %-15d %-15d %-15d %-30s %-15d %-15d %-15s%n",
                    e.clave(),e.nombre,e.apP,e.apM,e.diaNac,e.mesNac,e.anioNac,e.cargo,e.salario,e.vacs,e.rfc);
        }
    }
}