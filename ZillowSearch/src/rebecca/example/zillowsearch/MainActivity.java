package rebecca.example.zillowsearch;


import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.util.LinkedList;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.utils.URLEncodedUtils;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;


public class MainActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
        
		Spinner spinner = (Spinner) findViewById(R.id.stateInput);
		// Create an ArrayAdapter using the string array and a default spinner layout
		ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(this,R.array.state_array, R.drawable.spinner_style);
		// Specify the layout to use when the list of choices appears
		adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
		// Apply the adapter to the spinner
		spinner.setAdapter(adapter);
		 
		final EditText street = (EditText) findViewById(R.id.streetInput);
    	final EditText city = (EditText) findViewById(R.id.cityInput);
    	final Spinner state = (Spinner) findViewById(R.id.stateInput);
    	final TextView errmsg1 = (TextView)findViewById(R.id.errormsg1);
    	final TextView errmsg2 = (TextView)findViewById(R.id.errormsg2);
    	final TextView errmsg3 = (TextView)findViewById(R.id.errormsg3);
    	
    	Button search = (Button) findViewById(R.id.searchButton);
    	
    	search.setOnClickListener(new OnClickListener() {
    		 
    		  @Override
    		  public void onClick(View v) {
    	 
    			  //get user input from EditText
    			  String streetInput=String.valueOf(street.getText());
    			  String cityInput=String.valueOf(city.getText());
    			  String stateInput=String.valueOf(state.getSelectedItem());
    			  
    			  if(street.getText().toString().length()==0)errmsg1.setVisibility(View.VISIBLE);
    			  if(city.getText().toString().length()==0)errmsg2.setVisibility(View.VISIBLE);
				  if(state.getSelectedItem().equals("Choose State"))errmsg3.setVisibility(View.VISIBLE);
    			  //check input
    			  if(street.getText().toString().length()!=0 && 
    					  city.getText().toString().length()!=0 && 
    					!state.getSelectedItem().toString().equals("Choose State")){
    				  //got data to connect server
    				  new HttpAsyncTask().execute(generateURL(streetInput,cityInput,stateInput));
    				  
    			  }
    		  }
    	 
    		});
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if (id == R.id.action_settings) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
    



    
    private String generateURL(String street,String city,String state){
    	
    	String server_url = "http://usccsci571hw8-rebecctl.elasticbeanstalk.com/?";
    	//set parameters
    	List<BasicNameValuePair> params = new LinkedList<BasicNameValuePair>();
    	params.add(new BasicNameValuePair("streetInput", street));
    	params.add(new BasicNameValuePair("cityInput", city));
    	params.add(new BasicNameValuePair("stateInput", state));
    	String paramString = URLEncodedUtils.format(params, "utf-8");
    	
    	//provide url with parameters
        server_url += paramString;
        return server_url;
        
    }
    
    private class HttpAsyncTask extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... urls) {
 
        	String result = "";
        	InputStream is = null;
        	try {

        		HttpClient httpclient = new DefaultHttpClient();
            	HttpGet httpGet= new HttpGet(urls[0]);
    	        HttpResponse response = httpclient.execute(httpGet);
    	        HttpEntity entity = response.getEntity();
    	        
    	        is = entity.getContent();

    	        if(is != null){
                    result = convertInputStreamToString(is);
    	        }else{
                    result = "Did not work!";	
    	        }

        	} catch (Exception e) {
                Log.d("InputStream", e.getLocalizedMessage());
            }
        	
        	try {
				is.close();
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
        	return result;
        }
        // onPostExecute displays the results of the AsyncTask.
        @Override
        protected void onPostExecute(String result) {
            
        	if(result!=null){
            
        		JSONObject obj = null;
				try {
					obj = new JSONObject(result);
				} catch (JSONException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}
            	
	           	 //get lower level json array
	           	String status = null;
	           	String inforesult= null;
	           	String chart= null;
				try {
					status = obj.getString("status");
					inforesult = obj.getString("result");
					chart = obj.getString("chart");
				} catch (JSONException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
	           	
	           	if(status.equals("Success")){

	           		//show basic info and charts
	           		Intent it=new Intent(MainActivity.this,ResultActivity.class);//change activity
	           		
	           		it.putExtra("info_array", inforesult ); //put data
	           		it.putExtra("chart_array", chart ); //put data
	           		startActivity(it);
	           		
	           		
	           	}else if(status.equals("No exact match found--Verify that the given address is correct")){
	           		//show error message
	           		TextView NoMatch = (TextView)findViewById(R.id.nomatch);
	           		NoMatch.setVisibility(View.VISIBLE);
	           		
	           	}

			} else 
				Toast.makeText(getBaseContext(), "error accur", Toast.LENGTH_SHORT).show();
       }
    }
   
    
    // convert inputstream to String
    private static String convertInputStreamToString(InputStream inputStream) throws IOException{
    	
        BufferedReader bufferedReader = new BufferedReader( new InputStreamReader(inputStream));
        String line = "";
        String result = "";
        while((line = bufferedReader.readLine()) != null)
            result += line;

        inputStream.close();
        return result;

    }

   
}
