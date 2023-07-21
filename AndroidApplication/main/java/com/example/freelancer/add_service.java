package com.example.freelancer;

import androidx.appcompat.app.AppCompatActivity;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;

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

public class add_service extends Activity {
    private static EditText inServiceTitle,inServiceDesc,inServiceLinkLocation;
    private static String[] areas=loading.AREAS.values().toArray(new String[0]);
    private static String[] services=loading.SERVICES.values().toArray(new String[0]);
    private static String[] areasId=loading.AREAS.keySet().toArray(new String[0]);
    private static String[] servicesId=loading.SERVICES.keySet().toArray(new String[0]);
    private static String code_area,code_type;
    Spinner spinArea,spinType;
    Button cancel,offer;
    TextView goBack,error;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.add_service);
        spinArea=(Spinner) findViewById(R.id.serviceArea);
        spinType=(Spinner) findViewById(R.id.serviceType);
        cancel=(Button) findViewById(R.id.cancelService);
        offer=(Button) findViewById(R.id.offerService);
        inServiceDesc=(EditText) findViewById(R.id.serviceDescription);
        inServiceTitle=(EditText) findViewById(R.id.serviceTitle);
        inServiceLinkLocation=(EditText) findViewById(R.id.serviceLinkLocation);
        goBack=(TextView) findViewById(R.id.back);
        error=findViewById(R.id.error);
        goBack.setOnClickListener(v->finish());
        cancel.setOnClickListener(v -> finish());
        ArrayAdapter<String> areaAdapter=new ArrayAdapter<>(add_service.this,android.R.layout.simple_spinner_item,areas);
        ArrayAdapter<String> servicesAdapter=new ArrayAdapter<>(add_service.this,android.R.layout.simple_spinner_item,services);
        areaAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        servicesAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinArea.setAdapter(areaAdapter);
        spinType.setAdapter(servicesAdapter);
        spinArea.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                for(String idArea:areasId) {
                    if (loading.AREAS.get(idArea).equals(areas[position])) {
                        code_area = idArea;
                        break;
                    }
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
        spinType.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                for(String idType:servicesId) {
                    if (loading.SERVICES.get(idType).equals(services[position])) {
                        code_type = idType;
                        break;
                    }
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
        offer.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                    RequestQueue queue = Volley.newRequestQueue(add_service.this);
                    String url = LinkSetting.getUrl_add_service();
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
                                    Intent toMyServices=new Intent(add_service.this,my_services.class);
                                    startActivity(toMyServices);
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
                            paramV.put("service_description", inServiceDesc.getText().toString().trim());
                            paramV.put("freelancer_id", MainActivity.USER.getId().toString());
                            paramV.put("service_title", inServiceTitle.getText().toString().trim());
                            paramV.put("service_link_location", inServiceLinkLocation.getText().toString().trim());
                            paramV.put("code_area", String.valueOf(code_area));
                            paramV.put("code_type", String.valueOf(code_type));
                            return paramV;
                        }
                        // $service_description = "description";
                        // $freelancer_id = "2";
                        // $service_title = "title";
                        // $code_area = "1";
                        // $service_link_location = "link location";
                        // $code_type = "1";

                    };
                    queue.add(req);
                }
        });
    }
}