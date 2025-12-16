package com.example.automotora.services;

import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.content.Context;
import android.content.SharedPreferences;
import android.os.Build;
import android.util.Log;
import androidx.core.app.NotificationCompat;
import androidx.core.app.NotificationManagerCompat;
import com.google.firebase.messaging.FirebaseMessagingService;
import com.google.firebase.messaging.RemoteMessage;
import com.example.automotora.R;

public class MyFirebaseMessagingService extends FirebaseMessagingService {

    @Override
    public void onNewToken(String token) {
        super.onNewToken(token);
        Log.d("FCM_TOKEN", "Nuevo token generado: " + token);

        // 1. Guardar el token localmente siempre (por si no estamos logueados aún)
        guardarTokenLocalmente(token);

        // 2. Verificar si hay un usuario logueado
        SharedPreferences prefs = getSharedPreferences("MiauPrefs", MODE_PRIVATE);
        boolean isLogged = prefs.getBoolean("isLogged", false);
        String userEmail = prefs.getString("email", null); // Asumiendo que guardaste el email al login

        if (isLogged && userEmail != null) {
            // 3. Si está logueado, enviamos al backend INMEDIATAMENTE
            AutomotoraService service = new AutomotoraService(getApplicationContext());
            service.actualizarTokenFCM(userEmail, token);
        }
    }

    private void guardarTokenLocalmente(String token) {
        SharedPreferences prefs = getSharedPreferences("MiauPrefs", MODE_PRIVATE);
        prefs.edit().putString("fcm_token_pendiente", token).apply();
    }

    @Override
    public void onMessageReceived(RemoteMessage remoteMessage) {
        super.onMessageReceived(remoteMessage);
        if (remoteMessage.getNotification() != null) {
            mostrarNotificacion(
                    remoteMessage.getNotification().getTitle(),
                    remoteMessage.getNotification().getBody()
            );
        }
    }
    private void mostrarNotificacion(String titulo, String cuerpo) {
        String channelId = "miau_channel";
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            NotificationChannel channel = new NotificationChannel(
                    channelId, "Avisos Taller", NotificationManager.IMPORTANCE_HIGH);
            getSystemService(NotificationManager.class).createNotificationChannel(channel);
        }

        NotificationCompat.Builder builder = new NotificationCompat.Builder(this, channelId)
                .setSmallIcon(R.drawable.ic_launcher_foreground)
                .setContentTitle(titulo)
                .setContentText(cuerpo)
                .setPriority(NotificationCompat.PRIORITY_HIGH)
                .setAutoCancel(true);

        try {
            NotificationManagerCompat.from(this).notify(1, builder.build());
        } catch (SecurityException e) {
            Log.e("FCM", "Falta permiso POST_NOTIFICATIONS en Android 13+");
        }
    }
}