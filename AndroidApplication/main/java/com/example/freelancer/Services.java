package com.example.freelancer;

public class Services {
    //fields
    private String 
            service_id,service_title,service_description,service_code_area,service_code_type,service_link_location,service_average_rate,add_date;
    private Users provider;
    //constructors
    public Services(Users p,String sid,String stitle,String sdesc,String scarea,String sctype,
                    String slinklocation,String savg,String ad
    ){
        this.add_date=ad;
        this.provider=p;
        this.service_id=sid;
        this.service_title=stitle;
        this.service_description=sdesc;
        this.service_code_area=scarea;
        this.service_code_type=sctype;
        this.service_link_location=slinklocation;
        this.service_average_rate=savg;
    }
    public Services(Users p,String sid,String stitle,String sdesc,String scarea,String sctype,
                    String slinklocation,String ad
    ){
        this.add_date=ad;
        this.provider=p;
        this.service_id=sid;
        this.service_title=stitle;
        this.service_description=sdesc;
        this.service_code_area=scarea;
        this.service_code_type=sctype;
        this.service_link_location=slinklocation;
        this.service_average_rate=null;
    }
    //getters
    public String getService_id() {
        return service_id;
    }
    public String getService_title() {
        return service_title;
    }
    public String getService_description() {
        return service_description;
    }
    public String getService_code_area() {
        return service_code_area;
    }
    public String getService_code_type() {
        return service_code_type;
    }
    public String getService_link_location() {
        return service_link_location;
    }
    public String getService_average_rate() {
        return service_average_rate;
    }
    public Users getProvider() {
        return provider;
    }
    public String getAdd_date() {
        return add_date;
    }
    //setter
    public void setAdd_date(String add_date) {
        this.add_date = add_date;
    }
    public void setProvider(Users provider) {
        this.provider = provider;
    }
    public void setService_average_rate(String service_average_rate) {
        this.service_average_rate = service_average_rate;
    }
    public void setService_link_location(String service_link_location) {
        this.service_link_location = service_link_location;
    }
    public void setService_code_type(String service_code_type) {
        this.service_code_type = service_code_type;
    }
    public void setService_code_area(String service_code_area) {
        this.service_code_area = service_code_area;
    }
    public void setService_description(String service_description) {
        this.service_description = service_description;
    }
    public void setService_title(String service_title) {
        this.service_title = service_title;
    }
    public void setService_id(String service_id) {
        this.service_id = service_id;
    }

    //toString

    @Override
    public String toString() {
        return "Services{" +
                "service_id='" + service_id + '\'' +
                ", service_title='" + service_title + '\'' +
                ", service_description='" + service_description + '\'' +
                ", service_code_area='" + service_code_area + '\'' +
                ", service_code_type='" + service_code_type + '\'' +
                ", service_link_location='" + service_link_location + '\'' +
                ", service_average_rate='" + service_average_rate + '\'' +
                ", provider=" + provider +
                '}';
    }
}
