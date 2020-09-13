
/* function to get current location*/
$(document).ready(function() {

    $('#preloader').fadeOut(4000, function() { $(this).remove(); });
    $("#container").show();
    selectOptions();
    readEmployees();

    $('#locationOption').change(function(){
        let locationId= $(this).val();
        console.log(locationId);
        $.ajax({
          url: "libs/php/database.php",
          type: 'POST',
          data: {
            locationId:locationId
          },
          success: function(result) {
            console.log(result);
            html = "<option selected> All Department</option>";
            result.map(department =>{
              html+=`<option value=${department.name}> 
                         ${department.name}
                     </option>`
            });
           
            $('#departmentOption').html(html);  
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
            console.log(errorThrown);
          }
      });

    })
 
});


function addOption(locationId){
  
  console.log(locationId);
  $.ajax({
    url: "libs/php/database.php",
    type: 'POST',
    data: {
      locationId:locationId
    },
    success: function(result) {
      console.log(result);
      html = "";
      result.map(department =>{
        html+=`<option value=${department.name}> 
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


function updateOption(locationId,department=""){
  
  console.log(locationId);
  $.ajax({
    url: "libs/php/database.php",
    type: 'POST',
    data: {
      locationId:locationId
    },
    success: function(result) {
      console.log(result);
      html = "";
      result.map(department =>{
        html+=`<option value=${department.name}> 
                   ${department.name}
               </option>`
      });
     
      $('#updateDepartment').html(html);
      if(department){
        $('#updateDepartment').val(department);
      }  
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus);
      console.log(errorThrown);
    }
});

}

function deleteEmployee(email,name){

  let grant = confirm(`Do you want to delete ${name}?`);

  if(grant == true) {

    $.ajax({
        url: "libs/php/database.php",
        type: 'POST',
        data: {
          emailid:email
        },
        success: function(result) {
          readEmployees();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus);
          console.log(errorThrown);
        }
    }); 
  }
}


function selectOptions(){
  $.ajax({
    url: "libs/php/selectoption.php",
    type: 'GET',
    datatype:'JSON',
    success: function(result) {
     console.log(result);
     let locOption = "";
     result.location.map(location =>{
      locOption+=`<option value=${location.id}> 
                  ${location.location}
              </option>`
     });

     depOption = "";
     result.department.map(department =>{
      depOption+=`<option value=${department.name}> 
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
      console.log('error');
      console.log(textStatus);
      console.log(jqXHR);
       console.log(errorThrown);
    }
  }); 

}

function readEmployees(){
  let employees = "employees";

  $.ajax({
    url: "libs/php/database.php",
    type: 'POST',
    datatype:'JSON',
    data: {
      employees
    },
    success: function(result) {
     console.log(result);
     html = "";
     result.map(employee =>{
       html+=`<tr> 
                  <td>${employee.firstname} ${employee.lastname}</td>
                  <td>${employee.email}</td>
                  <td class="d-none d-lg-table-cell d-xl-table-cell">${employee.manager}</td>
                  <td class="action">
                    <button class="btn btn-primary"><span class="fas fa-eye aria-hidden="true"></span></button>
                    <button class="btn btn-warning" onclick = updateEmployee('${employee.email}')><span class="fas fa-edit" aria-hidden="true"></span></button>
                    <button class="btn btn-danger" onclick = deleteEmployee('${employee.email}','${employee.firstname}')><span class="fas fa-trash-alt aria-hidden="true"></span></button>
                  </td>
              </tr>`
     });
     html+='</tbody></table>';
     $('#tbody').html(html);
      
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log('error');
      console.log(textStatus);
      console.log(jqXHR);
       console.log(errorThrown);
    }
  }); 

}


/*Success function for finding current location*/
function addEmployee() 
{
  let firstName = $('#firstName').val();
  let lastName = $('#lastName').val();
  let email = $('#email').val();
  let manager = $('#manager').val();
  let location = $('#location').val();
  let department = $('#department').val();
 console.log($('#department').val());
  $.ajax({
    url: "libs/php/database.php",
    type: 'POST',
    data: {
      firstName,
      lastName,
      email,
      manager,
      location,
      department
    },
    success: function(result) {
      console.log(result);
       readEmployees(); 
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log('error');
      console.log(textStatus);
       console.log(errorThrown);
    }
  }); 
   
}


function updateEmployee(email) {

console.log('update');
$.post("libs/php/database.php", {id:email},
  function(data,status){
    console.log(data);
    let user = JSON.parse(data);
    $('#updateFirstName').val(user.firstname);
    $('#updateLastName').val(user.lastname);
    $('#updateEmail').val(user.email);
    $('#updateManager').val(user.manager);
    $('#updateLocation').val(user.location);
    updateOption(user.location,user.department);
    

  }
  
  );

  window.$('#updateModal').modal('show');

	

}
  



