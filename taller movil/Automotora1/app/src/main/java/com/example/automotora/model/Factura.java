package com.example.automotora.model;

public class Factura {
    private int id;
    private String fecha;
    private int monto;
    private String estado; // "Pagada", "Pendiente"

    public Factura(int id, String fecha, int monto, String estado) {
        this.id = id;
        this.fecha = fecha;
        this.monto = monto;
        this.estado = estado;
    }

    public int getId() { return id; }
    public String getFecha() { return fecha; }
    public int getMonto() { return monto; }
    public String getEstado() { return estado; }
}