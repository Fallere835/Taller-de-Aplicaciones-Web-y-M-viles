package com.example.automotora.model;

public class Reparacion {
    private int id;
    private String patente;
    private String modelo;
    private String estado;
    private int costo;

    public Reparacion(int id, String patente, String modelo, String estado, int costo) {
        this.id = id;
        this.patente = patente;
        this.modelo = modelo;
        this.estado = estado;
        this.costo = costo;
    }

    public int getId() { return id; }
    public String getPatente() { return patente; }
    public String getModelo() { return modelo; }
    public String getEstado() { return estado; }
    public int getCosto() { return costo; }
}