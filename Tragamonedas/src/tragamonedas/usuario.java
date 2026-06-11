/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tragamonedas;
import java.util.Random;
/**
 *
 * @author SA-CTE-Lap-AS7
 */
public class usuario {
    
    private int id;
    private String nombre;
    private String ap;
    private String user;
    private String pass;
    
    public usuario(int id, String nombre, String ap, String user) {
        this.id = id;
        this.nombre = nombre;
        this.ap = ap;
        this.user = user;
        this.pass = Password();
    }
    
    private String Password() {
        Random r = new Random();
        //Dos primeras letras del nombre en minúsculas 
        String part1 = nombre.substring(0, 2).toLowerCase();       
        //Primera letra del apellido en MAYÚSCULAS
        String part2 = ap.substring(0, 1).toUpperCase();
        //Tres números aleatorios (del 100 al 999 para que siempre sean 3) 
        int numal = r.nextInt(900) + 100;
        //símbolo aleatorio
        String simbolos = ".,$%?";
        char simbal = simbolos.charAt(r.nextInt(simbolos.length()));
        return part1 + part2 + numal + simbal;
    }
    
    public int getId() { return id; }
    public String getNombre() { return nombre; }
    public String getApellido() { return ap; }
    public String getUser() { return user; }
    public String getPass() { return pass; }
    
     @Override
    public String toString() {
        return id + ", " + nombre + ", " + ap + ", " + user + ", " + pass;
    }

}
