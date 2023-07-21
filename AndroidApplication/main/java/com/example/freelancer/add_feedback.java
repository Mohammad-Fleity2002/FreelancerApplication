package com.example.freelancer;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class add_feedback extends AppCompatActivity {
    TextView service_area,service_type,freelancer_name,freelancer_phoneNb,freelancer_email
            ,service_star_1,service_star_2,service_star_3,service_star_4,service_star_5,service_no_rate;
    private static TextView star_1,star_2,star_3,star_4,star_5;
    private static TextView empty_star_1,empty_star_2,empty_star_3,empty_star_4,empty_star_5;
    Button goBack,goProfile,goLogOut,goSearch;
    private static int rate=0,back=0;
    EditText inFeedback;
    RelativeLayout stars;
    TextView postFeedback,resetFeedback,error;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.add_feedback);
        back=0;
        inFeedback=(EditText) findViewById(R.id.feedback);
        postFeedback= findViewById(R.id.post_feedback);
        postFeedback.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                RequestQueue queue = Volley.newRequestQueue(add_feedback.this);
                String url = LinkSetting.getUrl_add_feedback();
                StringRequest req = new StringRequest(
                        Request.Method.POST, url, new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject js = new JSONObject(response);
                            String status = js.getString("status");
                            String message = js.getString("message");
                            if (status.equals("failed")) {
                                error.setVisibility(View.VISIBLE);
                                error.setText(message);
                            } else {
                                finish();
                            }
                        } catch (JSONException e) {

                        }
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError err) {
                        error.setVisibility(View.VISIBLE);
                        error.setText(err.toString());
                    }
                }) {
                    protected Map<String, String> getParams() {
                        Map<String, String> paramV = new HashMap<>();
                        paramV.put("feedback_desc",inFeedback.getText().toString().trim());
                        paramV.put("user_id", MainActivity.USER.getId().toString());
                        paramV.put("service_id",search.chosenService.getService_id());
                        paramV.put("rate", String.valueOf(rate));
                        return paramV;
                    }
                };
                queue.add(req);

            }
        });
        resetFeedback= findViewById(R.id.reset_feedback);
        resetFeedback.setOnClickListener(v -> finish());

        star_1=(TextView) findViewById(R.id.fullStar1);
        star_2=(TextView) findViewById(R.id.fullStar2);
        star_3=(TextView) findViewById(R.id.fullStar3);
        star_4=(TextView) findViewById(R.id.fullStar4);
        star_5=(TextView) findViewById(R.id.fullStar5);
        empty_star_1=(TextView) findViewById(R.id.emptyStar1);
        empty_star_2=(TextView) findViewById(R.id.emptyStar2);
        empty_star_3=(TextView) findViewById(R.id.emptyStar3);
        empty_star_4=(TextView) findViewById(R.id.emptyStar4);
        empty_star_5=(TextView) findViewById(R.id.emptyStar5);
        empty_star_1.setOnClickListener(v -> upRate(1));
        empty_star_2.setOnClickListener(v -> upRate(2));
        empty_star_3.setOnClickListener(v -> upRate(3));
        empty_star_4.setOnClickListener(v -> upRate(4));
        empty_star_5.setOnClickListener(v -> upRate(5));
        //service info
        service_area=findViewById(R.id.service_area);
        service_type=findViewById(R.id.service_type);
        freelancer_name=findViewById(R.id.freelancerName);
        freelancer_email=findViewById(R.id.freelancerEmail);
        freelancer_phoneNb=findViewById(R.id.freelancerPhoneNb);

        service_star_1=findViewById(R.id.star1);
        service_star_2=findViewById(R.id.star2);
        service_star_3=findViewById(R.id.star3);
        service_star_4=findViewById(R.id.star4);
        service_star_5=findViewById(R.id.star5);
        service_star_1.setVisibility(View.INVISIBLE);
        service_star_2.setVisibility(View.INVISIBLE);
        service_star_3.setVisibility(View.INVISIBLE);
        service_star_4.setVisibility(View.INVISIBLE);
        service_star_5.setVisibility(View.INVISIBLE);
        stars=findViewById(R.id.myRate);
        stars.setVisibility(View.INVISIBLE);
        service_no_rate=findViewById(R.id.no_rate);

        freelancer_name.setText(search.chosenService.getProvider().getName());
        freelancer_email.setText(search.chosenService.getProvider().getEmail());
        freelancer_phoneNb.setText(search.chosenService.getProvider().getPhoneNumber());

        service_type.setText(loading.SERVICES.get(search.chosenService.getService_code_type()));
        service_area.setText(loading.AREAS.get(search.chosenService.getService_code_area()));
        float f=Float.valueOf(search.chosenService.getService_average_rate());
        if(f<1){
            service_no_rate.setVisibility(View.VISIBLE);
        }else{
            if(f-->=1){
                stars.setVisibility(View.VISIBLE);
                service_star_1.setVisibility(View.VISIBLE);
            }
            if(f-->=1){
                service_star_2.setVisibility(View.VISIBLE);
            }
            if(f-->=1){
                service_star_3.setVisibility(View.VISIBLE);
            }
            if(f-->=1){
                service_star_4.setVisibility(View.VISIBLE);
            }
            if(f-->=1){
                service_star_5.setVisibility(View.VISIBLE);
            }
        }

        //buttons
        error=(TextView)findViewById(R.id.error);
        goBack=(Button) findViewById(R.id.backIcon);
        goProfile=(Button) findViewById(R.id.profileIcon);
        goSearch=(Button) findViewById(R.id.searchIcon);
        goLogOut=(Button) findViewById(R.id.logoutIcon);
        goBack.setOnClickListener(v-> finish());
        goProfile.setOnClickListener(v->{
            Intent toProfile=new Intent(add_feedback.this,profile.class);
            back=0;
            startActivity(toProfile);
        });
        goSearch.setOnClickListener(v->{
            back=0;
            Intent toSearch=new Intent(add_feedback.this,search.class);
            startActivity(toSearch);
        });
        goLogOut.setOnClickListener(v -> {
            if(back==0){
                Toast.makeText(add_feedback.this,"click again to logOut",Toast.LENGTH_SHORT).show();
            }else {
                Intent toLogOut = new Intent(add_feedback.this, logout.class);
                startActivity(toLogOut);
            }
            back++;
        });

    }
    private static void upRate(int i){
        back=0;
        rate++;
        switch (i){
            case 1:
                empty_star_1.setVisibility(View.INVISIBLE);
                empty_star_1.setClickable(false);
                star_1.setClickable(true);
                star_1.setVisibility(View.VISIBLE);
                star_1.setOnClickListener(v -> downRate(1));
                return;
            case 2:
                empty_star_2.setVisibility(View.INVISIBLE);
                empty_star_2.setClickable(false);
                star_2.setClickable(true);
                star_2.setVisibility(View.VISIBLE);
                star_2.setOnClickListener(v -> downRate(2));
                return;
            case 3:
                empty_star_3.setVisibility(View.INVISIBLE);
                empty_star_3.setClickable(false);
                star_3.setClickable(true);
                star_3.setVisibility(View.VISIBLE);
                star_3.setOnClickListener(v -> downRate(3));
                return;
            case 4:
                empty_star_4.setVisibility(View.INVISIBLE);
                empty_star_4.setClickable(false);
                star_4.setClickable(true);
                star_4.setVisibility(View.VISIBLE);
                star_4.setOnClickListener(v -> downRate(4));
                return;
            case 5:
                empty_star_5.setVisibility(View.INVISIBLE);
                empty_star_5.setClickable(false);
                star_5.setClickable(true);
                star_5.setVisibility(View.VISIBLE);
                star_5.setOnClickListener(v -> downRate(5));
                return;
        }
    }
    private static void downRate(int j){
        back=0;
        rate--;
        switch (j){
            case 1:
                star_1.setVisibility(View.INVISIBLE);
                star_1.setClickable(false);
                empty_star_1.setVisibility(View.VISIBLE);
                empty_star_1.setClickable(true);
                empty_star_1.setOnClickListener(v->upRate(1));
                return;
            case 2:
                star_2.setVisibility(View.INVISIBLE);
                star_2.setClickable(false);
                empty_star_2.setVisibility(View.VISIBLE);
                empty_star_2.setClickable(true);
                empty_star_2.setOnClickListener(v->upRate(2));
                return;
            case 3:
                star_3.setVisibility(View.INVISIBLE);
                star_3.setClickable(false);
                empty_star_3.setVisibility(View.VISIBLE);
                empty_star_3.setClickable(true);
                empty_star_3.setOnClickListener(v->upRate(3));
                return;
            case 4:
                star_4.setVisibility(View.INVISIBLE);
                star_4.setClickable(false);
                empty_star_4.setVisibility(View.VISIBLE);
                empty_star_4.setClickable(true);
                empty_star_4.setOnClickListener(v->upRate(4));
                return;
            case 5:
                star_5.setVisibility(View.INVISIBLE);
                star_5.setClickable(false);
                empty_star_5.setVisibility(View.VISIBLE);
                empty_star_5.setClickable(true);
                empty_star_5.setOnClickListener(v->upRate(5));
                return;
        }

    }
}