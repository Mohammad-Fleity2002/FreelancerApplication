package com.example.freelancer;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class profile extends AppCompatActivity {
    Button goBack,goProfile,goLogOut,goSearch,goMyServices;
    TextView userName,userBirthdate,userGender,userEmail,userArea,goEditProfile,userPhone,userJoinDate;
    private static int id,back=0;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.profile);
        back=0;
        //buttons
        goBack=(Button) findViewById(R.id.backIcon);
        goProfile=(Button) findViewById(R.id.profileIcon);
        goSearch=(Button) findViewById(R.id.searchIcon);
        goLogOut=(Button) findViewById(R.id.logoutIcon);
        goEditProfile=(TextView) findViewById(R.id.edit_profile);
        //information fields
        userName=(TextView) findViewById(R.id.user_name);
        userEmail=(TextView) findViewById(R.id.user_email);
        userBirthdate=(TextView) findViewById(R.id.user_dateOfBirth);
        userPhone=(TextView) findViewById(R.id.user_phone);
        userGender=(TextView) findViewById(R.id.user_gender);
        userArea=(TextView) findViewById(R.id.user_location);
        goMyServices=(Button)findViewById(R.id.myServices);
        userJoinDate=findViewById(R.id.user_join_date);
        goBack.setOnClickListener(v->{
            finish();
        });

        goProfile.setOnClickListener(v->{
            back=0;
            Toast.makeText(profile.this,"You're already on the profile page",Toast.LENGTH_LONG).show();
        });
        if(loading.ROLES.get(MainActivity.USER.getCode_role()).equals("freelancer")){
            goMyServices.setOnClickListener(v->{
                back=0;
                Intent toMyServices=new Intent(profile.this,my_services.class);
                startActivity(toMyServices);
            });
        }else{
            goMyServices.setVisibility(View.INVISIBLE);
            goMyServices.setClickable(false);
        }
        goSearch.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                back=0;
                Intent toSearch=new Intent(profile.this,search.class);
                startActivity(toSearch);
            }
        });
        goLogOut.setOnClickListener(v -> {
            if(back==0){
                Toast.makeText(profile.this,"click again to logOut",Toast.LENGTH_SHORT).show();
            }else {
                Intent toLogOut = new Intent(profile.this, logout.class);
                startActivity(toLogOut);
            }
            back++;
        });

        userGender.setText(loading.GENDERS.get(MainActivity.USER.getCode_gender()));
        userArea.setText(loading.AREAS.get(MainActivity.USER.getCode_area()));
        userPhone.setText(MainActivity.USER.getPhoneNumber());
        userEmail.setText(MainActivity.USER.getEmail());
        userName.setText(MainActivity.USER.getName());
        userJoinDate.setText(MainActivity.USER.getJoinDate());
        userBirthdate.setText(MainActivity.USER.getBirthdate());

    }
}