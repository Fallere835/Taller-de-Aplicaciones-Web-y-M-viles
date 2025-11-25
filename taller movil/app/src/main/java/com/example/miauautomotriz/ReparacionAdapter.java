package com.example.miauautomotriz;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.List;

public class ReparacionAdapter extends RecyclerView.Adapter<ReparacionAdapter.ViewHolder> {

    private List<Reparacion> reparaciones;

    public ReparacionAdapter(List<Reparacion> reparaciones) {
        this.reparaciones = reparaciones;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_reparacion, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        Reparacion reparacion = reparaciones.get(position);
        holder.txtNumero.setText(reparacion.getNumero());
        holder.txtFecha.setText(reparacion.getFecha());
        holder.txtEstado.setText(reparacion.getEstado());
        holder.txtVehiculo.setText(reparacion.getVehiculo());
        holder.txtTotal.setText(String.format("$%.2f", reparacion.getTotal()));
    }

    @Override
    public int getItemCount() {
        return reparaciones.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView txtNumero, txtFecha, txtEstado, txtVehiculo, txtTotal;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            txtNumero = itemView.findViewById(R.id.txtNumero);
            txtFecha = itemView.findViewById(R.id.txtFecha);
            txtEstado = itemView.findViewById(R.id.txtEstado);
            txtVehiculo = itemView.findViewById(R.id.txtVehiculo);
            txtTotal = itemView.findViewById(R.id.txtTotal);
        }
    }
}
