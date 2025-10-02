package com.example.clase5_navigationdraweryrepaso;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.clase5_navigationdraweryrepaso.datos.GestorTareas;
import com.example.clase5_navigationdraweryrepaso.modelo.Tarea;

import java.util.ArrayList;

public class ListaTareasActivity extends AppCompatActivity {
    TextView tvTareas;
    ListView lvTareas;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_lista_tareas);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.ListaTareasActivity), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        lvTareas = findViewById(R.id.lvTareas);
        ArrayList<Tarea> tareas = GestorTareas.getTareas();
        ArrayAdapter<Tarea> adapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, tareas);
        lvTareas.setAdapter(adapter);

        lvTareas.setOnItemClickListener((parent, view, position, id) -> {
            Tarea tarea = tareas.get(position);
            Intent intent = new Intent(ListaTareasActivity.this, DetalleTareaActivity.class);

            intent.putExtra("titulo", tarea.getTitulo());
            intent.putExtra("descripcion", tarea.getDescripcion());
            intent.putExtra("prioridad", tarea.getPrioridad());

            startActivity(intent);
        });
    }

}