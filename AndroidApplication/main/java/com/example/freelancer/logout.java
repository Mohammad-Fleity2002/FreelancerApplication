package com.example.freelancer;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

public class logout extends AppCompatActivity {
    TextView error;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_logout);
        error=findViewById(R.id.error);
        MainActivity.logOut();
//        error.setText(MainActivity.USER.toString());
        Intent toLogin=new Intent(logout.this,MainActivity.class);
        startActivity(toLogin);

    }
}