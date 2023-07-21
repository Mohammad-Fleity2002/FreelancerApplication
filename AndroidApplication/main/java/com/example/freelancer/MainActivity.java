package com.example.freelancer;


import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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

public class MainActivity extends Activity {
    TextView goSignUp,goChangePass,error;
    EditText inUsername,inPass;
    Button login;
    public static Users USER;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.sign_in);
        login=(Button) findViewById(R.id.logIn);
        goChangePass=(TextView) findViewById(R.id.forgotPass);
        goSignUp=(TextView) findViewById(R.id.signUp);
        inUsername=(EditText) findViewById(R.id.name);
        inPass=(EditText) findViewById(R.id.password);
        error=(TextView)findViewById(R.id.error);
        goSignUp.setOnClickListener(v -> {
            Intent toSignUp=new Intent(MainActivity.this,loading.class);
            startActivity(toSignUp);
        });
        goChangePass.setOnClickListener(v->{
            Intent toResetPassword=new Intent(MainActivity.this,reset_password.class);
            startActivity(toResetPassword);
        });
        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                RequestQueue queue= Volley.newRequestQueue(MainActivity.this);
                String url = LinkSetting.getUrl_sign_in();
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
                            }else{
                                 String id= js.getString("id");
                                 String name=js.getString("name");
                                 String email=js.getString("email");
                                 String phoneNb=js.getString("phoneNb");
                                 String birthDate=js.getString("birthDate");
                                 String joinDate=js.getString("joinDate");
                                 String code_role = js.getString("code_role");
                                 String code_gender= js.getString("code_gender");
                                 String code_area= js.getString("code_area");
                                 USER=new Users(id,name,email,joinDate,birthDate,phoneNb,code_area,code_role,code_gender);
                                login.setClickable(false);
                                Intent toSearch=new Intent(MainActivity.this,loading.class);
                                inPass.setText("");
                                error.setVisibility(View.INVISIBLE);
                                startActivity(toSearch);
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
                        paramV.put("email", inUsername.getText().toString());
                        paramV.put("password", inPass.getText().toString());
                        return paramV;
                    }
                };
                queue.add(req);
            }
        });
    }
    public static void logOut(){
        USER=null;
    }
}