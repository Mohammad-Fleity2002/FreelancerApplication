package com.example.freelancer;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

public class activity_service extends AppCompatActivity {
    private final String[] items={"Report","Feedback"};
    Button goBack,goProfile,goLogOut,goSearch;
    private static int back=0;
    TextView freelancer_name,freelancer_email,freelancer_phoneNb,
            service_type,service_area,service_add_date,service_link_location,service_title,service_desc;
    TextView feedbacks;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.service);
        back=0;
        feedbacks=findViewById(R.id.feedbacks);
        goBack=(Button) findViewById(R.id.backIcon);
        goProfile=(Button) findViewById(R.id.profileIcon);
        goSearch=(Button) findViewById(R.id.searchIcon);
        goLogOut=(Button) findViewById(R.id.logoutIcon);
        goBack.setOnClickListener(v -> {
            finish();
        });
        goSearch.setOnClickListener(v -> {
            back=0;
            Intent toSearch=new Intent(activity_service.this,search.class);
            startActivity(toSearch);
        });
        goProfile.setOnClickListener(v -> {
            back=0;
            Intent toProfile=new Intent(activity_service.this,profile.class);
            startActivity(toProfile);
        });
        goLogOut.setOnClickListener(v -> {
            if(back==0){
                Toast.makeText(activity_service.this,"click again to logOut",Toast.LENGTH_SHORT).show();
            }else {
                Intent toLogOut = new Intent(activity_service.this, logout.class);
                startActivity(toLogOut);
            }
            back++;
        });

        //service info
        freelancer_email=findViewById(R.id.freelancer_email);
        freelancer_phoneNb=findViewById(R.id.freelancer_phoneNb);
        freelancer_name=findViewById(R.id.freelancer_name);

        service_link_location=findViewById(R.id.service_link_location);
        service_area=findViewById(R.id.service_area);
        service_type=findViewById(R.id.service_type);
        service_add_date=findViewById(R.id.service_add_date);
        service_title=findViewById(R.id.service_title);
        service_desc=findViewById(R.id.service_description);

        freelancer_name.setText(search.chosenService.getProvider().getName());
        freelancer_email.setText(search.chosenService.getProvider().getEmail());
        freelancer_phoneNb.setText(search.chosenService.getProvider().getPhoneNumber());

        service_title.setText(search.chosenService.getService_title());
        service_area.setText(loading.AREAS.get(search.chosenService.getService_code_area()));
        service_type.setText(loading.SERVICES.get( search.chosenService.getService_code_type()));
        service_desc.setText(search.chosenService.getService_description());
        service_add_date.setText(search.chosenService.getAdd_date());
        service_link_location.setText(search.chosenService.getService_link_location());
        feedbacks.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent toFeedbacks=new Intent(activity_service.this, activity_feedbacks.class);
                startActivity(toFeedbacks);
            }
        });
    }
}