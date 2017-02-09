 // global variables
 var globalErrorMessage = "Please try again";

  var jq = $.noConflict(); 
 
	var teststatus = [
	              	{
	              	"ID": "0",
	                  "Name": "Inactive"},
	              	{
	              	"ID": "1",
	                  "Name": "Active"}
	              	];

	
/*the general sucess function 
*/
function SuccessFunction(resp){
	
	if(resp){
	var response= JSON.parse(resp);
	if(response.status==1){
				toastr.success(response.message);
				
				fetchAllData();
			}else if(response.status==2){
				
				toastr.error(response.message);
				
				// calling a fetchAll function by passing 
				fetchAllData();
			}
	}else{
		toastr.error('OOPS something went wrong please try again');
		window.location.reload();
	}
	
	
}

// this function is used fetch all to collects the data 
function fetchAllData(){
			
		var csrfToken = $('meta[name="csrf-token"]').attr("content");

		curl='getcodedata';
		
		
		$.ajax({
        url: curl,
        type: "POST",
		dataType: 'json',
        data: { _csrf:csrfToken },
        success: function(da){
			
    		
			if(da){
				var codedata = da['codedata'];
				var line16 = da['line16'];
				var line14 = da['line14'];
				getcodedetails(codedata,line16,line14);

			}
			
        }
    });
		}
		

// this function is used to save the record to the database

function saveRowToDatabase(info){
		
	curl= "savecodedata";
	
	var newdata =JSON.stringify(info.data);
	
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	
		$.ajax({
        url: curl,
        type: "POST",
        data: { newdata: JSON.parse(newdata,true),_csrf:csrfToken },
        success: function(resp){
			
			SuccessFunction(resp);
		
        },  error: function () { 
		
		toastr.error(globalErrorMessage);
		
		window.location.reload();
		
		}
    }); 
		
}

// this function is used to update the record to the database 
function updateRowToDatabase(info){
		
	curl= "updatecodedata";
	
	var newdata =JSON.stringify(info.newData);

	var olddata =JSON.stringify(info.oldData);

	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	
		 $.ajax({
        url: curl,
        type: "POST",
		//dataType: "json",
        data: { newdata: JSON.parse(newdata,true), olddata: JSON.parse(olddata,true), _csrf:csrfToken },
         success: function(resp){
			
			SuccessFunction(resp);
		
        },  error: function (resp) { 
		
        	toastr.error('Code Combination Exist');
		
		window.location.reload();
		
		}
    }); 
		
}

	
	function getcodedetails(codedata,line16,line14){
	
		jq("#loadGif").hide();
		
		jq("#gridContainer").dxDataGrid({
					dataSource:{ store: {
            type: "array",
      
            data: codedata
        },
		},
		 showColumnLines: true,
    showRowLines: true,
  //  rowAlternationEnabled: true,
    showBorders: true,
				sorting: {
					mode:"multiple"
				},selection: {
     
    }, paging:{
		
	},
	"export": {
        enabled: true,
        fileName: "1095c codes",
     
    },
	searchPanel: {
				visible: true
				},
				columnAutoWidth:false,
				 columnChooser:{
						
						enabled:false,
						width:250,
						height:260
					},
				allowColumnReordering:true,
				allowColumnResizing:true,
				
				filterRow: {
					visible:false
				},
				groupPanel:{
					visible:false
				},
				editing : {
				 allowUpdating: true,
				allowDeleting: false,
				allowAdding: true,
				mode :"row",
				},

				 onRowUpdating: function (info) {
					
				updateRowToDatabase(info);
				},
	 onRowInserting: function (info) {
	 saveRowToDatabase(info);
    },
	onRowInserted: function (newRow) { },
	onRowRemoving: function (info) {
        deletePayrollEmployee(info,encoded_company_id);
    },


	columns: [
	
        {
            dataField: "line_14",
			lookup: {
                dataSource: line14,
                displayExpr: "lookup_value",
                valueExpr: "lookup_id"
            },
            validationRules: [{ type: "required" }],
			 message: "Line 14 code required."
        },{
            dataField: "line_16",
			lookup: {
                dataSource: line16,
                displayExpr: "lookup_value",
                valueExpr: "lookup_id"
            },
            
       
        }, {
            dataField: "code_combination",
            
			caption:'Code Combination',
			//   validationRules: [{ type: "required" }],
			
           
        },{
            dataField: "employers_organizations",
			caption:'Meaning to Employers',
			//   validationRules: [{ type: "required" }],
			  
           
        },{
            dataField: "individuals_families",
			caption:'Meaning to individuals and families',
			
            //validationRules: [{ type: "required" }],
        },
        {
        dataField: "status",
        lookup: {
        	 dataSource: teststatus,
             displayExpr: "Name",
             valueExpr: "ID"
        },
        validationRules: [{ type: "required" }]
    }
    ]
			}).dxDataGrid("instance");
	}
	
	