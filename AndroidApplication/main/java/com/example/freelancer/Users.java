package com.example.freelancer;

import kotlin.collections.UArraySortingKt;

public class Users {
    //fields
    private String id,code_area,code_role,code_gender;
    private String name,email,joinDate,birthdate,phoneNumber;
    //constructor
    public Users(String i, String n, String e, String j,String b,String phnb,String area,String role,String gender) {
        this.id = i;
        this.name = n;
        this.email = e;
        this.code_area = area;
        this.code_role = role;
        this.birthdate = b;
        this.phoneNumber = phnb;
        this.joinDate = j;
        this.code_gender = gender;
    }

    //Getter
    public String getId() {
        return id;
    }
    public String getCode_area() {
        return code_area;
    }
    public String getCode_role() {
        return code_role;
    }
    public String getName() {
        return name;
    }
    public String getCode_gender() {
        return code_gender;
    }
    public String getEmail() {
        return email;
    }
    public String getJoinDate() {
        return joinDate;
    }
    public String getBirthdate() {
        return birthdate;
    }
    public String getPhoneNumber() {
        return phoneNumber;
    }
    public void setPhoneNumber(String phoneNumber) {
        this.phoneNumber = phoneNumber;
    }
    public void setBirthdate(String birthdate) {
        this.birthdate = birthdate;
    }

    //setter
    public void setJoinDate(String joinDate) {
        this.joinDate = joinDate;
    }
    public void setEmail(String email) {
        this.email = email;
    }
    public void setCode_gender(String code_gender) {
        this.code_gender = code_gender;
    }
    public void setName(String name) {
        this.name = name;
    }
    public void setCode_role(String code_role) {
        this.code_role = code_role;
    }
    public void setCode_area(String code_area) {
        this.code_area = code_area;
    }
    public void setId(String id) {
        this.id = id;
    }

    //toString
    @Override
    public String toString() {
        return "Users{" +
                "id=" + id +
                ", code_area=" + code_area +
                ", code_role=" + code_role +
                ", code_gender=" + code_gender +
                ", name='" + name + '\'' +
                ", email='" + email + '\'' +
                ", joinDate='" + joinDate + '\'' +
                ", birthdate='" + birthdate + '\'' +
                ", phoneNumber='" + phoneNumber + '\'' +
                '}';
    }
}
