package rebecca.example.zillowsearch;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.util.DisplayMetrics;
import android.util.Log;
import android.widget.TabHost;
import android.widget.TabWidget;
import android.widget.TextView;

import com.facebook.UiLifecycleHelper;
import com.facebook.widget.FacebookDialog;

public class ResultActivity extends FragmentActivity{
	
	private TabHost mTabHost;
    private TabManager mTabManager;

	private UiLifecycleHelper uiHelper;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.tab);
		
		 uiHelper = new UiLifecycleHelper(this, null);
		 uiHelper.onCreate(savedInstanceState);
	  
		//get data from bundle
		Intent it=this.getIntent();
		Bundle bundle=it.getExtras();
		
		mTabHost = (TabHost)findViewById(android.R.id.tabhost);
        mTabHost.setup();
      
        mTabManager = new TabManager(this, mTabHost, R.id.realtabcontent);
        mTabHost.setCurrentTab(0);//default
        mTabManager.addTab(
            mTabHost.newTabSpec("BASIC INFO").setIndicator("BASIC INFO"),
            Info.class, bundle);
        mTabManager.addTab(
            mTabHost.newTabSpec("HISTORICAL ZESTIMATES").setIndicator("HISTORICAL ZESTIMATES"),
            Chart.class, bundle);
        
        DisplayMetrics dm = new DisplayMetrics();   
        getWindowManager().getDefaultDisplay().getMetrics(dm);  
        int screenWidth = dm.widthPixels;
           
           
        TabWidget tabWidget = mTabHost.getTabWidget();
        
        int count = tabWidget.getChildCount();
           
        for (int i = 0; i < count; i++) {   
            tabWidget.getChildTabViewAt(i)
                  .setMinimumWidth((screenWidth)/2);
            TextView tv = (TextView) mTabHost.getTabWidget().getChildAt(i).findViewById(android.R.id.title);
            tv.setTextSize(10);
            
        }   
        
          
		
	}
	
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	    super.onActivityResult(requestCode, resultCode, data);

	    uiHelper.onActivityResult(requestCode, resultCode, data, new FacebookDialog.Callback() {
	        @Override
	        public void onError(FacebookDialog.PendingCall pendingCall, Exception error, Bundle data) {
	            Log.e("Activity", String.format("Error: %s", error.toString()));
	        }

	        @Override
	        public void onComplete(FacebookDialog.PendingCall pendingCall, Bundle data) {
	            Log.i("Activity", "Success!");
	        }
	    });
	}
	
	@Override
	protected void onResume() {
	    super.onResume();
	    uiHelper.onResume();
	}

	@Override
	protected void onSaveInstanceState(Bundle outState) {
	    super.onSaveInstanceState(outState);
	    uiHelper.onSaveInstanceState(outState);
	}

	@Override
	public void onPause() {
	    super.onPause();
	    uiHelper.onPause();
	}

	@Override
	public void onDestroy() {
	    super.onDestroy();
	    uiHelper.onDestroy();
	}
    




}


