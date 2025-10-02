package com.example.clase5_navigationdraweryrepaso.modelo;

public class Tarea {
    private String titulo;
    private String descripcion;
    private String prioridad; // "Alta", "Media", "Baja"

    public Tarea(String titulo, String descripcion, String prioridad) {
        this.titulo = titulo;
        this.descripcion = descripcion;
        this.prioridad = prioridad;
    }

    public String getTitulo() { return titulo; }
    public String getDescripcion() { return descripcion; }
    public String getPrioridad() { return prioridad; }

    @Override
    public String toString() {
        // Esto se mostrará en la lista
        return getTitulo();
    }
}