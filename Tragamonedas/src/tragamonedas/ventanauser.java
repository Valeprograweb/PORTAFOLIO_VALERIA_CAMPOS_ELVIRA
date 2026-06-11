/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */package tragamonedas;

import javax.swing.*;
import javax.swing.border.EmptyBorder;
import java.awt.*;
import java.awt.event.*;

public class ventanauser extends JFrame {

    private JTextField txtNombre, txtAp, txtUser;
    private JTextArea areaLista;
    private JButton btnRegistrar, btnEliminar;
    private datos gestion;

    private final Color fondo = new Color(76, 115, 194);

    public ventanauser() {
        setTitle("Usuarios - UPSLP");
        setSize(450, 550);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        
        setLocationRelativeTo(null); 

        gestion = new datos();

        JPanel panelP = new JPanel(new BorderLayout(10, 10));
        panelP.setBackground(fondo);
        panelP.setBorder(new EmptyBorder(20, 20, 20, 20)); 
        
        JPanel panelForm = new JPanel(new GridBagLayout());
        panelForm.setBackground(fondo);
        GridBagConstraints gbc = new GridBagConstraints();
        gbc.insets = new Insets(5, 5, 5, 5);
        gbc.fill = GridBagConstraints.HORIZONTAL;

        gbc.gridx = 0; gbc.gridy = 0;
        panelForm.add(new JLabel("Nombre:"), gbc);
        gbc.gridx = 1;
        txtNombre = new JTextField(15);
        panelForm.add(txtNombre, gbc);

        gbc.gridx = 0; gbc.gridy = 1;
        panelForm.add(new JLabel("Apellido:"), gbc);
        gbc.gridx = 1;
        txtAp = new JTextField(15);
        panelForm.add(txtAp, gbc);

        gbc.gridx = 0; gbc.gridy = 2;
        panelForm.add(new JLabel("Usuario:"), gbc);
        gbc.gridx = 1;
        txtUser = new JTextField(15);
        panelForm.add(txtUser, gbc);

        JPanel panelBotones = new JPanel(new FlowLayout(FlowLayout.CENTER, 10, 10));
        panelBotones.setBackground(fondo);
        
        btnRegistrar = new JButton("Registrar");
        btnRegistrar.setBackground(new Color(17, 46, 107)); 
        btnRegistrar.setForeground(Color.WHITE); 
        
        btnEliminar = new JButton("Eliminar por ID");
        btnEliminar.setBackground(new Color(17, 46, 107));
        btnEliminar.setForeground(Color.WHITE);
        
        panelBotones.add(btnRegistrar);
        panelBotones.add(btnEliminar);

        areaLista = new JTextArea();
        areaLista.setEditable(false);
        areaLista.setFont(new Font("Monospaced", Font.PLAIN, 12));
        JScrollPane scroll = new JScrollPane(areaLista);

        //panel principal
        JPanel panelNorte = new JPanel(new BorderLayout());
        panelNorte.setBackground(fondo);
        panelNorte.add(panelForm, BorderLayout.CENTER);
        panelNorte.add(panelBotones, BorderLayout.SOUTH);

        panelP.add(panelNorte, BorderLayout.NORTH);
        panelP.add(scroll, BorderLayout.CENTER);

        add(panelP);

        // --- EVENTOS ---
        btnRegistrar.addActionListener(e -> {
            if(txtNombre.getText().isEmpty() || txtUser.getText().isEmpty()) {
                JOptionPane.showMessageDialog(this, "Por favor llena los campos.");
                return;
            }
            int id = gestion.obtenerSiguienteId();
            usuario nuevo = new usuario(id, txtNombre.getText(), txtAp.getText(), txtUser.getText());
            gestion.agregar(nuevo);
            actualizar();
            limpiar();
        });

        btnEliminar.addActionListener(e -> {
            String idStr = JOptionPane.showInputDialog(this, "Ingresa el ID a eliminar:");
            if (idStr != null && !idStr.isEmpty()) {
                try {
                    gestion.eliminar(Integer.parseInt(idStr));
                    actualizar();
                } catch (NumberFormatException ex) {
                    JOptionPane.showMessageDialog(this, "ID no válido.");
                }
            }
        });

        addWindowListener(new WindowAdapter() {
            @Override
            public void windowClosing(WindowEvent e) {
                gestion.guardar();
            }
        });

        actualizar();
    }

    private void actualizar() {
        areaLista.setText("");
        for (usuario u : gestion.getListaUsuarios()) {
            areaLista.append(u.toString() + "\n");
        }
    }

    private void limpiar() {
        txtNombre.setText("");
        txtAp.setText("");
        txtUser.setText("");
        txtNombre.requestFocus();
    }
}