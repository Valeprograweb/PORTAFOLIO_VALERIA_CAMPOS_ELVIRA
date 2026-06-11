package hoteltransilvania;

import java.io.FileWriter;
import java.io.IOException;

public class RegistroDeInscripciones {
    private static final String ARCHIVO = "inscripciones.txt";

    public static void guardarInscripcion(ReservActividades act, int cantidad) {
        try (FileWriter fw = new FileWriter(ARCHIVO, true)) {
            fw.write("Actividad: " + act.getTipoActividad() +
                     " | Clasificación: " + act.getClasEdad() +
                     " | Instructor: " + act.getInstructor() +
                     " | Personas: " + cantidad +
                     " | Horario: " + act.getHoraInicio() + "-" + act.getHoraFin() +
                     " | Total inscritos: " + act.getNumInscritos() + "\n");
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}


