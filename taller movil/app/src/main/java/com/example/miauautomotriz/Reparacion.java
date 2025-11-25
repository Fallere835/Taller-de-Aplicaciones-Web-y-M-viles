package com.example.miauautomotriz;

public class Reparacion {
    private int idOrden;
    private String numero;
    private String fecha;
    private String estado;
    private String patente;
    private String vehiculo;
    private double total;

    public Reparacion(int idOrden, String numero, String fecha, String estado, String patente, String vehiculo, double total) {
        this.idOrden = idOrden;
        this.numero = numero;
        this.fecha = fecha;
        this.estado = estado;
        this.patente = patente;
        this.vehiculo = vehiculo;
        this.total = total;
    }

    public int getIdOrden() {
        return idOrden;
    }

    public void setIdOrden(int idOrden) {
        this.idOrden = idOrden;
    }

    public String getNumero() {
        return numero;
    }

    public void setNumero(String numero) {
        this.numero = numero;
    }

    public String getFecha() {
        return fecha;
    }

    public void setFecha(String fecha) {
        this.fecha = fecha;
    }

    public String getEstado() {
        return estado;
    }

    public void setEstado(String estado) {
        this.estado = estado;
    }

    public String getPatente() {
        return patente;
    }

    public void setPatente(String patente) {
        this.patente = patente;
    }

    public String getVehiculo() {
        return vehiculo;
    }

    public void setVehiculo(String vehiculo) {
        this.vehiculo = vehiculo;
    }

    public double getTotal() {
        return total;
    }

    public void setTotal(double total) {
        this.total = total;
    }

    // Getters y setters
}
