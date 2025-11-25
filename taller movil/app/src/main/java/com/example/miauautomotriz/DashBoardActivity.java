package com.example.miauautomotriz;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

import androidx.appcompat.app.AppCompatActivity;

public class DashBoardActivity extends AppCompatActivity {

    private Button btnMisReparaciones;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dash_board);

        btnMisReparaciones= findViewById(R.id.btnMisReparaciones);


        btnMisReparaciones.setOnClickListener(v -> {
            Intent intent = new Intent(DashBoardActivity.this, MisReparacionesActivity.class);
            startActivity(intent);
        });
    }
}
