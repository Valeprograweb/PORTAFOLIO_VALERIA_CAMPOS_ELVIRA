/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tragamonedas;

import java.awt.Color;
import java.awt.Image;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.Timer;
import java.util.ArrayList;

/**
 *
 * @author SA-CTE-Lap-AS7
 */
public class botones {
    private int turnos = 3;
    private int pts = 100;
    private int contF = 0;
    private Timer timer;
    private JLabel img1, img2, img3, mensaje;
    private JButton btnTirar;
    
    private ArrayList<ImageIcon> imgs;
    private final String especial = "estrella.png";//simbolo especial
    private final String[] archivos = {
        "peach.jpg", "mario.jpg", "bowser.png", "lougi.png",
        "honguito.png", "estrella.png", "flor.png",
        "caparazon.png", "moneda.png", "yoshi.png"
    };
    
    
    public botones(JLabel img1, JLabel img2, JLabel img3, JLabel mensaje, JButton btnTirar) {
        this.img1 = img1;
        this.img2 = img2;
        this.img3 = img3;
        this.mensaje = mensaje;
        this.btnTirar = btnTirar;
        
       cargar();
       System.out.println("JUEGO INICIALIZADO");
}
    private void cargar() {
        imgs = new ArrayList<>();
        for (String nombre : archivos) {
            java.net.URL url = getClass().getResource("/" + nombre);
            if (url != null) {
                imgs.add(new ImageIcon(url));
            } else {
                System.out.println("Error " + nombre);
            }
        }
    }
    
    public void tirar() {
        if (turnos > 0 && pts > 0) {
            girar();
            timer();
        } else {
            fin();
        }
    }
    
    private void girar() {
        turnos--; //consume un turno
        pts -= 10; //costo de giro
        btnTirar.setEnabled(false);
        mensaje.setText("Girando...");
        mensaje.setForeground(Color.WHITE);
        
        System.out.println("\nTurnos: " + turnos + "\nPuntos: " + pts);
    }
    
    private void timer() {
        contF = 0;//contador de giros del timer
        timer = new Timer(100, new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                contF++;
                //aleatoriOS desde el ArrayList
                int r1 = (int) (Math.random() * imgs.size());
                int r2 = (int) (Math.random() * imgs.size());
                int r3 = (int) (Math.random() * imgs.size());

                escala(img1, r1);
                escala(img2, r2);
                escala(img3, r3);

                if (contF >= 20) {
                    timer.stop();
                    resultados(r1, r2, r3);
                }
            }
        });
        timer.start();
    }

    private void escala(JLabel label, int indice) {
        ImageIcon original = imgs.get(indice);
        Image escalada = original.getImage().getScaledInstance(
                label.getWidth(), label.getHeight(), Image.SCALE_SMOOTH);
        label.setIcon(new ImageIcon(escalada));
    }
    private void resultados(int i1, int i2, int i3) {
            String s1 = archivos[i1];
            String s2 = archivos[i2];
            String s3 = archivos[i3];
            int bonus = 0;

            //Símbolo Especial
            int especiales = 0;
            if (s1.equals(especial)) especiales++;
            if (s2.equals(especial)) especiales++;
            if (s3.equals(especial)) especiales++;
            if (especiales == 3) {
                pts += 500;
                JOptionPane.showMessageDialog(null, "¡TRIPLE ESPECIAL!");
                fin();
                return;
            } else if (especiales == 2) {
                bonus += 25;
            } else if (especiales == 1) {
                bonus += 10;
            }
            //simbolos Normales
            if (s1.equals(s2) && s2.equals(s3)) {
                bonus += 50; // 3 iguales
            } else if (s1.equals(s2) || s2.equals(s3) || s1.equals(s3)) {
                bonus += 20; // 2 iguales
            }
            pts += bonus;
            System.out.println("RESULTADO FINAL: [" + s1 + "],[" + s2 + "],[" + s3 + "]");
            System.out.println("PUNTOS GANADOS: " + bonus+ "\nTOTAL: " + pts);

            verificar(bonus);
        }

        private void verificar(int bonus) {
            if (bonus > 0) {
                mensaje.setText("Ganaste " + bonus + " pts!");
                mensaje.setForeground(Color.YELLOW);
            } else {
                mensaje.setText("Suerte para la proxima.");
                mensaje.setForeground(Color.WHITE);
            }
            if (turnos <= 0 || pts <= 0) {
                fin();
            } else {
                btnTirar.setEnabled(true);
            }
        }

        private void fin() {
            btnTirar.setEnabled(false);
            String causa = (pts <= 0) ? "Puntos agotados." : "Turnos agotados.";

            System.out.println("\n------------------------------");
            System.out.println("      FIN DE LA PARTIDA     ");
            System.out.println("      Puntaje Final: " + pts);
            System.out.println("------------------------------");

            JOptionPane.showMessageDialog(null, 
                    "FIN DEL JUEGO\n" + causa + "\nPuntos finales: " + pts, 
                    "Resumen", JOptionPane.INFORMATION_MESSAGE);
        }
}