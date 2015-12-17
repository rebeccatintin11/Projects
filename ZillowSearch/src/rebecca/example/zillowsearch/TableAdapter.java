package rebecca.example.zillowsearch;

import java.util.List;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.graphics.Color;
import android.os.Bundle;
import android.text.Html;
import android.text.method.LinkMovementMethod;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.facebook.FacebookException;
import com.facebook.FacebookOperationCanceledException;
import com.facebook.Request;
import com.facebook.Request.GraphUserCallback;
import com.facebook.Response;
import com.facebook.Session;
import com.facebook.SessionState;
import com.facebook.model.GraphUser;
import com.facebook.widget.WebDialog;
import com.facebook.widget.WebDialog.OnCompleteListener;

public class TableAdapter extends BaseAdapter {   

    private List<DataRow> table;  
    private LayoutInflater inflater; 
    private Activity context;
    private boolean isFetching = false;
    

    public TableAdapter(Activity context, List<DataRow> table) {  

        this.table = table;  
        this.inflater = LayoutInflater.from(context); 
        this.context = context;
    }  

	@Override  
    public int getCount() {  
        return table.size();  
    }  
    @Override  
    public long getItemId(int position) {  
        return position;  
    }  
    public DataRow getItem(int position) {  
        return table.get(position);  
    }  
    public View getView(int position, View convertView, ViewGroup parent) {  
        DataRow person = (DataRow) this.getItem(position);  
        ViewHolder viewHolder = new ViewHolder();  
        if(convertView == null){  
            
            convertView = inflater.inflate(R.layout.list_item, null);  
            
            convertView.setTag(viewHolder);  
        }else{  
            viewHolder = (ViewHolder) convertView.getTag(); 
            
        }  
        viewHolder.mTextName = (TextView) convertView.findViewById(R.id.text_name);  
        viewHolder.mTextValue = (TextView) convertView.findViewById(R.id.text_value);
        viewHolder.mButton = (Button) convertView.findViewById(R.id.shareButton);

        //set strip color
        int[] colors = { Color.WHITE, Color.rgb(219, 238, 244) };
        
        viewHolder.mTextName.setBackgroundColor(colors[(position+1) % 2]);
        viewHolder.mTextValue.setBackgroundColor(colors[(position+1) % 2]);

        //construct table
        
        if(position==18){
        	viewHolder.mTextName.setVisibility(View.GONE);
        	viewHolder.mTextValue.setVisibility(View.GONE);
        }
        if(person.getWithLink()==1){
        	viewHolder.mTextName.setText(Html.fromHtml("<a href=\""+person.getLink()+"\">"+person.getName()+"</a>")); 
        	viewHolder.mTextName.setMovementMethod(LinkMovementMethod.getInstance());
        	
        }else{
        	viewHolder.mTextName.setText(person.getName()); 
        }
        
        if(person.getValue()==null){
        	//first two row
        	viewHolder.mTextValue.setVisibility(View.GONE);
        	
        	//the row of see details
        	if(person.getWithLink()==0){
        		//is the row of see details
        		viewHolder.mButton.setVisibility(View.VISIBLE);
        		viewHolder.mTextName.setBackgroundColor(colors[0]);
        		
        	}
            
        }else{
        	viewHolder.mTextValue.setText(person.getValue()); 
        }
        
        if(person.getImage()!=null){
        	if(person.getImage().equals("+")){
        		viewHolder.mTextValue.setCompoundDrawablesRelativeWithIntrinsicBounds(R.drawable.up_g, 0, 0, 0);
        		
        	}else if(person.getImage().equals("-")){
        		viewHolder.mTextValue.setCompoundDrawablesRelativeWithIntrinsicBounds(R.drawable.down_r, 0, 0, 0);
        		
        	}
        }
        
        viewHolder.mButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
            	
            	// Use the Builder class for convenient dialog construction
                AlertDialog.Builder builder = new AlertDialog.Builder(context);
                builder.setMessage("Post to Facebook")
                .setPositiveButton("Post Property Details", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                 	   FBConnect();

                    }
                })
                .setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                 	   Toast.makeText(context.getApplicationContext(), 
                                "Publish cancelled", 
                                Toast.LENGTH_SHORT).show();
                    }
                });
                // Create the AlertDialog object and return it
                AlertDialog alert = builder.create();
                alert.show();
            	
            }
        });

        return convertView;  
    }  
    public static class ViewHolder{  
        public TextView mTextName;  
        public TextView mTextValue;  
        public Button mButton;
    }  

    
    private void FBConnect(){
    	Log.d("FACEBOOK", "performFacebookLogin");
        
    	Session.openActiveSession(context, true, new Session.StatusCallback()
        {
            @Override
            public void call(Session session, SessionState state, Exception exception)
            {
                Log.d("FACEBOOK", "call");
                if (session.isOpened() && !isFetching)
                {
                    Log.d("FACEBOOK", "if (session.isOpened() && !isFetching)");
                    isFetching = true;
                   
                    Request getMe = Request.newMeRequest(session, new GraphUserCallback()
                    {
                        @Override
                        public void onCompleted(GraphUser user, Response response)
                        {
                            Log.d("FACEBOOK", "onCompleted");
                            if (user != null)
                            {
                                Log.d("FACEBOOK", "user != null");
                                
                                publishFeedDialog();
                                
                            }
                        }
                    });
                    getMe.executeAsync();
                }
                else
                {
                    if (!session.isOpened()){
                        Log.d("FACEBOOK", "!session.isOpened()"+isFetching);
                    }

                }
            }
        });
    }
    
    private void publishFeedDialog() {
    	
    	DataRow address = (DataRow) this.getItem(1);  
    	DataRow LSP = (DataRow) this.getItem(10);  
    	DataRow DOC = (DataRow) this.getItem(13); 
    	DataRow PIC = (DataRow) this.getItem(18); 

        Bundle params = new Bundle();
        params.putString("name", address.getName());
        params.putString("caption", "Property Information from Zillow.com");
        params.putString("description", "Last sold Price:"+LSP.getValue()+", 30 Days Overall Changes:"+DOC.getSign()+DOC.getValue());
        params.putString("link", address.getLink());
        params.putString("picture", PIC.getLink());

        WebDialog feedDialog = (
            new WebDialog.FeedDialogBuilder(context,
                Session.getActiveSession(),
                params))
            .setOnCompleteListener(new OnCompleteListener() {

                @Override
                public void onComplete(Bundle values,
                    FacebookException error) {
                    if (error == null) {
                        // When the story is posted, echo the success
                        // and the post Id.
                        final String postId = values.getString("post_id");
                        if (postId != null) {
                            Toast.makeText(context,
                                "Posted story, id: "+postId,
                                Toast.LENGTH_SHORT).show();
                        } else {
                            // User clicked the Cancel button
                            Toast.makeText(context.getApplicationContext(), 
                                "Publish cancelled", 
                                Toast.LENGTH_SHORT).show();
                            isFetching = false;
                        }
                    } else if (error instanceof FacebookOperationCanceledException) {
                        // User clicked the "x" button
                        Toast.makeText(context.getApplicationContext(), 
                            "Publish cancelled", 
                            Toast.LENGTH_SHORT).show();
                        isFetching = false;
                    } else {
                        // Generic, ex: network error
                        Toast.makeText(context.getApplicationContext(), 
                            "Error posting story", 
                            Toast.LENGTH_SHORT).show();
                        isFetching = false;
                    }
                }

            })
            .build();
        feedDialog.show();
    }

}  