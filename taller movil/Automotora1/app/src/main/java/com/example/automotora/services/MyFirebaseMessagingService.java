package com.example.automotora.services;

import android.app.NotificationChannel;
import android.app.NotificationManager;
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
        // Aquí enviaríamos el token a nuestro backend PHP para guardarlo en la tabla usuarios.
        // Por ahora solo lo mostramos en Logcat para probar desde Firebase Console.
        Log.d("FCM_TOKEN", "Mi token es: " + token);
    }

    @Override
    public void onMessageReceived(RemoteMessage remoteMessage) {
        super.onMessageReceived(remoteMessage);

        // Si el mensaje trae notificación (Título y Cuerpo)
        if (remoteMessage.getNotification() != null) {
            mostrarNotificacion(
                    remoteMessage.getNotification().getTitle(),
                    remoteMessage.getNotification().getBody()
            );
        }
    }

    private void mostrarNotificacion(String titulo, String cuerpo) {
        String channelId = "miau_channel";

        // Crear canal (Obligatorio en Android 8+)
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            NotificationChannel channel = new NotificationChannel(
                    channelId, "Notificaciones Importantes", NotificationManager.IMPORTANCE_HIGH);
            getSystemService(NotificationManager.class).createNotificationChannel(channel);
        }

        NotificationCompat.Builder builder = new NotificationCompat.Builder(this, channelId)
                .setSmallIcon(R.drawable.ic_launcher_foreground) // Asegurar que existe icono
                .setContentTitle(titulo)
                .setContentText(cuerpo)
                .setPriority(NotificationCompat.PRIORITY_HIGH)
                .setAutoCancel(true);

        NotificationManagerCompat.from(this).notify(1, builder.build());
    }
}