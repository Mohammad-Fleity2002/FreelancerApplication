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

public class sign_up extends Activity{

    TextView goSignIn,goBack,error;
    Button signUp;
    String code_area,code_gender,code_role;
    private final static String[] areas=loading.AREAS.values().toArray(new String[0]);
    private final static String[] idAreas=loading.AREAS.keySet().toArray(new String[0]);
    private final static String[] genders=loading.GENDERS.values().toArray(new String[0]);
    private final static String[] idGenders=loading.GENDERS.keySet().toArray(new String[0]);
    private final static String[] roles=loading.ROLES.values().toArray(new String[0]);
    private final static String[] idRoles=loading.ROLES.keySet().toArray(new String[0]);
    Spinner spinGender,spinArea,spinRole;
    EditText inName,inEmail,inPhoneNb,inBirthDate,inPass,inConfPass;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.sign_up);

        spinGender=(Spinner) findViewById(R.id.gender);
        spinArea=(Spinner) findViewById(R.id.area);
        spinRole=(Spinner) findViewById(R.id.role);
        inName=(EditText) findViewById(R.id.name);
        inEmail=(EditText) findViewById(R.id.email);
        inPass=(EditText) findViewById(R.id.pass);
        inConfPass=(EditText) findViewById(R.id.confirmPass);
        inBirthDate=(EditText) findViewById(R.id.birthDate);
        inPhoneNb=(EditText) findViewById(R.id.phoneNb);
        //button
        signUp=(Button) findViewById(R.id.createAccount);
        goBack=(TextView) findViewById(R.id.back);
        goSignIn=(TextView) findViewById(R.id.signIn);
        error=(TextView) findViewById(R.id.error);
        goSignIn.setOnClickListener(v -> {
            Intent toLogIn1=new Intent(sign_up.this,MainActivity.class);
            startActivity(toLogIn1);
        });
        goBack.setOnClickListener(v -> {
            Intent toLogIn2=new Intent(sign_up.this,MainActivity.class);
            startActivity(toLogIn2);
        });
        ArrayAdapter<String> areaAdapter=new ArrayAdapter<>(this, android.R.layout.simple_spinner_item,areas);
        areaAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinArea.setAdapter(areaAdapter);
        spinArea.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                for(String idArea:idAreas){
                    if(loading.AREAS.get(idArea).equals(areas[position])){
                        code_area=idArea;
                        break;
                    }
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
            }
        });
        ArrayAdapter<String> genderAdapter=new ArrayAdapter<>(this, android.R.layout.simple_spinner_item,genders);
        genderAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinGender.setAdapter(genderAdapter);
        spinGender.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                for(String idGender:idGenders){
                    if(loading.GENDERS.get(idGender).equals(genders[position])){
                        code_gender=idGender;
                        break;
                    }
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
            }
        });
        ArrayAdapter<String> roleAdapter=new ArrayAdapter<>(this, android.R.layout.simple_spinner_item,roles);
        roleAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinRole.setAdapter(roleAdapter);
        spinRole.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                if(roles[position].equals("Admin")){
//                    Toast.makeText(sign_up.this,"invalid user role",Toast.LENGTH_SHORT).show();
                    error.setVisibility(View.VISIBLE);
                    error.setText("wrong user role");
                    return;
                }
                error.setVisibility(View.INVISIBLE);
                error.setText( "");
                for(String idRole:idRoles){
                    if(loading.ROLES.get(idRole).equals(roles[position])){
                        code_role=idRole;
                        break;
                    }
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
            }
        });

        signUp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(inConfPass.getText().toString().equals(inPass.getText().toString())) {
                    RequestQueue queue = Volley.newRequestQueue(sign_up.this);
                    String url = LinkSetting.getUrl_sign_up();
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
                                    Intent toSignIn=new Intent(sign_up.this,MainActivity.class);
                                    startActivity(toSignIn);
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
                            paramV.put("email", inEmail.getText().toString().trim());
                            paramV.put("password", inPass.getText().toString().trim());
                            paramV.put("name", inName.getText().toString().trim());
                            paramV.put("phone_number", inPhoneNb.getText().toString().trim());
                            paramV.put("birthdate", inBirthDate.getText().toString().trim());
                            paramV.put("code_area", String.valueOf(code_area));
                            paramV.put("code_gender", String.valueOf(code_gender));
                            paramV.put("code_role", String.valueOf(code_role));
                            return paramV;
                        }
                    };
                    queue.add(req);
                }else{
                    error.setVisibility(View.VISIBLE);
                    error.setText("unconfirmed password");
                    inConfPass.setText("");
                }
            }
        });
    }
}