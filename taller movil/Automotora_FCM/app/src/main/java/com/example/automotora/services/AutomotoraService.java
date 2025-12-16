package com.example.automotora.services;

import android.content.Context;
import android.util.Log;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.automotora.interfaces.LoginCallback;
import com.example.automotora.interfaces.AccionCallback;
import com.example.automotora.interfaces.ListaCallback;
import com.example.automotora.model.Reparacion;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class AutomotoraService {

    private RequestQueue queue;
    private Context context;
    // IMPORTANTE: Cambiar por la IP de la Raspberry en la clase
    private static final String URL = "http://192.168.X.X/miau_web/api/";

    public AutomotoraService(Context context) {
        this.context = context;
        this.queue = Volley.newRequestQueue(context);
    }

    public void login(String email, String password, final LoginCallback callback) {
        StringRequest request = new StringRequest(Request.Method.POST, URL,
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
    // 2. OBTENER REPARACIONES (GET)
    public void obtenerReparaciones(String filtroPatente, final ListaCallback callback) {
        String url = URL;
        if (filtroPatente != null && !filtroPatente.isEmpty()) {
            url += "?patente=" + filtroPatente;
        }

        StringRequest request = new StringRequest(Request.Method.GET, url,
                response -> {
                    try {
                        List<Reparacion> lista = new ArrayList<>();
                        JSONArray jsonArray = new JSONArray(response);

                        for (int i = 0; i < jsonArray.length(); i++) {
                            JSONObject obj = jsonArray.getJSONObject(i);
                            lista.add(new Reparacion(
                                    obj.getInt("id"),
                                    obj.getString("patente"),
                                    obj.getString("modelo"),
                                    obj.getString("estado"),
                                    obj.getInt("costo_estimado")
                            ));
                        }
                        callback.onSuccess(lista);
                    } catch (Exception e) {
                        callback.onError("Error procesando lista: " + e.getMessage());
                    }
                },
                error -> callback.onError("Error de red: " + error.getMessage())
        );
        queue.add(request);
    }

    // 3. APROBAR REPARACIÓN (POST)
    public void aprobarReparacion(int idReparacion, final AccionCallback callback) {
        JSONObject params = new JSONObject();
        try {
            params.put("id", idReparacion);
            params.put("nuevo_estado", "aprobado_cliente");
        } catch (Exception e) { }

        JsonObjectRequest request = new JsonObjectRequest(Request.Method.POST, URL, params,
                response -> {
                    try {
                        if (response.getBoolean("ok")) {
                            callback.onSuccess(response.getString("mensaje"));
                        } else {
                            callback.onError(response.getString("mensaje"));
                        }
                    } catch (Exception e) {
                        callback.onError("Error leyendo respuesta del servidor");
                    }
                },
                error -> callback.onError("Error enviando solicitud POST")
        );
        queue.add(request);
    }
    public void actualizarTokenFCM(String email, String token) {
        String url = URL+"/actualizar_token.php"; // Ajusta tu IP

        JSONObject params = new JSONObject();
        try {
            params.put("email", email);
            params.put("token", token);
        } catch (JSONException e) { e.printStackTrace(); }

        JsonObjectRequest request = new JsonObjectRequest(Request.Method.POST, url, params,
                response -> Log.d("FCM_UPDATE", "Token actualizado en servidor"),
                error -> Log.e("FCM_UPDATE", "Error actualizando token: " + error.getMessage())
        );
        queue.add(request);
    }
}