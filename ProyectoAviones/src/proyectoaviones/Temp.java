/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package proyectoaviones;

import javax.swing.JOptionPane;

/**
 *
 * @author 186106
 */
public class Temp extends Thread {
    
    private javax.swing.JFrame ventana;

    public Temp(javax.swing.JFrame ventana) {
        this.ventana = ventana;
    }
    
    @Override
    public void run() {
        for (int i = 0; i < 60; i++){
            retrasar();
            if (i == 59 ){
                JOptionPane.showMessageDialog(null,"Sesión Terminada");
                if (ventana != null) {
                    ventana.dispose(); 
                }
                new Inicio().setVisible(true);
            }
        }
    }
    
    public void retrasar(){
        try {
            Thread.sleep(1000);
        } catch(InterruptedException e){
            
        }
    }
    
}