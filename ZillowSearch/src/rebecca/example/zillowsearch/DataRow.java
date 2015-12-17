package rebecca.example.zillowsearch;

public class DataRow {

	private String name;  
    private String value; 
    private String sign;
    private String link;
    private int with_link;
      
    public DataRow() {  
        super();  
    }  
    
    public DataRow(String name, String link, int with_link) {  
        super();  
        this.name = name;  
        this.value = null;  
        this.sign = null;
        this.link = link;
        this.with_link = with_link;
    } 
    
    public DataRow(String name) {  
        super();  
        this.name = name;  
        this.value = null;  
        this.sign = null;
        this.link = null;
        this.with_link = 0;
    } 
    
    public DataRow(String name, String value) {  
        super();  
        this.name = name;  
        this.value = value;  
        this.sign = null;
        this.link = null;
        this.with_link = 0;
    } 
    
    public DataRow(String name, String value,String sign) {  
        super();  
        this.name = name;  
        this.value = value;   
        this.sign = sign;
        this.link = null;
        this.with_link = 0;
    } 
    
    public String getName() {  
        return name;  
    }  

    public String getValue() { 
        return this.value;  
    }  
    
    
    public String getImage(){  	
    	return sign;   	
    }
    
    public String getLink(){
    	return link;
    }
    
    public int getWithLink(){
    	return with_link;
    }
    
    public String getSign(){
    	return sign;
    }
    
}
