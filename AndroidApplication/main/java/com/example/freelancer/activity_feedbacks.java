package com.example.freelancer;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
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

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class activity_feedbacks extends AppCompatActivity {
    Button goBack,goProfile,goLogOut,goSearch;
    private static int back=0;
    TextView service_area,service_type,freelancer_name,freelancer_phoneNb,freelancer_email
            ,service_star_1,service_star_2,service_star_3,service_star_4,service_star_5,service_no_rate;
    TextView feedback_1_desc,feedback_2_desc,customer_1_name,customer_2_name,customer_1_email,customer_2_email
            ,feedback_1_star_1,feedback_1_star_2,feedback_1_star_3,feedback_1_star_4,feedback_1_star_5
            ,feedback_2_star_1,feedback_2_star_2,feedback_2_star_3,feedback_2_star_4,feedback_2_star_5;
    RelativeLayout feedback_1,feedback_2,stars,feedback_1_rate,feedback_2_rate;
    private static ArrayList<Feedbacks> feedbacksList=new ArrayList<>();
    private static int displayedFeedbacks=0,realDisplayedFeedbacks=0;
    private static String[] areas=loading.AREAS.values().toArray(new String[0]);
    private final static String[] idAreas=loading.AREAS.keySet().toArray(new String[0]);

    private static String[] serviceTypes=loading.SERVICES.values().toArray(new String[0]);
    private static String[] idServices=loading.SERVICES.keySet().toArray(new String[0]);

    private static TextView error,prev,next,addFeedback;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.feedbacks);
        back=0;
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
        //feedbacks info
        feedback_1=findViewById(R.id.feedback1);
        feedback_2=findViewById(R.id.feedback2);
        feedback_1_desc=findViewById(R.id.feedback_desc_1);
        feedback_2_desc=findViewById(R.id.feedback_desc_2);
        customer_1_email=findViewById(R.id.customerEmail1);
        customer_2_email=findViewById(R.id.customerEmail2);
        customer_1_name=findViewById(R.id.customerName1);
        customer_2_name=findViewById(R.id.customerName2);
        feedback_1_rate=findViewById(R.id.rate1);
        feedback_2_rate=findViewById(R.id.rate2);

        feedback_1_star_1=findViewById(R.id.star11);
        feedback_1_star_2=findViewById(R.id.star12);
        feedback_1_star_3=findViewById(R.id.star13);
        feedback_1_star_4=findViewById(R.id.star14);
        feedback_1_star_5=findViewById(R.id.star15);

        feedback_2_star_1=findViewById(R.id.star21);
        feedback_2_star_2=findViewById(R.id.star22);
        feedback_2_star_3=findViewById(R.id.star23);
        feedback_2_star_4=findViewById(R.id.star24);
        feedback_2_star_5=findViewById(R.id.star25);

        feedback_1_star_1.setVisibility(View.INVISIBLE);
        feedback_1_star_2.setVisibility(View.INVISIBLE);
        feedback_1_star_3.setVisibility(View.INVISIBLE);
        feedback_1_star_4.setVisibility(View.INVISIBLE);
        feedback_1_star_5.setVisibility(View.INVISIBLE);
        feedback_1_rate.setVisibility(View.INVISIBLE);
        feedback_2_rate.setVisibility(View.INVISIBLE);
        feedback_2_star_1.setVisibility(View.INVISIBLE);
        feedback_2_star_2.setVisibility(View.INVISIBLE);
        feedback_2_star_3.setVisibility(View.INVISIBLE);
        feedback_2_star_4.setVisibility(View.INVISIBLE);
        feedback_2_star_5.setVisibility(View.INVISIBLE);

        //Button
        //buttons and spinners
        prev=findViewById(R.id.previous);
        next=findViewById(R.id.next);
        next.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (feedbacksList.size()!=0) {
                    if(displayedFeedbacks<feedbacksList.size()) {
                        display();
                    }
                }
            }
        });
        prev.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(feedbacksList.size()!=0){
                    if(displayedFeedbacks>1) {
                        displayedFeedbacks -=realDisplayedFeedbacks+2;
                        display();
                    }
                }
            }
        });
        next=findViewById(R.id.next);
        error=(TextView)findViewById(R.id.error);
        goBack=(Button) findViewById(R.id.backIcon);
        goProfile=(Button) findViewById(R.id.profileIcon);
        goSearch=(Button) findViewById(R.id.searchIcon);
        goLogOut=(Button) findViewById(R.id.logoutIcon);
        addFeedback=findViewById(R.id.newFeedback);
        addFeedback.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent toAddFeedback=new Intent(activity_feedbacks.this,add_feedback.class);
                startActivity(toAddFeedback);
            }
        });
        goBack.setOnClickListener(v->{
            finish();
        });
        goProfile.setOnClickListener(v->{
            Intent toProfile=new Intent(activity_feedbacks.this,profile.class);
            startActivity(toProfile);
        });
        goSearch.setOnClickListener(v->{
            Intent toSearch=new Intent(activity_feedbacks.this,search.class);
            startActivity(toSearch);
        });
        goLogOut.setOnClickListener(v -> {
            if(back==0){
                Toast.makeText(activity_feedbacks.this,"click again to logOut",Toast.LENGTH_SHORT).show();
            }else {
                Intent toLogOut = new Intent(activity_feedbacks.this, logout.class);
                startActivity(toLogOut);
            }
            back++;
        });

        //Request
        RequestQueue queue = Volley.newRequestQueue(activity_feedbacks.this);
        String url = LinkSetting.getUrl_activity_services();
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
                        clean();
                    } else {
                        feedbacksList.clear();
                        displayedFeedbacks=0;
                        error.setText("");
                        error.setVisibility(View.INVISIBLE);
                        String nbOfServices=js.getString("nbOfFeedbacks");
                        JSONObject customersObj=js.getJSONObject("customers");
                        JSONObject feedbacksObj=js.getJSONObject("feedbacks");
                        float f= Float.valueOf(nbOfServices);
                        for(int i=0;i<f;i++){
                            String freelancer_id=customersObj.getString("user_id"+i);
                            String freelancer_name=customersObj.getString("user_name"+i);
                            String freelancer_phone_nb=customersObj.getString("user_phone_number"+i);
                            String freelancer_email=customersObj.getString("user_email"+i);
                            String freelancer_birthdate=customersObj.getString("user_birthdate"+i);
                            String freelancer_join_date=customersObj.getString("user_join_date"+i);
                            String freelancer_code_gender=customersObj.getString("user_code_gender"+i);
                            String freelancer_code_area=customersObj.getString("user_code_area"+i);
                            String freelancer_code_role=customersObj.getString("user_code_role"+i);
                            Users cust=new Users(
                                    freelancer_id,freelancer_name,freelancer_email,freelancer_join_date,freelancer_birthdate,
                                    freelancer_phone_nb,freelancer_code_area,freelancer_code_role,freelancer_code_gender
                            );
                            String feedback_desc=feedbacksObj.getString("feedback_description"+i);
                            String feedback_id=feedbacksObj.getString("feedback_id"+i);
                            String feedback_rate=feedbacksObj.getString("feedback_rate"+i);
                            String feedback_date=feedbacksObj.getString("feedback_date"+i);
                            feedbacksList.add(new Feedbacks(feedback_id,feedback_desc,feedback_rate,cust,search.chosenService));
                        }
                        display();
                    }
                } catch (JSONException e) {
                    error.setVisibility(View.VISIBLE);
                    error.setText(e.getMessage());
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
                paramV.put("service_id", search.chosenService.getService_id());
                return paramV;
            }
        };
        queue.add(req);
    }
    private void display(){
        clean();
        prev.setClickable(true);
        next.setClickable(true);
        next.setVisibility(View.VISIBLE);
        prev.setVisibility(View.VISIBLE);
        Feedbacks tmp;
        float avg;
        if(displayedFeedbacks<feedbacksList.size()) {
            feedback_1.setVisibility(View.VISIBLE);
            realDisplayedFeedbacks++;
            tmp = feedbacksList.get(displayedFeedbacks++);
            customer_1_name.setText(tmp.getCustomer().getName());
            customer_1_email.setText(tmp.getCustomer().getEmail());

            feedback_1_desc.setText(tmp.getFeedback_description());
            avg = Float.valueOf(tmp.getFeedback_rate());//e.g: 3
            if ((avg--) >= 1) {
                feedback_1_star_1.setVisibility(View.VISIBLE);
                feedback_1_rate.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                feedback_1_star_2.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                feedback_1_star_3.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                feedback_1_star_4.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                feedback_1_star_5.setVisibility(View.VISIBLE);
            }
        }
        if(displayedFeedbacks<feedbacksList.size()) {
            feedback_2.setVisibility(View.VISIBLE);
            tmp = feedbacksList.get(displayedFeedbacks++);
            realDisplayedFeedbacks++;
            customer_2_name.setText(tmp.getCustomer().getName());
            customer_2_email.setText(tmp.getCustomer().getEmail());

            feedback_2_desc.setText(tmp.getFeedback_description());
            avg = Float.valueOf(tmp.getFeedback_rate());//e.g: 3
            if ((avg--) >= 1) {
                feedback_2_star_1.setVisibility(View.VISIBLE);
                feedback_2_rate.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                feedback_2_star_2.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                feedback_2_star_3.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                feedback_2_star_4.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                feedback_2_star_5.setVisibility(View.VISIBLE);
            }
        }
        if(displayedFeedbacks==feedbacksList.size()){
            next.setVisibility(View.INVISIBLE);
            next.setClickable(false);
        }
        if(displayedFeedbacks<=2){
            prev.setClickable(false);
            prev.setVisibility(View.INVISIBLE);
        }
//        error.setText(displayedFeedbacks);
//        error.setVisibility(View.VISIBLE);
    }
    private void clean(){
        realDisplayedFeedbacks=0;
        back=0;
        prev.setVisibility(View.INVISIBLE);
        next.setVisibility(View.INVISIBLE);
        prev.setClickable(false);
        next.setClickable(false);
        feedback_1.setVisibility(View.INVISIBLE);
        feedback_2.setVisibility(View.INVISIBLE);
        feedback_1_star_1.setVisibility(View.INVISIBLE);
        feedback_1_star_2.setVisibility(View.INVISIBLE);
        feedback_1_star_3.setVisibility(View.INVISIBLE);
        feedback_1_star_4.setVisibility(View.INVISIBLE);
        feedback_1_star_5.setVisibility(View.INVISIBLE);

        feedback_2_star_1.setVisibility(View.INVISIBLE);
        feedback_2_star_2.setVisibility(View.INVISIBLE);
        feedback_2_star_3.setVisibility(View.INVISIBLE);
        feedback_2_star_4.setVisibility(View.INVISIBLE);
        feedback_2_star_5.setVisibility(View.INVISIBLE);

    }
}