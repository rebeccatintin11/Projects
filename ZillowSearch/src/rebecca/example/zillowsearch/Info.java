package rebecca.example.zillowsearch;

import java.util.ArrayList;

import org.json.JSONException;
import org.json.JSONObject;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

public class Info extends Fragment {

	private ListView listView;
    private View v;
    private String address =null;
    private String street = null;
    private String city = null;
    private String state = null;
    private String zip = null;
    private String link = null;
	
    private String PT = null;
    private String YB = null;
    private String LS= null;
    private String FA = null;
    private String Bath = null;
    private String Bed = null;
    private String TAY = null;
    private String TA = null;
    private String LSP = null;
    private String LSD = null;
    private String ZPE_D = null;
    private String ZPE = null;
    private String DOC = null;
    private String DOC_sign = null;
	private String ATPR = null;
	private String RZV_D = null;
	private String RZV = null;
	private String DRC = null;
	private String DRC_sign = null;
	private String ATRR = null;
	private String chart1 = null;
    
    @Override
    public void onCreate(Bundle savedInstanceState) {
        // TODO Auto-generated method stub
        super.onCreate(savedInstanceState);
        
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
        Bundle savedInstanceState) {
        // TODO Auto-generated method stub
    	
    	//get data from bundle
    	Bundle bundle = getArguments();
    	String result = (String)bundle.get("info_array");
    	String result2 = (String)bundle.get("chart_array");
    	JSONObject info = null;
    	JSONObject chart = null;
    	JSONObject year1 = null;
		try {
			info = new JSONObject(result);
			chart = new JSONObject(result2);
			year1 = new JSONObject(chart.getString("1year"));
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		

    	
		try {
			street = info.getString("street");
			city = info.getString("city");
			state = info.getString("state");
			zip = info.getString("zipcode");
			link = info.getString("homedetails");
			address = street+", "+city+", "+state+"-"+zip;
			 
			PT = info.getString("useCode");
			YB = info.getString("yearBuilt");
			LS = info.getString("lotSizeSqFt")+" sq. ft.";
	    	FA = info.getString("finishedSqFt")+" sq. ft.";
			Bath = info.getString("bathrooms");
			Bed = info.getString("bedrooms");
			TAY = info.getString("taxAssessmentYear");
			TA = "$"+info.getString("taxAssessment");
			LSP = "$"+info.getString("lastSoldPrice");
			LSD = info.getString("lastSoldDate");
			ZPE_D = info.getString("estimateLastUpdate");
			ZPE = "$"+info.getString("estimateAmount");
			DOC = "$"+info.getString("estimateValueChange");
			DOC_sign = info.getString("estimateValueChangeSign");
			ATPR = "$"+info.getString("estimateValuationRangeLow")+"-$"+info.getString("estimateValuationRangeHigh");
			RZV_D = info.getString("restimateLastUpdate");
			RZV = "$"+info.getString("restimateAmount");
			DRC = "$"+info.getString("restimateValueChange");
			DRC_sign = info.getString("restimateValueChangeSign");
			ATRR = "$"+info.getString("restimateValuationRangeLow")+"-$"+info.getString("restimateValuationRangeHigh");
			chart1 = (String) year1.getString("url").replace("\\", " ");
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		//set layout
		v = inflater.inflate(R.layout.info, container, false);
        listView = (ListView)v.findViewById(R.id.infoList);
        
        ArrayList<DataRow> table = new ArrayList<DataRow>();  

        //add data row by row to table
        table.add(new DataRow("See more details on Zillow:"));
        table.add(new DataRow(address,link,1));
        table.add(new DataRow("Property Type",PT)); 
        table.add(new DataRow("Year Built",YB));
        table.add(new DataRow("Lot Size",LS));
        table.add(new DataRow("Finished Area",FA));
        table.add(new DataRow("Bathrooms",Bath));
        table.add(new DataRow("Bedrooms",Bed));
        table.add(new DataRow("Tax Assessment Year",TAY));
        table.add(new DataRow("Tax Assessment",TA));
        table.add(new DataRow("Last Sold Price",LSP));
        table.add(new DataRow("Last Sold Date",LSD));
        table.add(new DataRow("Zestimate \u00AE Property Estimate\nas of "+ZPE_D,ZPE));
        table.add(new DataRow("30 Days Overall Change",DOC,DOC_sign));
        table.add(new DataRow("All Time Property Range",ATPR));
        table.add(new DataRow("Rent Zestimate \u00AE Valuation\nas of "+RZV_D,RZV));
        table.add(new DataRow("30 Days Rent Change",DRC,DRC_sign));
        table.add(new DataRow("All Time Rent Range",ATRR));
        table.add(new DataRow("ch",chart1,1));
        TableAdapter adapter = new TableAdapter(getActivity(), table);  
        listView.setAdapter(adapter);
        return v;
        
    }

}
