/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tragamonedas;
import java.io.*;
import java.util.ArrayList;

/**
 *
 * @author SA-CTE-Lap-AS7
 */
public class datos {
    
    private ArrayList<usuario> usuarios;
    private final String nomarch = "usuarios.txt";
    
    public datos() {
        this.usuarios = new ArrayList<>();
        cargar(); 
    }
    
    public void agregar(usuario u) {
        usuarios.add(u);
    }
    
    // Método para eliminar por ID 
    public void eliminar(int id) {
        for (int i = 0; i < usuarios.size(); i++) {
            if (usuarios.get(i).getId() == id) {
                usuarios.remove(i);
                break; 
            }
        }
    }
    
     // Carga los datos del archivo al ArrayList al iniciar
    private void cargar() {
        File arch = new File(nomarch);
        if (!arch.exists()) return; 

        try (BufferedReader br = new BufferedReader(new FileReader(arch))) {
            String linea;
            while ((linea = br.readLine()) != null) {
                String[] datos = linea.split(",");
                if (datos.length == 5) {
                    int id = Integer.parseInt(datos[0].trim());
                    usuario u = new usuario(id, datos[1].trim(), datos[2].trim(), datos[3].trim());
                    usuarios.add(u);
                }
            }
        } catch (Exception e) {
            System.out.println("Error al cargar: " + e.getMessage());
        }
    }
    
    // Guarda todo el ArrayList en el archivo 
    public void guardar() {
        try (PrintWriter pw = new PrintWriter(new FileWriter(nomarch, false))) {
            for (usuario u : usuarios) {
                pw.println(u.toString()); 
            }
        } catch (Exception e) {
            System.out.println("Error al guardar: " + e.getMessage());
        }
    }
    
    public ArrayList<usuario> getListaUsuarios() {
        return usuarios;
    }

    public int obtenerSiguienteId() {
        if (usuarios.isEmpty()) return 1;
        int maxId = 0;
        for (usuario u : usuarios) {
            if (u.getId() > maxId) maxId = u.getId();
        }
        return maxId + 1;
    }
}
