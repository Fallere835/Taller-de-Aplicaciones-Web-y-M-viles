package com.example.automotora;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import com.example.automotora.R;
import com.example.automotora.adapter.FacturaAdapter;
import com.example.automotora.model.Factura;
import com.example.automotora.services.AutomotoraService;
import java.util.ArrayList;
import java.util.List;

public class MisFacturasActivity extends AppCompatActivity {

    private RecyclerView recyclerView;
    private FacturaAdapter adapter;
    private AutomotoraService service;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mis_facturas);

        recyclerView = findViewById(R.id.recyclerFactura);
        recyclerView.setLayoutManager(new LinearLayoutManager(this));
        service = new AutomotoraService(this);

        cargarDatos();
    }

    private void cargarDatos() {
        // Simulamos llamada al servicio (Deberías implementar obtenerFacturas en AutomotoraService)
        // Por brevedad, creamos datos mock, pero en la clase usarán Volley
        List<Factura> lista = new ArrayList<>();
        lista.add(new Factura(101, "2023-11-01", 50000, "Pagada"));
        lista.add(new Factura(102, "2023-12-05", 120000, "Pendiente"));

        adapter = new FacturaAdapter(lista, factura -> compartirFactura(factura));
        recyclerView.setAdapter(adapter);
    }

    // --- LÓGICA DE COMPARTIR (Parte 6) ---
    private void compartirFactura(Factura factura) {
        // Generamos el link al PDF que creamos en la Parte 1 Web
        String urlPdf = "http://192.168.1.XX/miautomo/public/exportar_pdf.php?id=" + factura.getId();

        String mensaje = "Hola, te comparto la Factura #" + factura.getId() +
                " por un monto de $" + factura.getMonto() + ".\n" +
                "Descárgala aquí: " + urlPdf;

        Intent intent = new Intent(Intent.ACTION_SEND);
        intent.setType("text/plain");
        intent.putExtra(Intent.EXTRA_TEXT, mensaje);
        intent.putExtra(Intent.EXTRA_SUBJECT, "Factura MIAUtomotriz");

        // Lanzar el chooser (WhatsApp, Gmail, etc.)
        startActivity(Intent.createChooser(intent, "Compartir vía"));
    }
}