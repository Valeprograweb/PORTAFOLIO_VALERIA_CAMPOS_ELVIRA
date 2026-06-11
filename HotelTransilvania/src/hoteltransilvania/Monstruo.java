/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package hoteltransilvania;

/**
 *
 * @author SA-CTE-Lap-AS7
 */
public class Monstruo {
    
    protected String nombre;
    protected String apP;
    protected String apM;
    protected String tipo;
    protected int diaNac;
    protected int mesNac;
    protected int anioNac;

    public Monstruo(String nombre, String apP, String apM, String tipo, int anioNac, int mesNac, int diaNac){
        this.nombre = nombre;
        this.apP = apP;
        this.apM = apM;
        this.tipo = tipo;
        this.anioNac = anioNac;
        this.mesNac = mesNac;
        this.diaNac = diaNac;
    }
    
    public String clave(){

        char letra1 = apP.charAt(0);
        char letra2 = apM.charAt(0);
        char letra3 = nombre.charAt(0);

        int anioCorto = anioNac % 100;

        String clave = (""+letra1+letra2+letra3).toUpperCase()+anioCorto;

        return clave;
    }   
}
