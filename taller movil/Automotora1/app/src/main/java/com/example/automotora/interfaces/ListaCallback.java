package com.example.automotora.interfaces;

import com.example.automotora.model.Reparacion;

import java.util.List;

public interface ListaCallback {
    void onSuccess(List<Reparacion> lista);
    void onError(String error);
}