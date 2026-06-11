package hoteltransilvania;
import java.util.Scanner;

public class ReservActividades {
    private String tipoActividad;
    private String clasEdad;
    private int duracion;
    private int numInscritos;
    private String instructor;
    private String horaInicio;
    private String horaFin;

    public ReservActividades(String tipoActividad, String clasEdad, int duracion,
                             String instructor, String horaInicio, String horaFin) {
        this.tipoActividad = tipoActividad;
        this.clasEdad = clasEdad;
        this.duracion = duracion;
        this.numInscritos = 0;
        this.instructor = instructor;
        this.horaInicio = horaInicio;
        this.horaFin = horaFin;
    }

    // impresion de toda la info de cada actividad
    public void inscribir(int cantidad) { numInscritos += cantidad; }
    public void mostrarInfo() {
    System.out.println("\n--- Información de la actividad ---");
    System.out.println("Actividad: " + tipoActividad);
    System.out.println("Clasificación: " + clasEdad);
    System.out.println("Duración: " + duracion + " minutos");
    System.out.println("Instructor: " + instructor);
    System.out.println("Horario: " + horaInicio + " - " + horaFin);
    System.out.println("Inscritos: " + numInscritos);
}

    //dets
    public String getTipoActividad() { return tipoActividad; }
    public String getClasEdad() { return clasEdad; }
    public String getInstructor() { return instructor; }
    public String getHoraInicio() { return horaInicio; }
    public String getHoraFin() { return horaFin; }
    public int getNumInscritos() { return numInscritos; }


  //Arreglos para cada edad/actividades
public static ReservActividades[] infantiles = {         
    new ReservActividades("Pintura", "Infantiles", 30, "Mavis", "09:00", "09:30"),
    new ReservActividades("Cuentacuentos", "Infantiles", 40, "Frankie", "10:00", "10:40"),
    new ReservActividades("Teatro de títeres", "Infantiles", 45, "Murray", "11:00", "11:45"),
    new ReservActividades("Manualidades", "Infantiles", 50, "Mavis", "12:00", "12:50"),
    new ReservActividades("Juegos al aire libre", "Infantiles", 60, "Wayne", "13:00", "14:00"),
    new ReservActividades("Cine infantil", "Infantiles", 70, "Dennis", "14:30", "15:40"),
    new ReservActividades("Música y baile", "Infantiles", 40, "Ericka", "16:00", "16:40"),
    new ReservActividades("Cocina divertida", "Infantiles", 50, "Frankie", "17:00", "17:50"),
    new ReservActividades("Gymkana", "Infantiles", 60, "Mavis", "18:00", "19:00"),
    new ReservActividades("Lectura guiada", "Infantiles", 30, "Drácula", "19:30", "20:00")
};

public static ReservActividades[] preadolescentes = {
    new ReservActividades("Videojuegos", "Preadolescentes", 60, "Dennis", "09:00", "10:00"),
    new ReservActividades("Manualidades", "Preadolescentes", 45, "Mavis", "10:30", "11:15"),
    new ReservActividades("Cine juvenil", "Preadolescentes", 90, "Mavis", "11:30", "13:00"),
    new ReservActividades("Karaoke", "Preadolescentes", 60, "Dennis", "13:30", "14:30"),
    new ReservActividades("Deportes", "Preadolescentes", 90, "Wayne", "15:00", "16:30"),
    new ReservActividades("Cocina básica", "Preadolescentes", 60, "Frankie", "17:00", "18:00"),
    new ReservActividades("Baile moderno", "Preadolescentes", 60, "Ericka", "18:30", "19:30"),
    new ReservActividades("Fotografía", "Preadolescentes", 50, "Mavis", "20:00", "20:50"),
    new ReservActividades("Teatro", "Preadolescentes", 70, "Drácula", "21:00", "22:10"),
    new ReservActividades("Lectura grupal", "Preadolescentes", 40, "Mavis", "22:30", "23:10")
};

public static ReservActividades[] adolescentes = {
    new ReservActividades("Cine", "Adolescentes", 120, "Mavis", "09:00", "11:00"),
    new ReservActividades("Karaoke", "Adolescentes", 90, "Dennis", "11:30", "13:00"),
    new ReservActividades("Deportes extremos", "Adolescentes", 120, "Wayne", "13:30", "15:30"),
    new ReservActividades("Baile urbano", "Adolescentes", 90, "Ericka", "16:00", "17:30"),
    new ReservActividades("Fotografía avanzada", "Adolescentes", 60, "Mavis", "18:00", "19:00"),
    new ReservActividades("Teatro juvenil", "Adolescentes", 100, "Drácula", "19:30", "21:10"),
    new ReservActividades("Cocina internacional", "Adolescentes", 80, "Frankie", "21:30", "22:50"),
    new ReservActividades("Música en banda", "Adolescentes", 90, "Dennis", "23:00", "00:30"),
    new ReservActividades("Campamento nocturno", "Adolescentes", 120, "Wayne", "00:30", "02:30"),
    new ReservActividades("Lectura crítica", "Adolescentes", 60, "Mavis", "03:00", "04:00")
};

public static ReservActividades[] adultos = {
    new ReservActividades("SPA", "Adultos", 60, "Drácula", "09:00", "10:00"),
    new ReservActividades("Clase de baile", "Adultos", 90, "Ericka", "10:30", "12:00"),
    new ReservActividades("Yoga", "Adultos", 60, "Mavis", "12:30", "13:30"),
    new ReservActividades("Meditación", "Adultos", 45, "Dennis", "14:00", "14:45"),
    new ReservActividades("Cocina gourmet", "Adultos", 90, "Frankie", "15:00", "16:30"),
    new ReservActividades("Fotografía artística", "Adultos", 70, "Mavis", "17:00", "18:10"),
    new ReservActividades("Teatro clásico", "Adultos", 100, "Drácula", "18:30", "20:10"),
    new ReservActividades("Música coral", "Adultos", 80, "Ericka", "20:30", "21:50"),
    new ReservActividades("Conferencia cultural", "Adultos", 60, "Mavis", "22:00", "23:00"),
    new ReservActividades("Lectura literaria", "Adultos", 50, "Dennis", "23:30", "00:20")
};

public static ReservActividades[] adultosMayores = {
    new ReservActividades("Bingo", "Adultos Mayores", 45, "Frankie", "09:00", "09:45"),
    new ReservActividades("Teatro", "Adultos Mayores", 100, "Drácula", "10:00", "11:40"),
    new ReservActividades("Cine clásico", "Adultos Mayores", 120, "Mavis", "12:00", "14:00"),
    new ReservActividades("Baile de salón", "Adultos Mayores", 90, "Ericka", "14:30", "16:00"),
    new ReservActividades("Cocina tradicional", "Adultos Mayores", 80, "Frankie", "16:30", "17:50"),
    new ReservActividades("Lectura grupal", "Adultos Mayores", 60, "Mavis", "18:00", "19:00"),
    new ReservActividades("Música folklórica", "Adultos Mayores", 70, "Dennis", "19:30", "20:40"),
    new ReservActividades("Juegos de mesa", "Adultos Mayores", 60, "Wayne", "21:00", "22:00"),
    new ReservActividades("Conferencia histórica", "Adultos Mayores", 90, "Drácula", "22:30", "00:00"),
    new ReservActividades("Meditación guiada", "Adultos Mayores", 45, "Mavis", "00:30", "01:15")
};



    // menu
    public static void mostrarMenu() {
        Scanner entrada = new Scanner(System.in);
        int opc;
        do {
            System.out.println("\n--- MENU DE ACTIVIDADES ---");
            System.out.println("1. Infantiles");
            System.out.println("2. Preadolescentes");
            System.out.println("3. Adolescentes");
            System.out.println("4. Adultos");
            System.out.println("5. Adultos Mayores");
            System.out.println("6. Regresar al menu principal");
            System.out.print("Seleccione una opcion: ");
            opc = entrada.nextInt();

            switch (opc) {
                case 1: mostrarCategoria(infantiles, entrada); break;
                case 2: mostrarCategoria(preadolescentes, entrada); break;
                case 3: mostrarCategoria(adolescentes, entrada); break;
                case 4: mostrarCategoria(adultos, entrada); break;
                case 5: mostrarCategoria(adultosMayores, entrada); break;
                case 6: System.out.println("Regresando..."); break;
                default: System.out.println("Opción inválida.");
            }
        } while (opc != 6);
    }


    private static void mostrarCategoria(ReservActividades[] actividades, Scanner entrada) {
        int opc;
        do {
            System.out.println("\n--- ACTIVIDADES " + actividades[0].getClasEdad() + " ---");
            for (int i = 0; i < actividades.length; i++) {
                System.out.println((i+1) + ". " + actividades[i].getTipoActividad() +
                                   " (" + actividades[i].getHoraInicio() + "-" + actividades[i].getHoraFin() + ")");
            }
            System.out.println((actividades.length+1) + ". Regresar");
            System.out.print("Seleccione una actividad: ");
            opc = entrada.nextInt();

            if (opc >= 1 && opc <= actividades.length) {
                ReservActividades seleccionada = actividades[opc-1];
                seleccionada.mostrarInfo();
                System.out.print("¿Cuántas personas desea inscribir? ");
                int cantidad = entrada.nextInt();
                seleccionada.inscribir(cantidad);

                // Guardar en archivo
                RegistroInscripsiones.guardarInscripcion(seleccionada, cantidad);
            } else if (opc == actividades.length+1) {
                System.out.println("Regresando al menú de categorías...");
            } else {
                System.out.println("Opción inválida.");
            }
        } while (opc != actividades.length+1);
    }
}