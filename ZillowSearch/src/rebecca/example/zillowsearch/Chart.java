package rebecca.example.zillowsearch;

import java.io.InputStream;

import org.json.JSONException;
import org.json.JSONObject;

import android.support.v4.app.Fragment;
import android.content.res.Resources;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.Drawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageSwitcher;
import android.widget.ImageView;
import android.widget.TextSwitcher;
import android.widget.TextView;
import android.widget.ViewSwitcher.ViewFactory;

public class Chart extends Fragment {
	
    private View v;
    private static final String[] TEXTS = { "Historical Zestimate for the past 1 year",
    										"Historical Zestimate for the past 5 year",
    										"Historical Zestimate for the past 10 year" };
	private static final String[] IMAGES ={ "", "",""};
	private int mPosition = 0;
	private TextSwitcher mTextSwitcher;
	private TextView show_address;
	private ImageSwitcher mImageSwitcher;
	private Button bn;
	private Button bp;
	private String address =null;
    private String street = null;
    private String city = null;
    private String state = null;
    private String zip = null;
    
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
		JSONObject year5 = null;
		JSONObject year10 = null;
		try {
			info = new JSONObject(result);
			chart = new JSONObject(result2);
			year1 = new JSONObject(chart.getString("1year"));
			year5 = new JSONObject(chart.getString("5year"));
			year10 = new JSONObject(chart.getString("10year"));
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

		//get image url from json
		String S_year1 = null;
		String S_year5 = null;
		String S_year10 = null;
		try {
			street = info.getString("street");
			city = info.getString("city");
			state = info.getString("state");
			zip = info.getString("zipcode");
			address = street+", "+city+", "+state+"-"+zip;
			
			S_year1 = (String) year1.getString("url").replace("\\", " ");
			S_year5 = (String) year5.getString("url").replace("\\", " ");
			S_year10 = (String) year10.getString("url").replace("\\", " ");
		} catch (JSONException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
		
		//set into image array
		IMAGES[0] = S_year1;
		IMAGES[1] = S_year5;
		IMAGES[2] = S_year10;		
		

    	//set layout
		v = inflater.inflate(R.layout.chart, container, false);

		show_address = (TextView)v.findViewById(R.id.detail);
		show_address.setText(address);
		
		mTextSwitcher = (TextSwitcher)v.findViewById(R.id.description);
		mTextSwitcher.setFactory(new ViewFactory() {
			@Override
			public View makeView() {
				TextView textView = new TextView(getActivity());
				textView.setGravity(Gravity.CENTER);
				textView.setTextSize(16);
				textView.setTextColor(Color.BLACK);
				return textView;
			}
		});
		//set default text
		mTextSwitcher.setText(TEXTS[mPosition]);
		mTextSwitcher.setInAnimation(getActivity(), android.R.anim.fade_in);
		mTextSwitcher.setOutAnimation(getActivity(), android.R.anim.fade_out);

		mImageSwitcher = (ImageSwitcher) v.findViewById(R.id.historical_chart);
		mImageSwitcher.setFactory(new ViewFactory() {
			@Override
			public View makeView() {
				ImageView imageView = new ImageView(getActivity());
				return imageView;
			}
		});
		//set default image
		new DownLoadImage(mImageSwitcher).execute(IMAGES[mPosition]);
		mImageSwitcher.setInAnimation(getActivity(), android.R.anim.slide_in_left);
		mImageSwitcher.setOutAnimation(getActivity(), android.R.anim.slide_out_right);
		
		bn = (Button)v.findViewById(R.id.button_next);
		bp = (Button)v.findViewById(R.id.button_previous);
		
		//button click
        bn.setOnClickListener(new View.OnClickListener() {
 
            @Override
            public void onClick(View v) {
                // TODO Auto-generated method stub
            	mPosition = (mPosition + 1)% TEXTS.length;
            	mTextSwitcher.setText(TEXTS[mPosition]);
            	new DownLoadImage(mImageSwitcher).execute(IMAGES[mPosition]);

            }
        });
        
        bp.setOnClickListener(new View.OnClickListener() {
        	 
            @Override
            public void onClick(View v) {
                // TODO Auto-generated method stub
            	mPosition = (mPosition + 2)% TEXTS.length;
            	mTextSwitcher.setText(TEXTS[mPosition]);
            	new DownLoadImage(mImageSwitcher).execute(IMAGES[mPosition]);
  		
            }
        });
        
    	
        return v;
    }

    //download image from internet
    private class DownLoadImage extends AsyncTask<String, Integer, Bitmap> {
        ImageSwitcher imageSwitcher;
        public DownLoadImage(ImageSwitcher is) {
             
            this.imageSwitcher = is;
            }
         protected Bitmap doInBackground(String... urls) {
            
             String url =urls[0];

             Bitmap tmpBitmap = null; 
             try {
             InputStream is = new java.net.URL(url).openStream();
             tmpBitmap = BitmapFactory.decodeStream(is);
             is.close();
             } catch (Exception e) {
            	 e.printStackTrace();
             }
             return tmpBitmap;
             
         }

        protected void onPostExecute(Bitmap result) {

             //Bitmap to Drawable
             Resources res=getResources();
             Drawable bd=new BitmapDrawable(res,result);
             
             //set Drawable
             imageSwitcher.setImageDrawable(bd);
         }
     }


}
