/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/GUIForms/JFrame.java to edit this template
 */
package tragamonedas;

import javax.swing.*;
/**
 *
 * @author SA-CTE-Lap-AS7
 */
public class juego extends javax.swing.JFrame {
    
    private botones botones;
    /**
     * Creates new form juego
     */
    public juego() {
        initComponents();
        this.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        botones = new botones(img1, img2, img3, Mensaje, btntirar);
    }

    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jLabel2 = new javax.swing.JLabel();
        jPanel1 = new javax.swing.JPanel();
        img1 = new javax.swing.JLabel();
        img2 = new javax.swing.JLabel();
        img3 = new javax.swing.JLabel();
        Mensaje = new javax.swing.JLabel();
        btntirar = new javax.swing.JButton();
        jLabel1 = new javax.swing.JLabel();
        fjuego = new javax.swing.JLabel();

        jLabel2.setText("jLabel2");

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        jPanel1.setLayout(new org.netbeans.lib.awtextra.AbsoluteLayout());

        img1.setBackground(new java.awt.Color(255, 255, 255));
        jPanel1.add(img1, new org.netbeans.lib.awtextra.AbsoluteConstraints(40, 210, 140, 160));
        jPanel1.add(img2, new org.netbeans.lib.awtextra.AbsoluteConstraints(200, 210, 140, 160));
        jPanel1.add(img3, new org.netbeans.lib.awtextra.AbsoluteConstraints(360, 210, 140, 160));
        jPanel1.add(Mensaje, new org.netbeans.lib.awtextra.AbsoluteConstraints(270, 470, 160, 30));

        btntirar.setBackground(new java.awt.Color(204, 153, 0));
        btntirar.setText("TIRAR");
        btntirar.setBorder(javax.swing.BorderFactory.createBevelBorder(javax.swing.border.BevelBorder.RAISED));
        btntirar.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                btntirarActionPerformed(evt);
            }
        });
        jPanel1.add(btntirar, new org.netbeans.lib.awtextra.AbsoluteConstraints(100, 470, 130, 30));

        jLabel1.setIcon(new javax.swing.ImageIcon(getClass().getResource("/negro.png"))); // NOI18N
        jPanel1.add(jLabel1, new org.netbeans.lib.awtextra.AbsoluteConstraints(0, 460, 550, 70));

        fjuego.setIcon(new javax.swing.ImageIcon(getClass().getResource("/casino.jpg"))); // NOI18N
        jPanel1.add(fjuego, new org.netbeans.lib.awtextra.AbsoluteConstraints(0, -20, -1, 500));

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(jPanel1, javax.swing.GroupLayout.PREFERRED_SIZE, 545, javax.swing.GroupLayout.PREFERRED_SIZE)
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addComponent(jPanel1, javax.swing.GroupLayout.PREFERRED_SIZE, 528, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addGap(0, 0, Short.MAX_VALUE))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    
    
    private void btntirarActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_btntirarActionPerformed
        // TODO add your handling code here:
        botones.tirar();
    }//GEN-LAST:event_btntirarActionPerformed
    
    
    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        /* Set the Nimbus look and feel */
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(juego.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(juego.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(juego.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(juego.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable(){
            @Override
            public void run() {
                new juego().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JLabel Mensaje;
    private javax.swing.JButton btntirar;
    private javax.swing.JLabel fjuego;
    private javax.swing.JLabel img1;
    private javax.swing.JLabel img2;
    private javax.swing.JLabel img3;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JPanel jPanel1;
    // End of variables declaration//GEN-END:variables
}
