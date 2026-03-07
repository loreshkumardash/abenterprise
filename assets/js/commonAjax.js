// JavaScript Document
/**********************************/
/*document use to call all ajax functions*/
/*author :- Cakiweb				*/
/*	on :- 30-11-2019				*/				
/**********************************/

function loadAllclass(ctrlId,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/loadAllclass',
			dataType:'json',
			data:{},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].class_id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].class_id+'" '+selected+'>'+datares[i].class_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}


function loadsubJect(ctrlId,classId = 0,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/loadsubJect',
			dataType:'json',
			data:{classId:classId},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].subject_id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].subject_id+'" '+selected+'>'+datares[i].subject_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}

function loadTaggedClass(ctrlId,teacherId,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/lessionplan/loadTaggedclass',
			dataType:'json',
			data:{teacherId:teacherId},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].class_id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].class_id+'" '+selected+'>'+datares[i].class_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}


function loadTaggedSubject(ctrlId,classId,teacherId,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/lessionplan/loadTaggedSubject',
			dataType:'json',
			data:{classId:classId,teacherId:teacherId},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].subject_id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].subject_id+'" '+selected+'>'+datares[i].subject_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}

function loadMasterBank(ctrlId,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/loadMasterBank',
			dataType:'json',
			data:{},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.res;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].bank_id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].account_no+'" '+selected+'>'+datares[i].account_no+'  ('+datares[i].bank_name+')</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}

function studentphnNo(ctrlId,student_id){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/studentphnNo',
			dataType:'json',
			data:{student_id:student_id},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<input type="hidden" name="phn_no" id="phn_no" class="form-control" value="">';
					$.each(datares, function(i){
					    bindData += '<input type="text" name="phn_no" id="phn_no" class="form-control" value="'+datares[i].student_mobile+'" readonly>';	  
					  
					});
					
				}else{
					bindData += '<input type="hidden" name="phn_no" id="phn_no" class="form-control" value="">';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}

function loadDays(ctrlId,selectedId = 0){
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadDays',
		dataType:'json',
		data:{},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.res;
				bindData += '<option value="">-- Select --</option>';
				$.each(datares, function(i){
				  var selected = (selectedId > 0 && datares[i].id == selectedId)?'selected':'';
				  bindData += '<option value="'+datares[i].id+'" '+selected+'>'+datares[i].day+'</option>';
				});				
			}else{
				bindData += '<option value="">-Select-</option>';
			}			
			$('#'+ctrlId).html(bindData);
		}
	});	
}

function loadTaggedEmployee(ctrlId, subjectId = 0, selectedId = 0){
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadTaggedEmployee',
		dataType:'json',
		data:{subjectId:subjectId},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.res;
				//console.log(datares);
				bindData += '<option value="">-Select-</option>';
				$.each(datares, function(i){
				   var selected = (selectedId > 0 && datares[i].emp_id == selectedId)?'selected':'';				  
				  bindData += '<option value="'+datares[i].employee_id+'" '+selected+'>'+datares[i].employee_name+'</option>';
				});
				
			}else{
				bindData += '<option value="">-Select-</option>';
			}
			
			
			$('#'+ctrlId).html(bindData);
		}
	});	
}

function loadsection(ctrlId, classId = 0, selectedId = 0){
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadsection',
		dataType:'json',
		data:{classId:classId},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.res;
				//console.log(datares);
				bindData += '<option value="">-Select-</option>';
				$.each(datares, function(i){
				   var selected = (selectedId > 0 && datares[i].section_id == selectedId)?'selected':'';				  
				  bindData += '<option value="'+datares[i].section_id+'" '+selected+'>'+datares[i].section_name+'</option>';
				});
				
			}else{
				bindData += '<option value="">-Select-</option>';
			}
			
			
			$('#'+ctrlId).html(bindData);
		}
	});	
}

function Getsection(ctrlId, classId = 0, selectedId = 0){
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/Getsection',
		dataType:'json',
		data:{classId:classId},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.res;
				//console.log(datares);
				bindData += '<option value="">-Select-</option>';
				$.each(datares, function(i){
				   //var selected = (selectedId > 0 && datares[i].section_id == selectedId)?'selected':'';				  
				  bindData += '<option value="'+datares[i].section_id+'">'+datares[i].section_name+'</option>';
				});
				
			}else{
				bindData += '<option value="">-Select-</option>';
			}
			
			
			$('#'+ctrlId).html(bindData);
		}
	});	
}



function loadTaggedSection(ctrlId,classId,teacherId,selectedId = 0){
	if(classId > 0){
		$.ajax({
			method:'post',
			url: appUrl+'/lessionplan/loadTaggedSection',
			dataType:'json',
			data:{classId:classId,teacherId:teacherId},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].section_id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].section_id+'" '+selected+'>'+datares[i].section_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});
	}	
}

function get_TotalRooms(ctrlId,hostel_id=0){
	//alert('hostel_id');
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/get_TotalRooms',
			dataType:'json',
			data:{hostel_id:hostel_id},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.res;
					bindData += '<input type="hidden" class="form-control form-control-sm" name="no_of_rooms" id="no_of_rooms">';
					$.each(datares, function(i){
					   //var selected = (selectedId > 0 && datares[i].department_id == selectedId)?'selected':'';				  
					  bindData += '<input type="text" class="form-control form-control-sm" name="no_of_rooms" id="no_of_rooms" readonly value="'+datares[i].rooms+'">';
					});
					
				}else{
					bindData += '<input type="text" class="form-control form-control-sm" name="no_of_rooms" id="no_of_rooms">';
				}				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}


function get_roomname(ctrlId,ctrlId2,hostel_id=0,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/get_roomname',
			dataType:'json',
			data:{hostel_id:hostel_id},
			success:function(res){
				var bindData = '';
				var bindData2 = '';
				if(res.status == 200){
					var datares = res.res;
					bindData += '<option value="">-Select-</option>';
					bindData2 += '<input type="hidden" class="form-control form-control-sm" name="bed" id="bed">';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].id+'" '+selected+'>'+datares[i].room_name+'</option>';
					  bindData2 += '<input type="text" class="form-control form-control-sm" readonly name="bed" id="bed" value="'+datares[i].beds+'">';
				
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
					bindData2 += '<input type="hidden" class="form-control form-control-sm" name="bed" id="bed">';
				}
				
				
				$('#'+ctrlId).html(bindData);
				$('#'+ctrlId2).html(bindData2);
			}
		});	
}

function loadHostels(ctrlId,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/loadHostels',
			dataType:'json',
			data:{},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.res;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].id+'" '+selected+'>'+datares[i].name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}


function loadRooms(ctrlId,hostelId = 0,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/loadRooms',
			dataType:'json',
			data:{hostelId:hostelId},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].id+'" '+selected+'>'+datares[i].room_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}


function loadBeds(ctrlId,roomId = 0,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/loadBeds',
			dataType:'json',
			data:{roomId:roomId},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].id+'" '+selected+'>'+datares[i].bed_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}

function checkAvail(configId = 0){
	var assigned_hostel = $('#assigned_hostel').val();
	var assigned_room   = $('#assigned_room').val();
	var assigned_bed    = $('#assigned_bed').val();
	if(assigned_hostel > 0 && assigned_room > 0 && assigned_bed > 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/checkAvail',
			dataType:'json',
			data:{assigned_hostel:assigned_hostel, assigned_room:assigned_room, assigned_bed:assigned_bed,configId:configId},
			success:function(res){
				if(res.status == 200 && res.allocation == 1){
					$('.appendMsg').html('<span class="badge badge-success">Selected Bed Available</span>');
					$('#submitBtn').attr("disabled",false);
				}else if(res.status == 200 && res.allocation == 2){
					$('.appendMsg').html('<span class="badge badge-warning">Sorry !! The selected bed not available plese select bed between '+res.bedavailList+'</span>');
					$('#submitBtn').attr("disabled",true);
				}else if(res.status == 200 && res.allocation == 3){
					$('.appendMsg').html('<span class="badge badge-danger">Sorry !! No bed available.</span>');
					$('#submitBtn').attr("disabled",true);
				}else{
					$('.appendMsg').html('');
					$('#submitBtn').attr("disabled",true);
				}
			}
		});	
	}
}

function loadAllEmployee(ctrlId,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/loadAllEmployee',
			dataType:'json',
			data:{},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.res;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].user_id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].employee_id+'" '+selected+'>'+datares[i].employee_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}

function loadAllroute(ctrlId,selectedId = 0){
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadAllroute',
		dataType:'json',
		data:{},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.result;
				bindData += '<option value="">-Select-</option>';
				$.each(datares, function(i){
				   var selected = (selectedId > 0 && datares[i].trans_id == selectedId)?'selected':'';				  
				  bindData += '<option value="'+datares[i].trans_id+'" '+selected+'>'+datares[i].route_name+'</option>';
				});
				
			}else{
				bindData += '<option value="">-Select-</option>';
			}
			
			
			$('#'+ctrlId).html(bindData);
		}
	});
}




function loadStoppage(ctrlId,routeId = 0,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/loadStoppage',
			dataType:'json',
			data:{routeId:routeId},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].stpg_id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].stpg_id+'" '+selected+'>'+datares[i].stoppage_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}



function loadconductorroute(ctrlId,conductorId = 0,selectedId = 0){
		$.ajax({
			method:'post',
			url: appUrl+'/Ajax_requests/loadconductorroute',
			dataType:'json',
			data:{conductorId:conductorId},
			success:function(res){
				var bindData = '';
				if(res.status == 200){
					var datares = res.result;
					bindData += '<option value="">-Select-</option>';
					$.each(datares, function(i){
					   var selected = (selectedId > 0 && datares[i].trans_id == selectedId)?'selected':'';				  
					  bindData += '<option value="'+datares[i].trans_id+'" '+selected+'>'+datares[i].route_name+'</option>';
					});
					
				}else{
					bindData += '<option value="">-Select-</option>';
				}
				
				
				$('#'+ctrlId).html(bindData);
			}
		});	
}



function loadStudentList(stoppage_id,selectedId = 0){
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadStudentList',
		dataType:'json',
		data:{stoppage_id:stoppage_id},
		success:function(res){
			var bindData = '';
			$('.student-data').show();
			if(res.status == 200){
				var datares = res.result;
				$.each(datares, function(i){
				    bindData +='<tr class="addTr">';
                    bindData +='<td><label class="lblSlNo">'+(i+1)+'</label></td>';
                    bindData +='<td><input type="hidden" name="hdnstudId[]" value="'+datares[i].student_id+'"><input type="hidden" name="hdnatten_id[]" value="'+datares[i].atten_id+'">'+datares[i].student_first_name+' '+datares[i].student_last_name+'</td>';
                    /****************pickup**************************/
                    bindData +='<td>';
                    bindData +='<select class="form-control" name="pickup[]">';
                    if(datares[i].pickup_status == 1){
                    	bindData +='<option value="1" selected>Yes</option>';
                    }else{
                    	bindData +='<option value="1">Yes</option>';
                    }

                    if(datares[i].pickup_status == 2){
                    	bindData +='<option value="2" selected>No</option>';
                    }else{
                    	bindData +='<option value="2">No</option>';
                    }
                    bindData +='</select>';
                    bindData +='</td>';
                    /*******************pickup******************************/

                    /****************dropup**************************/
                    bindData +='<td>';
                    bindData +='<select class="form-control" name="dropup[]">';
                    if(datares[i].dropup_status == 1){
                    	bindData +='<option value="1" selected>Yes</option>';
                    }else{
                    	bindData +='<option value="1">Yes</option>';
                    }

                    if(datares[i].dropup_status == 2){
                    	bindData +='<option value="2" selected>No</option>';
                    }else{
                    	bindData +='<option value="2">No</option>';
                    }
                    bindData +='</select>';
                    bindData +='</td>';
                    /*******************dropup******************************/
                    bindData +='<td class="center"><textarea name="rmrkval[]" maxlength="140">'+datares[i].remark+'</textarea></td>';
                    bindData +='</tr>';
				});
				console.log(bindData)
				$('#submitBtn').attr('disabled',false);
			}else{
				alert("Sorry No Student Found!!");
				bindData += '';
			}
			
			
			$('#appendTr').html(bindData);
		}
	});	
}



function loadconductoragainstroute(ctrlId,routeId = 0,selectedId = 0){
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadconductoragainstroute',
		dataType:'json',
		data:{routeId:routeId},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.result;
				bindData += '<option value="">-Select-</option>';
				$.each(datares, function(i){
				   var selected = (selectedId > 0 && datares[i].conductor_id == selectedId)?'selected':'';				  
				  bindData += '<option value="'+datares[i].conductor_id+'" '+selected+'>'+datares[i].firstname+' '+datares[i].lastname+'</option>';
				});
				
			}else{
				bindData += '<option value="">-Select-</option>';
			}
			
			
			$('#'+ctrlId).html(bindData);
		}
	});	
}




function loadstudagainststoppage(ctrlId,stoppage_id = 0,selectedId = 0){
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadstudagainststoppage',
		dataType:'json',
		data:{stoppage_id:stoppage_id},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.result;
				bindData += '<option value="">-Select-</option>';
				$.each(datares, function(i){
				   var selected = (selectedId > 0 && datares[i].conductor_id == selectedId)?'selected':'';				  
				  bindData += '<option value="'+datares[i].conductor_id+'" '+selected+'>'+datares[i].student_first_name+' '+datares[i].student_last_name+'</option>';
				});
				
			}else{
				bindData += '<option value="">-Select-</option>';
			}
			
			
			$('#'+ctrlId).html(bindData);
		}
	});	
}

function loadstudentagainstclass(ctrlId,class_id = 0,session_id ='',selectedId = 0){
	$('#'+ctrlId).html('');
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadstudentagainstclass',
		dataType:'json',
		data:{class_id:class_id,session_id:session_id},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.result;
				
				$.each(datares, function(i){	  
				  bindData += '<tr>';
				  bindData += '<td>'+datares[i].student_id+'</td>';
				  bindData += '<td><input type="checkbox" class="stud_ids" name="stud_ids[]" value="'+datares[i].student_id+'"/></td>';
				  bindData += '<td>'+datares[i].student_first_name+' '+datares[i].student_last_name+'</td>';
				  bindData += '<td>'+datares[i].student_gender+'</td>';
				  bindData += '<td>'+datares[i].student_mobile+'</td>';
				  bindData += '<td>'+datares[i].father_name+'</td>';
				  bindData += '<td>'+datares[i].mother_name+'</td>';
				  bindData += '<td>'+datares[i].guardian_name+'<br>'+datares[i].guardian_contact_no+'</td>';
				  bindData += '</tr>';
				});
				
			}else{
				bindData += '<tr><td colspan="8">Sorry!! No record found</td></tr>';
			}
			
			
			$('#'+ctrlId).html(bindData);
		}
	});	
}

function loadStoppagecheck(ctrlId,routeId = 0,selectedId = 0){
	if($('#sel_vehicle').val() == ''){
		alert('Please select Vehicle');
		$('#sel_route').val("");
		return false;
	}
	var sel_vehicle = $('#sel_vehicle').val();
	$('#hdnActionval').val('A');
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadStoppagecheck',
		dataType:'json',
		data:{routeId:routeId,sel_vehicle:sel_vehicle},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.result;
				$('.check-stoppage').show();
				var existId = 0;
				var checkedArr = [];
				if(res.existedData != ''){
					//console.log(res.existedData['set_id'])
					existId = res.existedData['set_id'];
					checkedArr = res.existedData['chkstpg'].split(',');
					$('#hdnActionval').val('U');
				}
				bindData += '<input type="hidden" name="hdnchkId" id="hdnchkId" value="'+existId+'">';
				$.each(datares, function(i){
				  var checked = '';
				  if(checkedArr.length > 0)	{
				  	if(jQuery.inArray(datares[i].stpg_id, checkedArr) != -1) {
					    checked = 'checked';
					}
				  }
				  bindData += '<input type="checkbox" name="chkstpg[]" '+checked+' value="'+datares[i].stpg_id+'">'+datares[i].stoppage_name;
				});
				
			}else{
				bindData += '';
				$('.check-stoppage').hide();
			}
			
			$('#'+ctrlId).html(bindData);
		}
	});	
}



function loadvehicleagainstroute(ctrlId,routeId = 0,selectedId = 0){
	$('#chk-data').html('');
	$.ajax({
		method:'post',
		url: appUrl+'/Ajax_requests/loadvehicleagainstroute',
		dataType:'json',
		data:{routeId:routeId},
		success:function(res){
			var bindData = '';
			if(res.status == 200){
				var datares = res.result;
				bindData += '<option value="">-Select-</option>';
				$.each(datares, function(i){
				   var selected = (selectedId > 0 && datares[i].vehicle_id == selectedId)?'selected':'';				  
				  bindData += '<option value="'+datares[i].vehicle_id+'" '+selected+'>'+datares[i].registration_no+'</option>';
				});
				
			}else{
				bindData += '<option value="">-Select-</option>';
			}
			
			
			$('#'+ctrlId).html(bindData);
		}
	});	
}
