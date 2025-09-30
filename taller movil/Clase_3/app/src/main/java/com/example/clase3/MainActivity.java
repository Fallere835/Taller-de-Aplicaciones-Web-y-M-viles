package com.example.clase3;

import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;

public class MainActivity extends AppCompatActivity {
    private Spinner spinnerVehiculos;
    private TextView textViewSeleccion;
    private ArrayList<Vehiculo> listaVehiculos;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_main);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        spinnerVehiculos = findViewById(R.id.spinnerVehiculos);
        textViewSeleccion = findViewById(R.id.textViewSeleccion);
        listaVehiculos = new ArrayList<>();

        cargarDatosDesdeAssets();

        ArrayAdapter<Vehiculo> adapter = new ArrayAdapter<>(this,
                android.R.layout.simple_spinner_item, listaVehiculos);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerVehiculos.setAdapter(adapter);

        spinnerVehiculos.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                Vehiculo vehiculoSeleccionado = (Vehiculo) parent.getItemAtPosition(position);
                textViewSeleccion.setText("Vehículo seleccionado: " + vehiculoSeleccionado.getMarca()+
                " "+vehiculoSeleccionado.getModelo() + " "+vehiculoSeleccionado.getPatente());
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
                // No hacer nada
            }
        });
    }

    private void cargarDatosDesdeAssets() {
        try {
            BufferedReader reader = new BufferedReader(
                    new InputStreamReader(getAssets().open("vehiculos.txt")));

            String linea;
            while ((linea = reader.readLine()) != null) {
                String[] partes = linea.split(",");
                if(partes.length==3){
                    Vehiculo vehiculo = new Vehiculo(partes[0],partes[1],partes[2]);
                    listaVehiculos.add(vehiculo);
                }

            }
            reader.close();
        } catch (IOException e) {
            e.printStackTrace();
            Toast.makeText(this, "Error al leer el archivo", Toast.LENGTH_SHORT).show();
        }
    }
}
