/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package hoteltransilvania;

/**
 *
 * @author Katia
 */
public class Empleado extends Monstruo{
    
    protected int antiguedad;
    protected int salario;
    protected int vacs;
    protected String cargo;
    //protected String mesNac;
    protected String rfc;
    
    public Empleado(String nombre, String apP, String apM, String tipo, int anioNac, int mesNac, int diaNac, int antiguedad,String cargo, String rfc, int vacaciones, int salario){

        super(nombre,apP,apM,tipo,anioNac,mesNac,diaNac);
        
        this.rfc = rfc;
        this.antiguedad = antiguedad;
        this.salario = salario;
        this.vacs = vacaciones;
        this.cargo = cargo;
    }
}