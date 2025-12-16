package com.example.automotora.adapter;

import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.example.automotora.R;
import com.example.automotora.model.Reparacion;
import java.util.List;

public class ReparacionAdapter extends RecyclerView.Adapter<ReparacionAdapter.ViewHolder> {

    private List<Reparacion> lista;
    private OnItemAction listener;

    // Interfaz para comunicar el clic al Activity (sin lógica de negocio aquí)
    public interface OnItemAction {
        void onAprobarClick(int idReparacion);
    }

    public ReparacionAdapter(List<Reparacion> lista, OnItemAction listener) {
        this.lista = lista;
        this.listener = listener;
    }

    public void setLista(List<Reparacion> nuevaLista) {
        this.lista = nuevaLista;
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        // Asegúrate de tener un layout llamado item_reparacion.xml
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_reparacion, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        Reparacion item = lista.get(position);

        holder.tvPatente.setText(item.getPatente());
        holder.tvModelo.setText(item.getModelo());
        holder.tvCosto.setText("$" + item.getCosto());
        holder.tvEstado.setText(item.getEstado());

        // Cambiar color según estado
        if ("listo".equalsIgnoreCase(item.getEstado())) {
            holder.tvEstado.setTextColor(Color.GREEN);
            holder.btnAprobar.setVisibility(View.GONE); // Si ya está listo, no mostrar botón
        } else if ("aprobado_cliente".equalsIgnoreCase(item.getEstado())) {
            holder.tvEstado.setTextColor(Color.BLUE);
            holder.btnAprobar.setVisibility(View.GONE);
        } else {
            holder.tvEstado.setTextColor(Color.RED);
            holder.btnAprobar.setVisibility(View.VISIBLE);
        }

        // Clic en botón Aprobar
        holder.btnAprobar.setOnClickListener(v -> {
            if (listener != null) listener.onAprobarClick(item.getId());
        });
    }

    @Override
    public int getItemCount() {
        return lista.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView tvPatente, tvModelo, tvCosto, tvEstado;
        Button btnAprobar;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            // Asegúrate que estos IDs existan en item_reparacion.xml
            tvPatente = itemView.findViewById(R.id.tvPatente);
            tvModelo = itemView.findViewById(R.id.tvModelo);
            tvCosto = itemView.findViewById(R.id.tvCosto);
            tvEstado = itemView.findViewById(R.id.tvEstado);
            btnAprobar = itemView.findViewById(R.id.btnAprobar);
        }
    }
}