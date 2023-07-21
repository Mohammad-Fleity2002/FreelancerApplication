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

public class my_services extends AppCompatActivity {
    Button goBack,goProfile,goLogOut,goSearch;
    private int displayed_services=0,realDisplayedServices=0,back=0;
    private static ArrayList<Services> servicesArray=new ArrayList<>();

    TextView goOfferNewService,goEditProfile;
    TextView user_name,user_phone_nb,user_email,title_service_1,title_service_2,area_service_1,area_service_2
            ,location_service_1,location_service_2;
    TextView delete_1,edit_1,delete_2,edit_2;
    private static String[] areas=loading.AREAS.values().toArray(new String[0]);
    private final static String[] idAreas=loading.AREAS.keySet().toArray(new String[0]);

    private static String[] serviceTypes=loading.SERVICES.values().toArray(new String[0]);
    private static String[] idServices=loading.SERVICES.keySet().toArray(new String[0]);

    private static TextView prev, next,error;
    private static RelativeLayout service_1,service_2;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.my_services);
        back=0;
        user_name=findViewById(R.id.myName);
        user_name.setText(MainActivity.USER.getName());

        user_email=findViewById(R.id.myEmail);
        user_email.setText(MainActivity.USER.getEmail());

        user_phone_nb=findViewById(R.id.myPhoneNb);
        user_phone_nb.setText(MainActivity.USER.getPhoneNumber());

        error=findViewById(R.id.error);
        service_1=findViewById(R.id.myService1);
        service_2=findViewById(R.id.myService2);

        title_service_1=findViewById(R.id.titleService1);
        title_service_2=findViewById(R.id.titleService2);
        area_service_1=findViewById(R.id.areaService1);
        area_service_2=findViewById(R.id.areaService2);
        location_service_1=findViewById(R.id.locationService1);
        location_service_2=findViewById(R.id.locationService2);
        delete_1=findViewById(R.id.delete_1);
        edit_1=findViewById(R.id.edit_service1);
        delete_2=findViewById(R.id.delete_2);
        edit_2=findViewById(R.id.edit_Service2);

        prev=findViewById(R.id.previous);
        prev.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(servicesArray.size()!=0){
                    if(displayed_services>1) {
                        displayed_services -=realDisplayedServices+2;
                        display();
                    }
                }
            }
        });

        next=findViewById(R.id.next);
        next.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (servicesArray.size()!=0) {
                    if(displayed_services<servicesArray.size()) {
                        display();
                    }
                }
            }
        });

        //button
        goBack=(Button) findViewById(R.id.backIcon);
        goProfile=(Button) findViewById(R.id.profileIcon);
        goSearch=(Button) findViewById(R.id.searchIcon);
        goLogOut=(Button) findViewById(R.id.logoutIcon);
        goOfferNewService=(TextView)findViewById(R.id.offerNewService);
        goEditProfile=(TextView) findViewById(R.id.edit_profile);

        goOfferNewService.setOnClickListener(v->{
            Intent toAddService=new Intent(my_services.this,add_service.class);
            startActivity(toAddService);
        });
        goEditProfile.setOnClickListener(v-> {
            Intent toProfile = new Intent(my_services.this, profile.class);
            startActivity(toProfile);
        });
        goBack.setOnClickListener(v->{
            finish();
        });
        goLogOut.setOnClickListener(v -> {
            if(back==0){
                Toast.makeText(my_services.this,"click again to logOut",Toast.LENGTH_SHORT).show();
            }else {
                Intent toLogOut = new Intent(my_services.this, logout.class);
                startActivity(toLogOut);
            }
            back++;
        });

        goProfile.setOnClickListener(v->{
            Intent toProfile=new Intent(my_services.this,profile.class);
            startActivity(toProfile);
        });
        goSearch.setOnClickListener(v->{

        });
        RequestQueue queue = Volley.newRequestQueue(my_services.this);
        String url = LinkSetting.getUrl_my_services();
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
                        servicesArray.clear();
                        displayed_services=0;
                        error.setText("");
                        error.setVisibility(View.INVISIBLE);
                        String nbOfServices=js.getString("nbOfServices");
                        JSONObject services=js.getJSONObject("services");
                        float f= Float.valueOf(nbOfServices);
                        for(int i=0;i<f;i++){
                            String service_title=services.getString("service_title"+i);
                            String service_id=services.getString("sid"+i);
                            String service_code_area=services.getString("code_area"+i);
                            String service_code_type=services.getString("code_type"+i);
                            String service_description=services.getString("service_description"+i);
                            String service_location=services.getString("service_location"+i);
                            String add_date=services.getString("add_date"+i);
                            servicesArray.add(new Services(
                                    MainActivity.USER,service_id,service_title,service_description,service_code_area,
                                    service_code_type,service_location,add_date
                            ));
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
                paramV.put("user_id", MainActivity.USER.getId());
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
        Services tmp;
        if(displayed_services<servicesArray.size()) {
            service_1.setVisibility(View.VISIBLE);
            realDisplayedServices++;
            tmp = servicesArray.get(displayed_services++);
            title_service_1.setText(tmp.getService_title());
            area_service_1.setText(loading.AREAS.get(tmp.getService_code_area()));
        }
        if(displayed_services<servicesArray.size()) {
            service_2.setVisibility(View.VISIBLE);
            tmp = servicesArray.get(displayed_services++);
            realDisplayedServices++;
            title_service_2.setText(tmp.getService_title());
            area_service_2.setText(loading.AREAS.get(tmp.getService_code_area()));
        }
        if(displayed_services==servicesArray.size()){
            next.setVisibility(View.INVISIBLE);
            next.setClickable(false);
        }
        if(displayed_services<=2){
            prev.setClickable(false);
            prev.setVisibility(View.INVISIBLE);
        }
    }
    private void clean(){
        realDisplayedServices=0;
        back=0;
        prev.setVisibility(View.INVISIBLE);
        next.setVisibility(View.INVISIBLE);
        prev.setClickable(false);
        next.setClickable(false);
        service_1.setVisibility(View.INVISIBLE);
        service_2.setVisibility(View.INVISIBLE);
    }

}