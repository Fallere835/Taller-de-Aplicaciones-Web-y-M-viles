package com.example.automotora.interfaces;

import org.json.JSONObject;

public interface LoginCallback {
    void onSuccess(JSONObject usuario);
    void onError(String mensaje);
}