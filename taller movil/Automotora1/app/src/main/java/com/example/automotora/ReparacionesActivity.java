package com.example.automotora;

import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import com.ejemplo.automotora.adapter.ReparacionAdapter;
import com.example.automotora.interfaces.AccionCallback;
import com.example.automotora.interfaces.ListaCallback;
import com.example.automotora.model.Reparacion;
import com.example.automotora.services.AutomotoraService;
import java.util.ArrayList;
import java.util.List;

public class ReparacionesActivity extends AppCompatActivity {

    private AutomotoraService servicio;
    private EditText etBuscar;
    private Button btnBuscar;
    private RecyclerView recycler;
    private ReparacionAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reparaciones);

        // 1. Vincular UI
        etBuscar = findViewById(R.id.etBuscar);
        btnBuscar = findViewById(R.id.btnBuscar);
        recycler = findViewById(R.id.recyclerReparaciones); // Asegúrate que el ID sea este en tu XML

        // 2. Configurar RecyclerView
        recycler.setLayoutManager(new LinearLayoutManager(this));
        // Inicializamos adaptador vacío por ahora
        adapter = new ReparacionAdapter(new ArrayList<>(), idReparacion -> {
            // Acción al hacer clic en "Aprobar"
            aprobarCotizacion(idReparacion);
        });
        recycler.setAdapter(adapter);

        // 3. Inicializar Servicio
        servicio = new AutomotoraService(this);

        // 4. Configurar Botón
        btnBuscar.setOnClickListener(v -> cargarLista(etBuscar.getText().toString()));

        // 5. Carga inicial
        cargarLista("");
    }

    private void cargarLista(String patente) {
        servicio.obtenerReparaciones(patente, new ListaCallback() {
            @Override
            public void onSuccess(List<Reparacion> lista) {
                if (lista.isEmpty()) {
                    Toast.makeText(ReparacionesActivity.this, "No se encontraron vehículos", Toast.LENGTH_SHORT).show();
                }
                // Actualizamos el adaptador con los datos nuevos
                adapter.setLista(lista);
            }

            @Override
            public void onError(String error) {
                Toast.makeText(ReparacionesActivity.this, error, Toast.LENGTH_LONG).show();
            }
        });
    }

    private void aprobarCotizacion(int id) {
        servicio.aprobarReparacion(id, new AccionCallback() {
            @Override
            public void onSuccess(String mensaje) {
                Toast.makeText(ReparacionesActivity.this, mensaje, Toast.LENGTH_SHORT).show();
                cargarLista(""); // Recargar lista para ver el cambio de estado
            }

            @Override
            public void onError(String error) {
                Toast.makeText(ReparacionesActivity.this, "Error: " + error, Toast.LENGTH_SHORT).show();
            }
        });
    }
}