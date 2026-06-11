/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package hoteltransilvania;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;

/**
 *
 * @author amand
 */

public class RegistroInscripsiones {

    private static final String ARCHIVO = "inscripciones.txt";

    public static void guardarInscripcion(ReservActividades actividad, int cantidad) {
        try (PrintWriter pw = new PrintWriter(new FileWriter(ARCHIVO, true))) {
            pw.println("Actividad: " + actividad.getTipoActividad() +
                       " | Categoría: " + actividad.getClasEdad() +
                       " | Instructor: " + actividad.getInstructor() +
                       " | Horario: " + actividad.getHoraInicio() + "-" + actividad.getHoraFin() +
                       " | Inscritos: " + actividad.getNumInscritos() +
                       " | Nueva inscripción: " + cantidad);
        } catch (IOException e) {
            System.out.println("Error al guardar inscripción: " + e.getMessage());
        }
    }
}