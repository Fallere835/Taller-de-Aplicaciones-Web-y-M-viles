package com.example.automotora.adapter;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.example.automotora.R;
import com.example.automotora.model.Factura;
import java.util.List;

public class FacturaAdapter extends RecyclerView.Adapter<FacturaAdapter.ViewHolder> {

    private List<Factura> lista;
    private OnItemClickListener listener;

    public interface OnItemClickListener {
        void onCompartirClick(Factura factura);
    }

    public FacturaAdapter(List<Factura> lista, OnItemClickListener listener) {
        this.lista = lista;
        this.listener = listener;
    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_factura, parent, false);
        return new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        Factura f = lista.get(position);
        holder.tvId.setText("Factura #" + f.getId());
        holder.tvFecha.setText(f.getFecha());
        holder.tvMonto.setText("$" + f.getMonto());

        holder.btnCompartir.setOnClickListener(v -> listener.onCompartirClick(f));
    }

    @Override
    public int getItemCount() { return lista.size(); }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        TextView tvId, tvFecha, tvMonto;
        Button btnCompartir;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            tvId = itemView.findViewById(R.id.tvFacturaId);
            tvFecha = itemView.findViewById(R.id.tvFecha);
            tvMonto = itemView.findViewById(R.id.tvMonto);
            btnCompartir = itemView.findViewById(R.id.btnCompartir);
        }
    }
}