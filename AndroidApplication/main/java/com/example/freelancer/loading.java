package com.example.freelancer;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
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

public class loading extends AppCompatActivity {
    TextView error;
    Button back;
    public static HashMap<String,String> AREAS=new HashMap<>();
    public static HashMap<String,String> GENDERS=new HashMap<>();
    public static HashMap<String,String> ROLES=new HashMap<>();
    public static HashMap<String,String> SERVICES=new HashMap<>();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.loading);
        error=(TextView) findViewById(R.id.error);
        back=(Button) findViewById(R.id.back);
        back.setOnClickListener(v->finish());
        RequestQueue queue= Volley.newRequestQueue(loading.this);
        String url = LinkSetting.getUrl_loading();
        StringRequest req = new StringRequest(
                Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject js=new JSONObject(response);
                    String status=js.getString("status");
                    String message=js.getString("message");
                    if(status.equals("failed")){
                        error.setVisibility(View.VISIBLE);
                        error.setText(message);
                        back.setClickable(true);
                        back.setVisibility(View.VISIBLE);
                    }else{
                        JSONObject areas=js.getJSONObject("areas");
                        JSONObject idAreas=js.getJSONObject("idAreas");
                        String nbareas=js.getString("size");
                        float f= Float.valueOf(nbareas);
                        error.setVisibility(View.VISIBLE);
                        for (int i=0;i<f;i++){
                            String area=areas.getString("name"+i);
                            String id=idAreas.getString("id"+i);
                            AREAS.put(id,area);
                        }
                        JSONObject genders=js.getJSONObject("genders");
                        JSONObject idGenders=js.getJSONObject("idGenders");
                        String nbgenders=js.getString("nbGenders");
                        f= Float.valueOf(nbgenders);
                        error.setVisibility(View.VISIBLE);
                        for (int i=0;i<f;i++){
                            String gender=genders.getString("name"+i);
                            String id=idGenders.getString("id"+i);
                            GENDERS.put(id,gender);
                        }
                        JSONObject roles=js.getJSONObject("roles");
                        JSONObject idRoles=js.getJSONObject("idRoles");
                        String nbroles=js.getString("nbRoles");
                        f= Float.valueOf(nbroles);
                        error.setVisibility(View.VISIBLE);
                        for (int i=0;i<f;i++){
                            String role=roles.getString("name"+i);
                            String id=idRoles.getString("id"+i);
                            ROLES.put(id,role);
                        }
                        JSONObject services=js.getJSONObject("services");
                        JSONObject idServices=js.getJSONObject("idServices");
                        String nbservices=js.getString("nbServices");
                        f= Float.valueOf(nbservices);
                        error.setVisibility(View.VISIBLE);
                        for (int i=0;i<f;i++){
                            String service=services.getString("name"+i);
                            String id=idServices.getString("id"+i);
                            SERVICES.put(id,service);
                        }
                        Intent redirect;
                        if(MainActivity.USER==null){
                             redirect=new Intent(loading.this,sign_up.class);
                        }
                        else {
                             redirect=new Intent(loading.this,search.class);
                        }
                        startActivity(redirect);
                    }
                } catch (JSONException e) {
                    error.setText(e.getMessage());
                    error.setVisibility(View.VISIBLE);
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError err) {
                error.setVisibility(View.VISIBLE);
                error.setText(err.toString());
            }
        }){
            protected Map<String, String> getParams(){
                Map<String, String> paramV = new HashMap<>();
                paramV.put("code", "1");
                return paramV;
            }
        };
        queue.add(req);
    }
}
