package com.example.clase3;

public class Vehiculo {
   private String marca;
   private String modelo;
   private String patente;

   public Vehiculo(String marca, String modelo, String patente){
       this.marca=marca;
       this.modelo=modelo;
       this.patente=patente;
   }
   public String getMarca(){
       return marca;
   }
   public String getModelo(){
       return modelo;
   }
   public String getPatente(){
       return patente;
   }
   @Override
    public String toString(){
       return marca+" "+modelo;
   }
}


