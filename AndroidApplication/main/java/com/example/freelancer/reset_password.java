package com.example.freelancer;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class reset_password extends AppCompatActivity {
    EditText inEmail;
    TextView resendCode;
    Button sendCode,goBack,goProfile,goLogOut,goSearch;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.reset_password);
        inEmail=(EditText) findViewById(R.id.email);
        resendCode=(TextView) findViewById(R.id.resend);
        sendCode=(Button) findViewById(R.id.send_code);
        goBack=(Button) findViewById(R.id.backIcon);
        goProfile=(Button) findViewById(R.id.profileIcon);
        goSearch=(Button) findViewById(R.id.searchIcon);
        goLogOut=(Button) findViewById(R.id.logoutIcon);
        goBack.setOnClickListener(v->{
            finish();
        });
        goProfile.setOnClickListener(v->{//user can't access system without signing in
            Intent toSignIn=new Intent(reset_password.this,profile.class);
            startActivity(toSignIn);
        });
        goLogOut.setOnClickListener(v->{
            Intent toSignIn=new Intent(reset_password.this,MainActivity.class);
            startActivity(toSignIn);
        });
        goSearch.setOnClickListener(v->{
            Intent toSignIn=new Intent(reset_password.this,MainActivity.class);
            startActivity(toSignIn);
        });
    }
}