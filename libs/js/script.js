
/* function to get current location*/
$(document).ready(function() {

    $('#preloader').fadeOut(2000, function() { $(this).remove(); });
    $("#container").show();
    selectOptions();
    readEmployees();

    //function to populate department options in search form on select of location
    $('#locationOption').change(function(){
        let locationId= $(this).val();
        console.log(locationId);
        $.ajax({
          url: "libs/php/employeeslist.php",
          type: 'POST',
          datatype: 'JSON',
          data: {
            locationId:locationId
          },
          success: function(result) {
            if(result.status!=404){
              html = "<option selected> All Department</option>";
              result.map(department =>{
                html+=`<option value=${department.name.replace(' ', '-')}> 
                          ${department.name}
                      </option>`
              });
           
              $('#departmentOption').html(html);  
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
            console.log(errorThrown);
          }
      });

    })
 
});


//function to update department select option for selected location in add employee modal

function addOption(locationId){  
  $.ajax({
    url: "libs/php/employeeslist.php",
    type: 'POST',
    datatype: 'JSON',
    data: {
      locationId:locationId
    },
    success: function(result) {
      html = "";
      result.map(department =>{
        html+=`<option value=${department.name.replace(' ', '-')}> 
                   ${department.name}
               </option>`
      });
     
      $('#department').html(html);  
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
      console.log(errorThrown);
    }
});

}

//function to update department select option for selected location in edit modal
function updateOption(locationId,department=""){

  $.ajax({
    url: "libs/php/employeeslist.php",
    type: 'POST',
    datatype: 'JSON',
    data: {
      locationId:locationId
    },
    success: function(result) {
     
      html = "";
      result.map(department =>{
        html+=`<option value=${department.name.replace(' ', '-')}> 
                   ${department.name}
               </option>`
      });
     
      $('#updateDepartment').html(html);
     
      if(department){
        $('#updateDepartment').val(department.replace(' ', '-'));
      }  
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
      console.log(errorThrown);
    }
  });
}

//function to delete selected employee
function confirmDelete(email,name){
  $('#hiddendelete').val(email);
  $('#deletModelBody').text(`Do you want to delete ${name}?`);
  window.$('#deletModel').modal('show');
}


//function to delete selected employee

function deleteEmployee(){

  let email = $('#hiddendelete').val();

  $.ajax({
    url: "libs/php/deleteemployee.php",
    type: 'POST',
    datatype: 'JSON',
    data: {
      id:email
    },
    success: function(result) {
      
      if(result.status==404){
        $('#deletModelBody').text('');
        $("#confirm").addClass("d-none");
        $('#deletModelBody').append(`<div id="deleteError" class="alert alert-danger mt-2"><strong>Error!</strong>${result.message}</div>`);
      }else{
        $('#deleteError').remove();
        $("#confirm").addClass("d-none");
        $('#deletModelBody').text('');
        $('#deletModelBody').append(`<div id="deleteSuccess" class="alert alert-success mt-2"><strong>Success!</strong> ${result.message}</div>`);
        readEmployees();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
      console.log(errorThrown);
      $('#deletModelBody').text('');
      $('#deletModelBody').append(`<div id="deleteError" class="alert alert-danger mt-2"><strong>Error!</strong>Database Error</div>`);

    }
  }); 
}


//function to populate select option for location and department field
function selectOptions(){
  $.ajax({
    url: "libs/php/selectoption.php",
    type: 'POST',
    datatype:'JSON',
    success: function(result) {
    
      let locOption = "";
      result.location.map(location =>{
      locOption+=`<option value=${location.id}> 
                  ${location.location}
                </option>`
      });

      depOption = "";
      result.department.map(department =>{
      depOption+=`<option value=${department.name.replace(' ', '-')}> 
                  ${department.name}
              </option>`
      });
    
     $('#departmentOption').html(`<option selected> All Department</option>${depOption}`);
     $('#department').html(`<option selected> All Department</option>${depOption}`);
     $('#updateDepartment').html(depOption);  
    
     $('#locationOption').html(`<option selected>All Location</option>${locOption}`);
     $('#location').html(`<option selected>All Location</option>${locOption}`); 
     $('#updateLocation').html(locOption); 
        
    },
    error: function(jqXHR, textStatus, errorThrown) {
     
      console.log(jqXHR);
      console.log(errorThrown);
    }
  }); 

}

//function to read all department and location employees on default load
function readEmployees(){
  let employees = "employees";

  $.ajax({
    url: "libs/php/employeeslist.php",
    type: 'POST',
    datatype:'JSON',
    data: {
      employees
    },
    success: function(result) {
     console.log(result);
     html = "";
     if(result.status === 404){
        html +=`<tr> <td colspan="100">${result.message}</td></tr>`;
     }else {
        result.map(employee =>{
          html+=`<tr> 
                      <td>${employee.firstname} ${employee.lastname}</td>
                      <td class="d-none d-md-table-cell">${employee.email}</td>
                      <td class="d-none d-md-table-cell">${employee.locname}</td>
                      <td class="d-none d-md-table-cell">${employee.department}</td>
                      <td class="action">
                        <button class="btn btn-primary" onclick = showEmployee('${employee.email}')><span class="fas fa-eye aria-hidden="true"></span></button>
                        <button class="btn btn-warning" onclick = updateEmployee('${employee.email}')><span class="fas fa-edit" aria-hidden="true"></span></button>
                        <button class="btn btn-danger" onclick = confirmDelete('${employee.email}','${employee.firstname}')><span class="fas fa-trash-alt aria-hidden="true"></span></button>
                      </td>
                  </tr>`
        });
     }
     html+='</tbody></table>';
     $('#tbody').html(html);
      
    },
    error: function(jqXHR, textStatus, errorThrown) {
      html='<tr> <td colspan="100">Database error</td></tr></tbody></table>';
      $('#tbody').html(html);
      console.log(jqXHR);
      console.log(errorThrown);
    }
  }); 

}


//function add new employee to database
function addEmployee() {

  $('#serverError').text('');

  let firstName = $('#firstName').val();
  let lastName = $('#lastName').val();
  let email = $('#email').val();
  let location = $('#location').val();
  let departmentVal = $('#department').val();
  let department= departmentVal.replace('-', ' ');
  const error = {
                 firstName:'',
                 lastName:'',
                 email:'',
                 location:''};
  
  if(firstName.trim()==''){
    error.firstName ="Please enter the First Name";
  }

  if(lastName.trim()==''){
    error.lastName ="Please enter the Last Name";
  }

  if(email.trim()=='' || !(/(.+)@(.+){2,}\.(.+){2,}/.test(email))){
    error.email ="Please enter the valid email address";
  }

  if(location =='All Location'){
    error.location ="Please select location";
  }


    $('#firstNameError').text(error.firstName);
    $('#lastNameError').text(error.lastName);
    $('#emailError').text(error.email);
    $('#locationError').text(error.location);

  if(!error.firstName && !error.lastName && !error.email && !error.location ){

    $('#firstNameError').text('');
    $('#lastNameError').text('');
    $('#emailError').text('');
    $('#locationError').text('');
    console.log(firstName);

    $.ajax({
      url: "libs/php/addemployee.php",
      type: 'POST',
      datatype: 'JSON',
      data: {
        firstName,
        lastName,
        email,
        location,
        department
      },
      success: function(result) {
      console.log(result);
        if(result.error){
          $('#serverError').text(result.error);
          $('#error').remove();
        }else if(result.status==404){
          $('#addError').append(`<div id="error" class="alert alert-danger"><strong>Error!</strong>${result.message}</div>`);
        }else{
          $('#error').remove();
          $('#addError').append(`<div id="success" class="alert alert-success"><strong>Success!</strong> ${result.message}</div>`);
          $("#addform").trigger("reset");
          readEmployees();
        }
   
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $('.modal-body').append(`<div id="error" class="alert alert-danger"><strong>Error!</strong>Database Error</div>`);
        console.log(textStatus);
        console.log(jqXHR);
      }
    }); 
  }  
}

//function reset error and success in employee add modal
function reset() {

  $('#error').remove();
  $('#success').remove();
  $("#addform").trigger("reset");
  $('#firstNameError').text('');
  $('#lastNameError').text('');
  $('#emailError').text('');
  $('#locationError').text('');
}

//function reset error and success in update modal
function resetUpdateForm() {

  $('#updateError').remove();
  $('#updateSuccess').remove();
  $('#updateFnameError').text('');
  $('#updateLnameError').text('');
  $('#updateEmailError').text('');
}


function resetDeleteForm(){
  $('#deleteError').remove();
  $('#deleteSuccess').remove();
}

//function to display selected employee details on modal
function showEmployee(email){

  $.ajax({
    url: "libs/php/employeedetails.php",
    type: 'POST',
    datatype:'JSON',
    data: {
      id:email
    },
    success: function(result) {
     console.log(result);

    if(result.status==404){
      $('#showDetails').append(`<div id="showError" class="alert alert-danger"><strong>Error!</strong>${result.message}</div>`);
    }else{
      $('#showName').html(`<b>Name :</b>  ${result.firstname} ${result.lastname}`);
      $('#showEmail').html(`<b>Email ID :</b>  ${result.email}`);
      $('#showLocation').html(`<b>Location :</b>  ${result.locname}`);
      $('#showDepartment').html(`<b>Department :</b>  ${result.department}`);
      $('#showError').remove();
      window.$('#showModal').modal('show');
    }  
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
      console.log(errorThrown);
    }
});
  
}

//function to update employee details
function updateEmployee(email) {

  $.ajax({
    url: "libs/php/employeedetails.php",
    type: 'POST',
    datatype: 'JSON',
    data: {
      id:email
    },
    success: function(result) {
   
      if(result.status==404){
        $('#editModel').append(`<div id="updateError" class="alert alert-danger"><strong>Error!</strong>${result.message}</div>`);
      }else{
        $('#updateFirstName').val(result.firstname);
        $('#updateLastName').val(result.lastname);
        $('#updateEmail').val(result.email);
        $('#updateLocation').val(result.location);
        console.log(result.department);
        updateOption(result.location,result.department);
        $('#hidden').val(result.email);
      }
 
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
      console.log(jqXHR);
    }
  }); 

  window.$('#updateModal').modal('show');	

}


// function to save updated employee details to database 
function editEmployeeDetails(){

  $('#updateServerError').text('');

  let updatedFirstName=$('#updateFirstName').val();
  let updatedLastName=$('#updateLastName').val();
  let updatedEmail=$('#updateEmail').val();
  let updatedLocation=$('#updateLocation').val();
  let updatedVal=$('#updateDepartment').val(); 
  let compareVal = $('#hidden').val();
  let updatedDepartment = updatedVal.replace('-', ' ');

  const error = {
    firstName:'',
    lastName:'',
    email:''};

if(updatedFirstName.trim()==''){
error.firstName ="Please enter the First Name";
}

if(updatedLastName.trim()==''){
error.lastName ="Please enter the Last Name";
}

if(updatedEmail.trim()=='' || !(/(.+)@(.+){2,}\.(.+){2,}/.test(updatedEmail))){
error.email ="Please enter the valid email address";
}

$('#updateFnameError').text(error.firstName);
$('#updateLnameError').text(error.lastName);
$('#updateEmailError').text(error.email);


if(!error.firstName && !error.lastName && !error.email && !error.location ){

$('#updateFnameError').text('');
$('#updateLnameError').text('');
$('#updateEmailError').text('');


  $.ajax({
    url: "libs/php/updateemployee.php",
    type: 'POST',
    datatype: 'JSON',
    data: {
      updatedFirstName,
      updatedLastName,
      updatedEmail,
      updatedLocation,
      updatedDepartment,
      compareVal
    },
    success: function(result) {
    
      if(result.error){
        $('#updateServerError').text(result.error);
        $('#updateError').remove();
      }else if(result.status==404){
        $('#editModel').append(`<div id="updateError" class="alert alert-danger"><strong>Error!</strong>${result.message}</div>`);
      }else{
        $('#updateError').remove();
        $('#editModel').append(`<div id="updateSuccess" class="alert alert-success"><strong>Success!</strong> ${result.message}</div>`);
        readEmployees();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      $('#editModel').append(`<div id="updateError" class="alert alert-danger"><strong>Error!</strong>Database Error</div>`);
      console.log(textStatus);
      console.log(errorThrown);
    }
  }); 
} 
  
}


// Function to display searched list

function searchList(){
  let location = $('#locationOption').val();
  let departmentval = $('#departmentOption').val();

  let department = departmentval.replace('-', ' ')

  $.ajax({
    url: "libs/php/searchList.php",
    type: 'POST',
    datatype: 'JSON',
    data: {
      location,
      department
    },
    success: function(result) {
      console.log(result);
      html = "";
      if(result.status === 404){
        html +=`<tr> <td colspan="100">${result.message}</td></tr>`;
      }else {
        result.map(employee =>{
        html+=`<tr> 
                  <td>${employee.firstname} ${employee.lastname}</td>
                  <td class="d-none d-md-table-cell">${employee.email}</td>
                  <td class="d-none d-md-table-cell">${employee.locname}</td>
                  <td class="d-none d-md-table-cell">${employee.department}</td>
                  <td class="action">
                    <button class="btn btn-primary" onclick = showEmployee('${employee.email}')><span class="fas fa-eye aria-hidden="true"></span></button>
                    <button class="btn btn-warning" onclick = updateEmployee('${employee.email}')><span class="fas fa-edit" aria-hidden="true"></span></button>
                    <button class="btn btn-danger" onclick = confirmDelete('${employee.email}','${employee.firstname}')><span class="fas fa-trash-alt aria-hidden="true"></span></button>
                  </td>
              </tr>`
        }); 
     }

     html+='</tbody></table>';
     $('#tbody').html(html);
     
    },
    error: function(jqXHR, textStatus, errorThrown) {
        
        html='<tr> <td colspan="100">Database error</td></tr></tbody></table>';
        $('#tbody').html(html);
      console.log(textStatus);
      console.log(errorThrown);
    }
  }); 
}
