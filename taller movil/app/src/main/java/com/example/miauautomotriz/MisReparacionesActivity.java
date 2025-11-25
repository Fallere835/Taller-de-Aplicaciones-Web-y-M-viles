package com.example.miauautomotriz;

import android.os.Bundle;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class MisReparacionesActivity extends AppCompatActivity {

    private RecyclerView recyclerView;
    private ReparacionAdapter adapter;
    private List<Reparacion> reparaciones;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mis_reparaciones);

        recyclerView = findViewById(R.id.recyclerView);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        reparaciones = new ArrayList<>();
        adapter = new ReparacionAdapter(reparaciones);
        recyclerView.setAdapter(adapter);

        cargarReparaciones();
    }

    private void cargarReparaciones() {
        // Simulación de una respuesta JSON de la API
        String jsonResponse = "{ \"reparaciones\": ["
                + "{ \"id_orden\": 1, \"numero\": \"12345\", \"fecha\": \"2025-11-20\", \"estado\": \"En progreso\", \"patente\": \"ABC123\", \"vehiculo\": \"Toyota Corolla\", \"total\": 20000 },"
                + "{ \"id_orden\": 2, \"numero\": \"12346\", \"fecha\": \"2025-11-22\", \"estado\": \"Finalizada\", \"patente\": \"XYZ456\", \"vehiculo\": \"Honda Civic\", \"total\": 15000 }"
                + "]}";

        try {
            JSONObject jsonResponseObject = new JSONObject(jsonResponse);
            JSONArray reparacionesArray = jsonResponseObject.getJSONArray("reparaciones");

            for (int i = 0; i < reparacionesArray.length(); i++) {
                JSONObject reparacionObj = reparacionesArray.getJSONObject(i);
                Reparacion reparacion = new Reparacion(
                        reparacionObj.getInt("id_orden"),
                        reparacionObj.getString("numero"),
                        reparacionObj.getString("fecha"),
                        reparacionObj.getString("estado"),
                        reparacionObj.getString("patente"),
                        reparacionObj.getString("vehiculo"),
                        reparacionObj.getDouble("total")
                );
                reparaciones.add(reparacion);
            }
            adapter.notifyDataSetChanged();
        } catch (JSONException e) {
            e.printStackTrace();
            Toast.makeText(MisReparacionesActivity.this, "Error al cargar datos", Toast.LENGTH_SHORT).show();
        }
    }
}
