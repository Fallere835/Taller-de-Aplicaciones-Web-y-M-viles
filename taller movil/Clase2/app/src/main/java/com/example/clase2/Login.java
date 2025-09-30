package com.example.clase2;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import android.os.Bundle;

public class Login extends AppCompatActivity {
    EditText nombreUsuario;
    Button loginButton;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        nombreUsuario=findViewById(R.id.usernameInput);
        loginButton=findViewById(R.id.loginButton);

        loginButton.setOnClickListener(v -> {
            String nombre=nombreUsuario.getText().toString();

            if(nombre.isEmpty()){
                Toast.makeText(this, "el nombre es incorrecto",Toast.LENGTH_SHORT).show();
            }
            else{
                Intent intent= new Intent(this, MainActivity.class);
                intent.putExtra("usuario",nombre);
                startActivity(intent);
            }
        });
    }
}