package com.example.clase5_navigationdraweryrepaso;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

public class LoginActivity extends AppCompatActivity {
    EditText etUsuario;
    EditText etContrasena;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_login);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.LoginActivity), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        Button btnIngresar = findViewById(R.id.btnIngresar);
        btnIngresar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                validarlogin();
            }
        });
    }
    public void validarlogin(){
        etUsuario = findViewById(R.id.etUsuario);
        etContrasena = findViewById(R.id.etContrasena);

        String usuario = etUsuario.getText().toString(); //usuario
        String contrasena = etContrasena.getText().toString();//pass
        if(usuario.isEmpty() || contrasena.isEmpty()){
            Toast.makeText(LoginActivity.this, "Por favor, ingrese un usuario y una contraseña", Toast.LENGTH_SHORT).show();
        } else if (usuario.equals("usuario") && contrasena.equals("pass")) {
            Toast.makeText(LoginActivity.this, "Inicio de sesión exitoso", Toast.LENGTH_SHORT).show();

            Intent intent = new Intent(LoginActivity.this, MainActivity.class);
            startActivity(intent);

            // Cerrar la actividad actual para que el usuario no pueda volver atrás
            finish();
        }else {
            Toast.makeText(LoginActivity.this, "Usuario o contraseña incorrectos", Toast.LENGTH_SHORT).show();
        }
    }
}