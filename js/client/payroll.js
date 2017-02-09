 // global variables
 var globalErrorMessage = "Please try again";

  var jq = $.noConflict(); 
 
	var Ftstatus = [
	{
	"ID": "1",
    "Name": "FT"},
	{
	"ID": "2",
    "Name": "PT"}
	];
	
	
//add inconsistance contribution 
function addInconsistancecontribution($employeeid){
 curl= "payroll/updateinconsistancecontribution";
 
 
 var datastr = $('#inconsistance_contribution_'+$employeeid).serialize();
   datastr += '&employee_id=' + $employeeid   ;//+ '&elementname=' + elementname; 
   var csrfToken = $('meta[name="csrf-token"]').attr("content");
   datastr += '&_csrf ='+csrfToken;
  
  // alert($companyid);
 
  $.ajax({
         url: curl,
         type: "post",
   //dataType: "json",
         data: datastr,
          success: function(resp){
    
    PayrollSuccessFunction(resp,encrypt_company_id);
   
         },  error: function () { 
   
   toastr.error(globalErrorMessage);
   
   window.location.reload();
   
   }
     }); 
}


	
/*the general sucess function 
*/
function PayrollSuccessFunction(resp,id){
	
	if(resp){
	var response= JSON.parse(resp);
	if(response.status==1){
				toastr.success(response.message);
				
				// calling a fetchAllEmployees function by passing the company id to refresh the dx data grid
				fetchAllEmployees(id);
			}else if(response.status==2){
				
				toastr.error(response.message);
				
				// calling a fetchAllEmployees function by passing the company id to refresh the dx data grid
				fetchAllEmployees(id);
			}
	}else{
		toastr.error('OOPS something went wrong please try again');
		window.location.reload();
	}
	
	
}

// this function is used fetch all the employee details for payroll screen by passing the company id to the payrolldata function and collects the data 
function fetchAllEmployees(id){
			
		var csrfToken = $('meta[name="csrf-token"]').attr("content");

		curl='payroll/payrolldata';
		$.ajax({
        url: curl,
        type: "POST",
		dataType: 'json',
        data: { c_id: id,_csrf:csrfToken },
        success: function(da){
			// calling a getpayrolldetails function by passing the employee details for dx data grid
			//console.log(da.employ);
			if(da){
				var emp= JSON.parse(da.employ);
				var suf = JSON.parse(da.suffix);
				var planclass = JSON.parse(da.planclass);
				getpayrolldetails(emp,suf,planclass,id);

			}
			
        }
    });
		}
		

// this function is used to save the record to the database by passing the company id and the data 
//to the newemployee function in the payroll controller and collects the response 
function saveRowToDatabase(info,id){
		//console.log(data);
		//return false;
	curl= "payroll/newemployee";
	
	var newdata =JSON.stringify(info.data);
	
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	
		$.ajax({
        url: curl,
        type: "POST",
        data: { newdata: JSON.parse(newdata,true), company_id: id, _csrf:csrfToken },
        success: function(resp){
			
			PayrollSuccessFunction(resp,id);
		
        },  error: function () { 
		
		toastr.error(globalErrorMessage);
		
		window.location.reload();
		
		}
    }); 
		
}

// this function is used to update the record to the database by passing the company id and the data 
//to the updateemployee function in the payroll controller and collects the response
function updateRowToDatabase(info,id){
		//console.log(data);
		//return false;
	curl= "payroll/updateemployee";
	
	var newdata =JSON.stringify(info.newData);

	var olddata =JSON.stringify(info.oldData);

	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	
		 $.ajax({
        url: curl,
        type: "POST",
		//dataType: "json",
        data: { newdata: JSON.parse(newdata,true), olddata: JSON.parse(olddata,true), company_id: id, _csrf:csrfToken },
         success: function(resp){
			 
			PayrollSuccessFunction(resp,id);
		
        },  error: function () { 
		
		toastr.error(globalErrorMessage);
		
		window.location.reload();
		
		}
    }); 
		
}



// this function is used to delete the record to the database by passing the data
//to the updateemployee function in the payroll controller and collects the response
function deletePayrollEmployee(info,id){
	
	curl= "payroll/deletepayrollemployee";
	
	var olddata =JSON.stringify(info.data);
	
	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	
		 $.ajax({
        url: curl,
        type: "POST",
		//dataType: "json",
        data: { record: JSON.parse(olddata,true), _csrf:csrfToken },
        success: function(resp){
			
			PayrollSuccessFunction(resp,id);
			
        },  error: function () { 
		
		toastr.error(globalErrorMessage);
		
		window.location.reload();
		
		}
	});
	
}


/**
     * This function is used to pass the employment period data of the particular employee details 
     * to the addemploymentperiod function in the payroll controller and collects the response
     */
function addEmploymentPeriod(employees,info,id){
	
	curl= "payroll/addemploymentperiod";
	 
	var employedetails =JSON.stringify(employees);
	
	//var employedetails = employees;
	var newdetails =JSON.stringify(info.data);

	var csrfToken = $('meta[name="csrf-token"]').attr("content");
	
	
		 $.ajax({
        url: curl,
        type: "POST",
		//dataType: "json",
        data: { employee_details: JSON.parse(employedetails,true), record: JSON.parse(newdetails,true), _csrf:csrfToken },
        success: function(resp){
			
			PayrollSuccessFunction(resp,id);
			
        },  error: function () { 
		
		toastr.error(globalErrorMessage);
		
		window.location.reload();
		
		}
    }); 
		
}

/**
     * This function is used to pass the employment period data of the particular employee details 
     * to the updateemploymentperiod function in the payroll controller and collects the response
     */
function updateEmploymentPeriod(info,id){
		//console.log(data);
		//return false;
	curl= "payroll/updateemploymentperiod";
	// console.log(employees);
//	 console.log(info);
	 var csrfToken = $('meta[name="csrf-token"]').attr("content");
	 
	var olddata =JSON.stringify(info.oldData);
	
	//var employedetails = employees;
	var newdetails =JSON.stringify(info.newData);

	//console.log(newdetails);
	
		 $.ajax({
        url: curl,
        type: "POST",
		//dataType: "json",
        data: { oldrecord: JSON.parse(olddata,true), newrecord: JSON.parse(newdetails,true), _csrf:csrfToken },
        success: function(resp){
			
			PayrollSuccessFunction(resp,id);
			
        },error: function () { 
		
		toastr.error(globalErrorMessage);
		
		window.location.reload();
		
		}
    }); 
			
}

/**
     * This function is used to pass the employment period data of the particular employee details 
     * to the deleteemploymentperiod function in the payroll controller and collects the response
     */
function deleteEmploymentPeriod(info,id){
		curl= "payroll/deleteemploymentperiod";
	// console.log(employees);
	 //console.log(info);
	 var csrfToken = $('meta[name="csrf-token"]').attr("content");
	 
	var olddata =JSON.stringify(info.data);
	
	//var employedetails = employees;
	//var newdetails =JSON.stringify(info.newData);

	//console.log(newdetails);
	
		 $.ajax({
        url: curl,
        type: "POST",
		//dataType: "json",
        data: { record: JSON.parse(olddata,true), _csrf:csrfToken },
        success: function(resp){
			
			PayrollSuccessFunction(resp,id);
			
        },  error: function () { 
		
		toastr.error(globalErrorMessage);
		
		window.location.reload();
		
		}
	});
	
}


	
	function getpayrolldetails(employees,suffix,planclasses,encoded_company_id){
		jq("#loadGif").hide();
		
	//	if(!payroll_permission){payroll_permission=false;}
		
		jq("#gridContainer").dxDataGrid({
					dataSource:{ store: {
            type: "array",
         //   key: "ID",
		
            data: employees
        },
		},
		 showColumnLines: true,
    showRowLines: true,
  //  rowAlternationEnabled: true,
    showBorders: true,
				sorting: {
					mode:"multiple"
				},selection: {
        // ...
	//	dataSource:"always",
       //mode:"multiple"
    }, paging:{
		// pageSize:2
	},
	"export": {
        enabled: false,
        fileName: "Employees",
      //  allowExportSelectedData: true
    },
	searchPanel: {
				visible: true
				},
	columnAutoWidth: true,
				allowColumnReordering:true,
				allowColumnResizing:true,
				filterRow: {
					visible:false
				},
				groupPanel:{
					visible:false
				},
				editing : {
				 allowUpdating: payroll_permission,
				allowDeleting: payroll_permission,
				allowAdding: payroll_permission,
				mode :"row",
				},
				 onRowUpdating: function (info) {
					
				updateRowToDatabase(info,encoded_company_id);
				},
	 onRowInserting: function (info) {
	 saveRowToDatabase(info,encoded_company_id);
    },
	onRowInserted: function (newRow) { },
	onRowRemoving: function (info) {
        deletePayrollEmployee(info,encoded_company_id);
    },
//	onRowPrepared: function (info) {
		//console.log(info);
           // if (info.rowType != "header" && info.data.year > 1800 && info.data.year <= 1900)
             //   info.rowElement.addClass("nineteenthCentury");
    //    },
	onEditorPreparing: function(e) {
    if (e.parentType == 'zip') {
        e.editorOptions.maxLength = 5;
    }
},
	
	columns: [
	{
            dataField: "first_name",
			caption:'First Name',
			editorOptions: { maxLength: 15 },
			setCellValue:function(rowData, value){
				rowData.first_name=characters(value);
			},
            validationRules: [{ type: "required" }]
        },{
            dataField: "middle_name",
			caption:'M.I',
			editorOptions: { maxLength: 2 },
			setCellValue:function(rowData, value){
				
				rowData.middle_name=characters(value);
			},
          //  validationRules: [{ type: "required" }]
        }, {
            dataField: "last_name",
			caption:'Last Name',
			editorOptions: { maxLength: 15 },
			setCellValue:function(rowData, value){
				
				rowData.last_name=characters(value);
			},
            validationRules: [{ type: "required" }]
        },{
            dataField: "suffix",
			lookup: {
                dataSource: suffix,
                displayExpr: "lookup_value",
                valueExpr: "lookup_id"
            },
         //   validationRules: [{ type: "required" }],
		//	 message: "Required."
        },{
            dataField: "ssn",
			caption:'SSN',
			editorOptions: { maxLength: 9 },
			validationRules: [
			 { type: "required" }, 
			{
                type: "pattern",
                message: 'SSN should be 9 digits',
                pattern: /^\d{9}$/i 
            }]
         //   validationRules: [{ type: "required" }]
        },{
            dataField: "address1",
			editorOptions: { maxLength: 30 },
			setCellValue:function(rowData, value){
				if(value){
				rowData.address1=addressValidate(value);
				}
			},
         //   validationRules: [{ type: "required" }]
        },{
            dataField: "apt_suite",
			caption:'Apt Suite#',
			editorOptions: { maxLength: 30 },
			setCellValue:function(rowData, value){
				if(value){
				rowData.apt_suite=addressValidate(value);
				}
			},
         //   validationRules: [{ type: "required" }]
        }, {
            dataField: "city",
			editorOptions: { maxLength: 20 },
			setCellValue:function(rowData, value){
				var r = value.replace(new RegExp("[0-9]", "g"), "");
				rowData.city=r.replace(/[^\w\s]/gi, '');
			},
         //   validationRules: [{ type: "required" }]
        }, {
            dataField: "state",
		
			editorOptions: {
            maxLength: 2
			
        },
         //   validationRules: [{ type: "required" }]
		 
			setCellValue:function(rowData, value){
				
				rowData.state=characters(value);
			},
			
		 
        },{
            dataField: "zip",
			caption:'ZIP',
		//	editorOptions: { maxlength: 5 },
			//dataType: 'number',
			validationRules: [
			// { type: "required" }, 
			{
                type: "pattern",
                message: 'ZIP should be 5 digits',
                pattern: /^\d{5}$/i 
            }]
         //   validationRules: [{ type: "required" }]
        },{
            dataField: "dob",
			caption:'DOB',
			dataType: 'date',
		//	format: 'shortDate',
      //      validationRules: [{ type: "required" }]
        },{
            dataField: "notes"
         //   validationRules: [{ type: "required" }]
        }
    ],  masterDetail: {
        enabled: true,
		highlightTitle: false,
        template: function(container, options) { 
            var currentEmployeeData = options.data;
            container.addClass("internal-grid-container");
			
			if(contribution_table){
			var table='<div class="table-responsive">Inconsistent Employee Contribution<br/><form id="inconsistance_contribution_'+currentEmployeeData.employee_id+'"><table class="table table-condensed table-striped table-bordered"><thead>'
			+'<tr><th class="dx-datagrid-headers">Jan</th> <th class="dx-datagrid-headers">Feb</th> <th class="dx-datagrid-headers">Mar</th>'
			+'<th class="dx-datagrid-headers">Apr</th> <th class="dx-datagrid-headers">May</th> <th class="dx-datagrid-headers">Jun</th>'
			+'<th class="dx-datagrid-headers">Jul</th> <th class="dx-datagrid-headers">Aug</th> <th class="dx-datagrid-headers">Sep</th>'
			+'<th class="dx-datagrid-headers">Oct</th> <th class="dx-datagrid-headers">Nov</th> <th class="dx-datagrid-headers">Dec</th> <th></th></tr> </thead>'
			+'<tbody><tr>'
			+'<td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[january] value="'+currentEmployeeData.january+'"></td> <td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[febuary] value="'+currentEmployeeData.febuary+'"></td> <td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[march] value="'+currentEmployeeData.march+'"></td> <td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[april] value="'+currentEmployeeData.april+'"></td>'
			+'<td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[may] value="'+currentEmployeeData.may+'"></td> <td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[june] value="'+currentEmployeeData.june+'"></td> <td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[july] value="'+currentEmployeeData.july+'"></td> <td><input type="number" name=TblAcaPayrollInconsistentContribution[august] min="0" max="99999999" value="'+currentEmployeeData.august+'"></td>'
			+'<td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[september] value="'+currentEmployeeData.september+'"></td> <td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[october] value="'+currentEmployeeData.october+'"></td> <td><input type="number" min="0" max="99999999" name=TblAcaPayrollInconsistentContribution[november] value="'+currentEmployeeData.november+'"></td> <td><input type="number" name=TblAcaPayrollInconsistentContribution[december] min="0" max="99999999" value="'+currentEmployeeData.december+'"></td>'
			+'<td><a href="#" onclick="addInconsistancecontribution('+currentEmployeeData.employee_id+');" >Update</a></td></tr></tbody></table></form></div>';
		
		container.append($(table));
			}
			
			
            jq("<div>").text("Employment Period").appendTo(container);            
            jq("<div>")
                .addClass("internal-grid")
                .dxDataGrid({
					editing : {
				 allowUpdating: payroll_permission,
				allowDeleting: payroll_permission,
				allowAdding: payroll_permission,
				mode :"row",
				},
				showColumnLines: true,
		showRowLines: true,
		 showBorders: true,
				"export": {
        enabled: false,
        fileName: "Employment_record",
      //  allowExportSelectedData: true
    },
	columnAutoWidth: true,
				allowColumnReordering:true,
				allowColumnResizing:true,
				//onRowPrepared: function (info) {
		//console.log(info);
           // if (info.rowType != "header" && info.data.year > 1800 && info.data.year <= 1900)
             //   info.rowElement.addClass("nineteenthCentury");
    //    },
			onRowValidating: function (e) {
				//console.log(e);
				
				if ((typeof e.newData.hire_date != 'undefined') || (typeof e.oldData != 'undefined' && typeof e.oldData.hire_date != 'undefined')){
					var today = new Date(currentDate());
					var start_date = (e.newData.hire_date === undefined) ? new Date(e.oldData.hire_date) : new Date(e.newData.hire_date);
					var diffdate=datediff(start_date,today);
					if(diffdate<0){
						e.isValid = false;
						toastr.error('Hire date should not be greater than Current date');
					}
					
				}
				
				if ((typeof e.newData.termination_date != 'undefined') || (typeof e.oldData != 'undefined' && (typeof e.oldData.termination_date != 'undefined' && e.oldData.termination_date != null ))){
					var today = new Date(currentDate());
					var end_date = (e.newData.termination_date === undefined) ? new Date(e.oldData.termination_date) : new Date(e.newData.termination_date);
					var diffdate=datediff(end_date,today);
					if(diffdate<0){
						e.isValid = false;
						toastr.error('Termination date should not be greater than Current date');
					}
					
				}
				
				if (typeof start_date != 'undefined' && typeof end_date != 'undefined' && e.newData.termination_date!=null) {
				//var start_date = (e.newData.hire_date === undefined) ? new Date(e.oldData.hire_date) : new Date(e.newData.hire_date);
				//var end_date = (e.newData.termination_date === undefined) ? new Date(e.oldData.termination_date) : new Date(e.newData.termination_date);
				
			
				//console.log(end_date-start_date);
				var diffdate=datediff(start_date,end_date);
				if(diffdate<1){
					e.isValid = false;
					toastr.error('Termination date should be greater than Hire date');
				}
				
				}
          /*  var dataGrid = e.component;
            var rowIndex = dataGrid.getRowIndexByKey(e.key),
                year = (e.newData.year === undefined) ? e.oldData.year : e.newData.year;
 
            if (year > new Date().getFullYear()) {
                e.isValid = false;
                dataGrid.getCellElement(rowIndex, "year").find("input").css("background", "rgba(255, 0, 0, 0.5)");
            }*/
			
			
        },
			//	onInitNewRow: function (e) {
					//console.log(e);
  //  e.data.hire_date = currentDate();
// },
	onRowUpdating: function (info) {
			updateEmploymentPeriod(info,encoded_company_id);
			 },
	onRowInserting: function (info) {
		 addEmploymentPeriod(currentEmployeeData,info,encoded_company_id);
    },
	onRowInserted: function (newRow) {},
	onRowRemoving: function (info) {
        deleteEmploymentPeriod(info,encoded_company_id);
    },
                    columnAutoWidth: true,
                    columns: [ {
                        dataField: "hire_date",
                        dataType: "date",
					
						validationRules: [{ type: "required" }]
						//message: "Required."
                    }, {
                        dataField: "termination_date",
                        dataType: "date",
				//	 setCellValue:function(rowData, value){
			//	console.log(rowData);
			//	rowData.termination_date=value;
		//	}, 
						// validationRules: [{ type: "required" }]
						//message: "Required."
                    },{
                        dataField: "plan_class",
						caption:'Medical Plan Class Name',
						lookup: {
                dataSource: planclasses,
                displayExpr: "plan_class_number",
                valueExpr: "plan_class_id"
            },
                     // validationRules: [{ type: "required" }]
					//	message: "Required." 
					// dataType: "date"
                    },{
                        dataField: "status",
						caption:'FT/PT Status',
						lookup: {
                dataSource: Ftstatus,
                displayExpr: "Name",
                valueExpr: "ID"
            },
			// validationRules: [{ type: "required" }],
						message: "Required."
                       // dataType: "date"
                    },{
                        dataField: "waiting_period",
						caption:'Don"t Apply Waiting Period',
						//validationRules: [{ type: "required" }],
					//	message: "Required.",
                        dataType: "boolean"
                    }],
                    dataSource: currentEmployeeData.employmentperiods
                }).appendTo(container);
        }
    }
			}).dxDataGrid("instance");
	}