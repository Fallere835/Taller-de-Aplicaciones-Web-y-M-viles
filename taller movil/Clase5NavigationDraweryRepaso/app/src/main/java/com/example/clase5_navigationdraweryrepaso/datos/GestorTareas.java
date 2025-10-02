package com.example.clase5_navigationdraweryrepaso.datos;

import com.example.clase5_navigationdraweryrepaso.modelo.Tarea;

import java.util.ArrayList;

public class GestorTareas {
    public static ArrayList<Tarea> getTareas() {
        ArrayList<Tarea> lista = new ArrayList<>();
        lista.add(new Tarea("Preparar entrega Móvil", "Crear el prototipo navegable con intents.", "Alta"));
        lista.add(new Tarea("Estudiar para Base de Datos", "Repasar normalización y SQL.", "Media"));
        lista.add(new Tarea("Comprar pan", "No olvidar.", "Baja"));
        return lista;
    }
}