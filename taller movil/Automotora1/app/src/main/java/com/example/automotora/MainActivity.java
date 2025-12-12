package com.example.automotora;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import com.example.automotora.services.AutomotoraService;
import com.example.automotora.interfaces.LoginCallback;
import org.json.JSONException;
import org.json.JSONObject;

public class MainActivity extends AppCompatActivity {

    EditText etEmail, etPass;
    Button btnLogin;
    AutomotoraService autoService; // Instancia del servicio

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        etEmail = findViewById(R.id.etEmail);
        etPass = findViewById(R.id.etPassword);
        btnLogin = findViewById(R.id.btnLogin);

        // Inicializamos el servicio
        autoService = new AutomotoraService(this);

        btnLogin.setOnClickListener(v -> intentarLogin());
    }

    private void intentarLogin() {
        String email = etEmail.getText().toString();
        String pass = etPass.getText().toString();

        // Llamamos al método limpio, pasando la interfaz anónima
        autoService.login(email, pass, new LoginCallback() {
            @Override
            public void onSuccess(JSONObject usuario) {
                try {
                    // Lógica de UI y Persistencia
                    String rol = usuario.getString("rol");
                    String nombre = usuario.getString("nombre");

                    guardarSesion(nombre, rol);

                    // Navegar
                    Intent i = new Intent(MainActivity.this, MenuActivity.class);
                    startActivity(i);
                    finish();

                } catch (JSONException e) {
                    Toast.makeText(MainActivity.this, "Error leyendo usuario", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onError(String mensaje) {
                // Solo mostramos el error
                Toast.makeText(MainActivity.this, mensaje, Toast.LENGTH_SHORT).show();
            }
        });
    }

    private void guardarSesion(String nombre, String rol) {
        SharedPreferences prefs = getSharedPreferences("AutoPrefs", MODE_PRIVATE);
        prefs.edit()
                .putBoolean("isLogged", true)
                .putString("nombre", nombre)
                .putString("rol", rol)
                .apply();
    }
}