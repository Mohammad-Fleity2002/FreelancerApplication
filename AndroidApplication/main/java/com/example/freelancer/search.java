package com.example.freelancer;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.navigation.NavigationBarView;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class search extends AppCompatActivity {
    Button goBack,goProfile,goLogOut,goSearch;
    Spinner service_type,area;
    public static ArrayList<Services> servicesArray=new ArrayList<>();
    public static Services chosenService;
    private static int back=0;
    private int displayed_services=0,realDisplayedServices=0;
    private RelativeLayout service1,service2;
    private static String code_type;
    private static String code_area;
    private static String[] areas=loading.AREAS.values().toArray(new String[0]);
    private final static String[] idAreas=loading.AREAS.keySet().toArray(new String[0]);

    private static String[] serviceTypes=loading.SERVICES.values().toArray(new String[0]);
    private static String[] idServices=loading.SERVICES.keySet().toArray(new String[0]);
    private static int i=0, counter=0;
    private static TextView
            freelancer_name_1,freelancer_name_2,freelancer_phoneNb_1,freelancer_phoneNb_2,freelancer_email_1,freelancer_email_2
            ,service_area_1,service_area_2,service_1_no_rate,service_2_no_rate,service_title_1,service_title_2;
    //stars
    private static TextView
            service_1_star_1,service_1_star_2,service_1_star_3,service_1_star_4,service_1_star_5,
            service_2_star_1,service_2_star_2,service_2_star_3,service_2_star_4,service_2_star_5;

    private static TextView error,prev,next;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.search);
        //relative layout
        service1=findViewById(R.id.service1);
        service2=findViewById(R.id.service2);
        i++;
        //textViews
        freelancer_name_1=findViewById(R.id.freelancer_name_1);
        freelancer_name_2=findViewById(R.id.freelancer_name_2);
        freelancer_email_1=findViewById(R.id.freelancer_email_1);
        freelancer_email_2=findViewById(R.id.freelancer_email_2);
        freelancer_phoneNb_1=findViewById(R.id.freelancer_phoneNb_1);
        freelancer_phoneNb_2=findViewById(R.id.freelancer_phoneNb_2);
        service_area_1=findViewById(R.id.service_area_1);
        service_area_2=findViewById(R.id.service_area_2);
        service_title_1=findViewById(R.id.service_title_1);
        service_title_2=findViewById(R.id.service_title_2);
        service_1_no_rate=findViewById(R.id.service_1_no_rate);
        service_2_no_rate=findViewById(R.id.service_2_no_rate);
        //stars
        service_1_star_1=findViewById(R.id.service_1_star_1);
        service_1_star_2=findViewById(R.id.service_1_star_2);
        service_1_star_3=findViewById(R.id.service_1_star_3);
        service_1_star_4=findViewById(R.id.service_1_star_4);
        service_1_star_5=findViewById(R.id.service_1_star_5);

        service_2_star_1=findViewById(R.id.service_2_star_1);
        service_2_star_2=findViewById(R.id.service_2_star_2);
        service_2_star_3=findViewById(R.id.service_2_star_3);
        service_2_star_4=findViewById(R.id.service_2_star_4);
        service_2_star_5=findViewById(R.id.service_2_star_5);
        //buttons and spinners
        prev=findViewById(R.id.previous);
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
        //0 at t0
        //search display service 0 then increment to 1
        //display service 1 then increment to 2
        //click is display service 2 then increment to 3
        //display service 3 then increment to 4
        //click display service 4 then increment 5
        //display service 5 then increment 6
        //click back 4-3=1 display 1 increment
        //display 2 increment 3
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
        error=(TextView)findViewById(R.id.error);
        goBack=(Button) findViewById(R.id.backIcon);
        goProfile=(Button) findViewById(R.id.profileIcon);
        goSearch=(Button) findViewById(R.id.searchIcon);
        goLogOut=(Button) findViewById(R.id.logoutIcon);
        service_type=(Spinner) findViewById(R.id.serviceTypes);
        area=(Spinner) findViewById(R.id.serviceAreas);
        ArrayAdapter<String> adapterArea=new ArrayAdapter<>(search.this,android.R.layout.simple_spinner_item,areas);
        ArrayAdapter<String> adapterServices=new ArrayAdapter<>(search.this,android.R.layout.simple_spinner_item,serviceTypes);
        adapterArea.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        adapterServices.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        service_type.setAdapter(adapterServices);
        area.setAdapter(adapterArea);
        area.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                for(String idArea:idAreas) {
                    if (loading.AREAS.get(idArea).equals(areas[position])) {
                        code_area = idArea;
                        break;
                    }
                }
                counter++;
                searchServices();
//                error.setText(loading.AREAS.get(code_area));
//                error.setVisibility(View.VISIBLE);

            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
        service_type.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                for(String idType:idServices) {
                    if (loading.SERVICES.get(idType).equals(serviceTypes[position])) {
                        code_type = idType;
                        break;
                    }
                }
                counter++;
                searchServices();
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
        if(i>1) {
            goBack.setOnClickListener(v -> {
                finish();
            });
        }else{
            goBack.setClickable(false);//in order to avoid going back to the loading page
        }
        goProfile.setOnClickListener(v->{
            Intent toProfile = new Intent(search.this, profile.class);
            startActivity(toProfile);
        });
        goSearch.setOnClickListener(v->{
            Toast.makeText(search.this,"You're already on the search page",Toast.LENGTH_SHORT).show();
        });
        goLogOut.setOnClickListener(v -> {
            if(back==0){
                Toast.makeText(search.this,"click again to logOut",Toast.LENGTH_SHORT).show();
            }else {
                Intent toLogOut = new Intent(search.this, logout.class);
                startActivity(toLogOut);
            }
            back++;
        });
    }
    private void searchServices(){
        if(counter>=2){
            RequestQueue queue = Volley.newRequestQueue(search.this);
            String url = LinkSetting.getUrl_search();
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
                            JSONObject freelancers=js.getJSONObject("freelancers");
                            float f= Float.valueOf(nbOfServices);
                            for(int i=0;i<f;i++){
                                String freelancer_id=freelancers.getString("freelancer_id"+i);
                                String freelancer_name=freelancers.getString("freelancer_name"+i);
                                String freelancer_phone_nb=freelancers.getString("freelancer_phone_nb"+i);
                                String freelancer_email=freelancers.getString("freelancer_email"+i);
                                String freelancer_birthdate=freelancers.getString("freelancer_birthdate"+i);
                                String freelancer_join_date=freelancers.getString("join_date"+i);
                                String freelancer_code_gender=freelancers.getString("code_gender"+i);
                                String freelancer_code_area=freelancers.getString("code_area"+i);
                                String freelancer_code_role=freelancers.getString("code_role"+i);
                                Users freelancer=new Users(
                                        freelancer_id,freelancer_name,freelancer_email,freelancer_join_date,freelancer_birthdate,
                                        freelancer_phone_nb,freelancer_code_area,freelancer_code_role,freelancer_code_gender
                                );
                                String service_title=services.getString("service_title"+i);
                                String service_id=services.getString("sid"+i);
                                String service_code_area=services.getString("code_area"+i);
                                String service_code_type=services.getString("code_type"+i);
                                String service_description=services.getString("service_description"+i);
                                String service_location=services.getString("service_location"+i);
                                String service_average_rate=services.getString("avg"+i);
                                String add_date=services.getString("add_date"+i);
                                servicesArray.add(new Services(
                                        freelancer,service_id,service_title,service_description,service_code_area,
                                        service_code_type,service_location,service_average_rate,add_date
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
                    paramV.put("code_area", code_area);
                    paramV.put("service_type",code_type);
                    return paramV;
                }
            };
            queue.add(req);

        }
    }
    private void display(){
        clean();
        prev.setClickable(true);
        next.setClickable(true);
        next.setVisibility(View.VISIBLE);
        prev.setVisibility(View.VISIBLE);
        Services tmp;
        float avg;
        if(displayed_services<servicesArray.size()) {
            service1.setVisibility(View.VISIBLE);
            service1.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent toTheService=new Intent(search.this,activity_service.class);
                    chosenService=servicesArray.get(displayed_services-realDisplayedServices);
                    startActivity(toTheService);

                }
            });
            realDisplayedServices++;
            tmp = servicesArray.get(displayed_services++);
            freelancer_name_1.setText(tmp.getProvider().getName());
            freelancer_phoneNb_1.setText(tmp.getProvider().getPhoneNumber());
            freelancer_email_1.setText(tmp.getProvider().getEmail());

            service_title_1.setText(tmp.getService_title());
            service_area_1.setText(loading.AREAS.get(tmp.getService_code_area()));
            avg = Float.valueOf(tmp.getService_average_rate());//e.g: 3
            if (avg == 0) {
                service_1_no_rate.setVisibility(View.VISIBLE);
                service_1_no_rate.setText("No rate available");
            }
            if ((avg--) >= 1) {
                service_1_star_1.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                service_1_star_2.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                service_1_star_3.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                service_1_star_4.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                service_1_star_5.setVisibility(View.VISIBLE);
            }
        }
        if(displayed_services<servicesArray.size()) {
            service2.setVisibility(View.VISIBLE);
            tmp = servicesArray.get(displayed_services++);
            service2.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent toTheService=new Intent(search.this,activity_service.class);
                    chosenService=servicesArray.get(displayed_services-1);
                    startActivity(toTheService);

                }
            });

            realDisplayedServices++;
            freelancer_name_2.setText(tmp.getProvider().getName());
            freelancer_phoneNb_2.setText(tmp.getProvider().getPhoneNumber());
            freelancer_email_2.setText(tmp.getProvider().getEmail());

            service_title_2.setText(tmp.getService_title());
            service_area_2.setText(loading.AREAS.get(tmp.getService_code_area()));
            avg = Float.valueOf(tmp.getService_average_rate());//e.g: 3
            if (avg == 0) {
                service_2_no_rate.setVisibility(View.VISIBLE);
                service_2_no_rate.setText("No rate available");
            }
            if ((avg--) >= 1) {
                service_2_star_1.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                service_2_star_2.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                service_2_star_3.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                service_2_star_4.setVisibility(View.VISIBLE);
            }
            if ((avg--) >= 1) {
                service_2_star_5.setVisibility(View.VISIBLE);
            }
        }
        if(displayed_services==servicesArray.size()){
            next.setVisibility(View.INVISIBLE);
            next.setClickable(false);
        }
        if(displayed_services<=2){
            prev.setClickable(false);
            prev.setVisibility(View.INVISIBLE);
        }
//        error.setText(displayed_services);
//        error.setVisibility(View.VISIBLE);
    }
    private void clean(){
        back=0;
        realDisplayedServices=0;
        prev.setVisibility(View.INVISIBLE);
        next.setVisibility(View.INVISIBLE);
        prev.setClickable(false);
        next.setClickable(false);
        service1.setVisibility(View.INVISIBLE);
        service2.setVisibility(View.INVISIBLE);
        service_1_no_rate.setVisibility(View.INVISIBLE);
        service_1_no_rate.setText("");
        service_1_star_1.setVisibility(View.INVISIBLE);
        service_1_star_2.setVisibility(View.INVISIBLE);
        service_1_star_3.setVisibility(View.INVISIBLE);
        service_1_star_4.setVisibility(View.INVISIBLE);
        service_1_star_5.setVisibility(View.INVISIBLE);

        service_2_star_1.setVisibility(View.INVISIBLE);
        service_2_star_2.setVisibility(View.INVISIBLE);
        service_2_star_3.setVisibility(View.INVISIBLE);
        service_2_star_4.setVisibility(View.INVISIBLE);
        service_2_star_5.setVisibility(View.INVISIBLE);
        service_2_no_rate.setVisibility(View.INVISIBLE);
        service_2_no_rate.setText("");

    }
}