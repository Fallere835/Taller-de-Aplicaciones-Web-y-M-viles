package com.example.automotora;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;

// Importaciones necesarias para Firebase
import com.example.automotora.MenuActivity;
import com.example.automotora.interfaces.LoginCallback;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.messaging.FirebaseMessaging;

import com.example.automotora.R;
import com.example.automotora.services.AutomotoraService; // Tu clase de servicio
import org.json.JSONException;
import org.json.JSONObject;

public class MainActivity extends AppCompatActivity {

    // Variables de la vista
    EditText etEmail, etPass;
    Button btnLogin;

    // Nuestro servicio de conexión (Volley)
    AutomotoraService autoService;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // 1. Enlazar controles
        etEmail = findViewById(R.id.etEmail);
        etPass = findViewById(R.id.etPassword);
        btnLogin = findViewById(R.id.btnLogin);

        // 2. Inicializar el servicio
        autoService = new AutomotoraService(this);

        // 3. Configurar el botón
        btnLogin.setOnClickListener(v -> intentarLogin());
    }

    private void intentarLogin() {
        String email = etEmail.getText().toString();
        String pass = etPass.getText().toString();

        // Llamamos al método login de nuestro servicio
        autoService.login(email, pass, new LoginCallback() {
            @Override
            public void onSuccess(JSONObject usuario) {
                try {
                    // A. Login Exitoso: Obtenemos datos del usuario
                    String nombre = usuario.getString("nombre");
                    String rol = usuario.getString("rol");

                    // B. Guardamos sesión local (SharedPreferences)
                    guardarSesionLocal(nombre, rol, email);

                    // --- INICIO BLOQUE FIREBASE (LO NUEVO) ---
                    // Explicación: Ya sabemos quién es el usuario (email).
                    // Ahora obtenemos el Token del celular para asociarlos.
                    obtenerYGuardarTokenFCM(email);
                    // --- FIN BLOQUE FIREBASE ---

                    // D. Navegar a la pantalla principal (Dashboard)
                    // Nota: Si quieres esperar a que el token se guarde, puedes mover esto
                    // dentro de la función de Firebase, pero para no bloquear al usuario,
                    // lo dejamos aquí y el token se actualiza en segundo plano.
                    irAlDashboard();

                } catch (JSONException e) {
                    Toast.makeText(MainActivity.this, "Error leyendo datos", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onError(String error) {
                Toast.makeText(MainActivity.this, "Error: " + error, Toast.LENGTH_SHORT).show();
            }
        });
    }

    // --- FUNCIÓN NUEVA: Lógica de Firebase separada para orden ---
    private void obtenerYGuardarTokenFCM(String emailUsuario) {
        FirebaseMessaging.getInstance().getToken()
                .addOnCompleteListener(new OnCompleteListener<String>() {
                    @Override
                    public void onComplete(Task<String> task) {
                        if (!task.isSuccessful()) {
                            Log.w("FCM", "Falló la obtención del token", task.getException());
                            return;
                        }

                        // 1. Obtener el nuevo token (El número de casilla postal)
                        String token = task.getResult();

                        // 2. Mostrarlo en consola para depuración (opcional)
                        Log.d("TOKEN_ACTUAL", token);

                        // 3. ENVIAR AL SERVIDOR
                        // Usamos el método que creamos en AutomotoraService
                        autoService.actualizarTokenFCM(emailUsuario, token);
                    }
                });
    }

    private void guardarSesionLocal(String nombre, String rol, String email) {
        SharedPreferences prefs = getSharedPreferences("MiauPrefs", MODE_PRIVATE);
        prefs.edit()
                .putBoolean("isLogged", true)
                .putString("nombre", nombre)
                .putString("rol", rol)
                .putString("email", email) // Guardamos email por si necesitamos actualizar token luego
                .apply();
    }

    private void irAlDashboard() {
        Intent intent = new Intent(MainActivity.this, MenuActivity.class);
        startActivity(intent);
        finish();
    }
}