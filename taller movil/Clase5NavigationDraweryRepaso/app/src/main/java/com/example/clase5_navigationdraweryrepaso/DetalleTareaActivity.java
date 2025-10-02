package com.example.clase5_navigationdraweryrepaso;

import android.os.Bundle;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

public class DetalleTareaActivity extends AppCompatActivity {
    TextView tvTitulo,tvDescripcion,tvPrioridad;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_detalle_tarea);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.DetalleTarea), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        tvTitulo = findViewById(R.id.tvTituloDetalle);
        tvDescripcion = findViewById(R.id.tvDescripcionDetalle);
        tvPrioridad = findViewById(R.id.tvPrioridadDetalle);

        Bundle extras = getIntent().getExtras();

        /*String titulo = getIntent().getStringExtra("titulo");
        String descripcion = getIntent().getStringExtra("descripcion");
        String prioridad = getIntent().getStringExtra("prioridad");*/

        if (extras != null) {
            String titulo = extras.getString("titulo");
            String descripcion = extras.getString("descripcion");
            String prioridad = extras.getString("prioridad");

            tvTitulo.setText(titulo);
            tvDescripcion.setText(descripcion);
            tvPrioridad.setText("Prioridad: " + prioridad);
        }
    }
}