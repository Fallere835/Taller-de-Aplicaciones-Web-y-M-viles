package com.example.automotora.services;

import android.content.Context;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.automotora.interfaces.LoginCallback;
import org.json.JSONObject;
import java.util.HashMap;
import java.util.Map;

public class AutomotoraService {

    private RequestQueue queue;
    private Context context;
    // IMPORTANTE: Cambiar por la IP de la Raspberry en la clase
    private static final String URL_LOGIN = "http://192.168.X.X/miau_web/api/";

    public AutomotoraService(Context context) {
        this.context = context;
        this.queue = Volley.newRequestQueue(context);
    }

    public void login(String email, String password, final LoginCallback callback) {
        StringRequest request = new StringRequest(Request.Method.POST, URL_LOGIN,
                response -> {
                    try {
                        JSONObject json = new JSONObject(response);
                        if (json.getBoolean("ok")) {
                            // Pasamos solo el objeto 'usuario' al callback
                            callback.onSuccess(json.getJSONObject("usuario"));
                        } else {
                            // Error de lógica (ej. contraseña mala)
                            callback.onError(json.getString("msg"));
                        }
                    } catch (Exception e) {
                        callback.onError("Error procesando datos del servidor");
                    }
                },
                error -> {
                    // Error de red (ej. timeout, sin internet)
                    callback.onError("Error de conexión: " + error.getMessage());
                }
        ) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("email", email);
                params.put("password", password);
                return params;
            }
        };

        queue.add(request);
    }
}