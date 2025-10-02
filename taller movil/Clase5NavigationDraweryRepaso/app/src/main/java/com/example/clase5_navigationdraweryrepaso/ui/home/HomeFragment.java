package com.example.clase5_navigationdraweryrepaso.ui.home;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.example.clase5_navigationdraweryrepaso.ListaTareasActivity;
import com.example.clase5_navigationdraweryrepaso.databinding.FragmentHomeBinding;
import com.example.clase5_navigationdraweryrepaso.R;

public class HomeFragment extends Fragment {

    private FragmentHomeBinding binding;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        HomeViewModel homeViewModel =
                new ViewModelProvider(this).get(HomeViewModel.class);

        View root = inflater.inflate(R.layout.fragment_home, container, false);

        Button btnVerTareas = root.findViewById(R.id.btnVerTareas);
        btnVerTareas.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(getActivity(), ListaTareasActivity.class);
                startActivity(intent);
            }
        });
        return root;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}