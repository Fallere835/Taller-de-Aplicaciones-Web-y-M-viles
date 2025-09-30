package com.example.clase3;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.util.Log; // Importación añadida
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.util.ArrayList;

public class MainActivity extends AppCompatActivity {
    private Spinner spinnerVehiculos;
    private TextView textViewMostrarVehiculos;
    private ArrayList<String> listaVehiculos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        spinnerVehiculos = findViewById(R.id.spinnerVehiculos);
        textViewMostrarVehiculos = findViewById(R.id.mostrarVehiculos);
        listaVehiculos = new ArrayList<>();

        //Funcion para cargar datos en ArrayList
        cargarDatos();
        //Puente para cargar datos desde una lista a un objeto de interfaz
        ArrayAdapter<String> adapter = new ArrayAdapter<>(this,
                android.R.layout.simple_spinner_item, listaVehiculos);
        //Mostrar elementos en forma descendente
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinnerVehiculos.setAdapter(adapter);
        //Darle una acción al spinner
        spinnerVehiculos.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                String vehiculoSeleccionado = (String) parent.getItemAtPosition(position);
                // Modificado para usar el recurso de cadena
                textViewMostrarVehiculos.setText(getString(R.string.vehiculo_seleccionado, vehiculoSeleccionado));
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
                //No hacer nada
            }
        });

    }

    private void cargarDatos() {
        try{
            BufferedReader reader= new BufferedReader(
                    new InputStreamReader(getAssets().open("vehiculos.txt")));
            String linea;
            while ((linea=reader.readLine())!=null){
                listaVehiculos.add(linea);
            }
            reader.close();
        }
        catch (IOException e){
            // Modificado para usar Log.e
            Log.e("MainActivity", "Error al cargar datos", e);
            Toast.makeText(this, "No se pudo leer el archivo", Toast.LENGTH_SHORT).show();

        }
    }
}