<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-background-color="black" >
      <div class="logo"><img src="images/lgu.png" class="img-logo"></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url()?>whiteboard">
              <i class="material-icons">dashboard</i>
              <p>Whiteboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="<?php echo base_url()?>contenders">
              <i class="material-icons">people</i>
              <p>Contenders/Applicants</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url()?>vacancies">
              <i class="material-icons">content_paste</i>
              <p>Vacancies</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" style="overflow-y: hidden !important;">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top bg-white">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;"><b>Vacancies Whiteboard System</b></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <!-- <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>`
            </form> -->
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <!-- Main Panel -->
      <div class="content" >
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <div class="row">
                    <div class="col-md-6">
                      <h4 class="card-title">Contenders/Applicants</h4>
                    </div>
                    <div class="col-md-6">
                      <button type="button" class="btn btn-default pull-right" id="update_btn" style="background-color: #303030 !important;"><i class="material-icons">update</i> Update</button>
                      <button type="button" class="btn btn-default pull-right" id="add_btn" style="background-color: #303030 !important;"><i class="material-icons">person_add</i> Add</button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="">
                    <table class="table table-hover stripe" id="contenders_table">
                      <thead class="">
                        <tr>
                          <th></th>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Applicant Type</th>
                          <th>Emp. ID No.</th>
                          <th>Current Position</th>
                          <th>Emp. Status</th>
                          <th class="text-right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Form -->
  <div class="modal fade" id="add_contender_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Contender/Applicant</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="contender_form">
            <div class="row" style="display: none;">
              <label class="col-sm-4 col-form-label align-right">ID</label>
              <div class="col-sm-8">
                <div class="form-group bmd-form-group">
                  <input type="number" class="form-control" id="id" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-4 col-form-label align-right">First Name</label>
              <div class="col-sm-8">
                <div class="form-group bmd-form-group">
                  <input type="text" class="form-control" placeholder="Juan" id="firstname" required>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-4 col-form-label align-right">Middle Name</label>
              <div class="col-sm-8">
                <div class="form-group bmd-form-group">
                  <input type="text" class="form-control" placeholder="Dela" id="middlename">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-4 col-form-label align-right">Last Name</label>
              <div class="col-sm-8">
                <div class="form-group bmd-form-group">
                  <input type="text" class="form-control" placeholder="Cruz" id="lastname" required>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-4 col-form-label align-right">Suffix</label>
              <div class="col-sm-8">
                <div class="form-group bmd-form-group">
                  <input type="text" class="form-control" placeholder="Jr." id="suffix">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-4 col-form-label align-right">Type of Applicant</label>
              <div class="col-sm-8">
                <div class="form-group bmd-form-group">
                  <div class="form-check form-check-radio">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="applicantTypeRadio" id="internal" value="Internal" onclick="shrinkExtendForm()">
                        Internal
                        <span class="circle">
                            <span class="check"></span>
                        </span>
                    </label>
                  </div>
                  <div class="form-check form-check-radio">
                      <label class="form-check-label">
                          <input class="form-check-input" type="radio" name="applicantTypeRadio" id="external" value="External" onclick="shrinkExtendForm()" checked>
                          External
                          <span class="circle">
                              <span class="check"></span>
                          </span>
                      </label>
                  </div>
                </div>
              </div>
            </div>
            <div id="extendedForm" style="display: none;">
              <div class="row">
                <label class="col-sm-4 col-form-label align-right">Emp. ID Number</label>
                <div class="col-sm-8">
                  <div class="form-group bmd-form-group">
                    <input type="number" class="form-control" placeholder="9155" id="emp_no">
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-4 col-form-label align-right">Emp. Status</label>
                <div class="col-sm-8">
                  <div class="form-group">
                    <select class="form-control selectpicker" id="empstatus">
                      <option>Job Order</option>
                      <option>Casual</option>
                      <option>Permanent</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-4 col-form-label align-right">Current Position</label>
                <div class="col-sm-8">
                  <div class="form-group bmd-form-group">
                    <input type="text" class="form-control" placeholder="Aide1" id="poscode">
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary pull-right" onclick="">Save</button>
            <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>
            <div class="clearfix"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var crudType = "";
    var pageScrollPos = 0; // variable used for returning page scroll position after table reload

    // console.log(100vh);
    $(document).ready(function() {
      $("#add_btn").click(function(){
        crudType = "Add";
        $("#add_contender_modal").modal("show");
      });

      $("#update_btn").click(function(){
        Swal.fire({
          title: 'Are you sure you want to update contenders from Plantilla?',
          text: "",
          type: 'question',
          showCancelButton: true,
          confirmButtonText: 'Update'
        }).then((result) => {
          if (result.value == true) {
            Swal.fire({
              title: 'Updating contenders from Plantilla',
              text: "",
              type: 'info',
              showCancelButton: false,
              allowOutsideClick: false
            })
            Swal.showLoading();
            $.ajax({
              type: "POST",
              url: "<?php echo base_url()?>contenders/update_from_plantilla",
              dataType: "json",
              timeout: 60000, // 20 sec timeout
              success: function(result, status, xhr) {
                Swal.close();
                Swal.fire({
                  title: result.success ? "Success": "Failure", 
                  text: result.data, 
                  type: result.success ? "success": "error", 
                  timer: 2000,
                  buttonsStyling: false, 
                  confirmButtonClass: "btn btn-success"
                });
                $("#contenders_table").DataTable().ajax.reload();
              },
              error: function(xhr, status, errorThrown) {
                Swal.close();
                if(status == "timeout"){
                  Swal.fire({
                    title: "Failure", 
                    text: "The update has timed out.", 
                    type: "error", 
                    timer: 2000,
                    buttonsStyling: false, 
                    confirmButtonClass: "btn btn-error"
                  });
                }
                $("#contenders_table").DataTable().ajax.reload();
              }
            });
          }
        });
      });

      var contenders_table = $("#contenders_table").DataTable({
        scrollY         : '60vh',
        // paging          : false,
        info            : false,
        deferRender     : true,
        scrollCollapse  : true,
        scroller        : true, // scroller extension used for faster rendering of data
        ordering        : false,
        ajax: {
          url   : '<?php echo base_url()?>contenders/contenders_list',
          dataSrc: 'data'
        },
        initComplete: function(settings) {
          $('.dataTables_scrollBody table thead tr').css({visibility:'collapse'}); // fix another thead showing inside table body
          $('.dataTables_scrollBody').perfectScrollbar();
        },
        drawCallback: function(settings) {
          $('.dataTables_scrollBody table thead tr').css({visibility:'collapse'}); // fix another thead showing inside table body
          $("[data-toggle='tooltip']").tooltip(); // initialize material dashboard tooltips every after ajax is successful and table is drawn
        },
        columns: [
          {className: 'td-actions text-right', data: 'priority', width: '5%'},
          {data: 'id', width: '5%'},
          {data: 'name', width: '25%'},
          {data: 'applicanttype', width: '13%'},
          {data: 'emp_no', width: '10%'},
          {data: 'poscode', width: '17%'},
          {data: 'empstatus', width: '15%'},
          {className: 'td-actions text-right', data: 'actions', width: '10%'}
        ]
      });

      $("#add_contender_modal").submit(function(e) {
        e.preventDefault(); // prevent auto-closing of form when Submitted, also triggers form validation
      });

      $("#add_contender_modal").on("submit", function(){
        var id = $("#id").val();
        var firstname = $("#firstname").val();
        var middlename = $("#middlename").val();
        var lastname = $("#lastname").val();
        var suffix = $("#suffix").val();
        var applicanttype = $("input[name='applicantTypeRadio']:checked").val();
        var emp_no = $("#emp_no").val();
        var empstatus = $("#empstatus").val();
        var poscode = $("#poscode").val();
        var priority = 0;

        $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>contenders/crud",
          data: {
            type: crudType,
            id: id,
            firstname: firstname,
            middlename: middlename,
            lastname: lastname,
            suffix: suffix,
            applicanttype: applicanttype,
            emp_no: emp_no,
            empstatus: empstatus,
            poscode: poscode,
            priority: priority
          },
          dataType: "json",
          success: function(result, status, xhr) {
            $("#add_contender_modal").modal("hide"); // close the modal
            Swal.fire({ 
              title: result.success ? "Success": "Failure", 
              text: result.data, 
              type: result.success ? "success": "error", 
              timer: 2000,
              buttonsStyling: false, 
              confirmButtonClass: "btn btn-success"
            });
            contenders_table.ajax.reload();
          }
        });
      });

      $("#add_contender_modal").on("hidden.bs.modal", function(){
        $("#contender_form").trigger("reset"); // reset the form
        shrinkExtendForm(); // hide the extended form
        $("#empstatus").selectpicker('refresh');
      });
    }); // end of document onReady() function

    function toggleStar(el) {
      
      var button = el.closest("button");
      var row = el.closest("tr");
      var id = row.children[1].textContent;
      var priority = (row.children[0].textContent == "star") ? 1: 0; // star-1, star_border-0
      // console.log(priority);

      $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>contenders/toggle_priority",
        data: {
          id: id,
          priority: priority
        },
        dataType: "json",
        success: function(result, status, xhr) {
          $(button).tooltip('hide');
          $("#contenders_table").DataTable().ajax.reload();
          Swal.fire({
            title: result.success ? "Success": "Failure", 
            text: result.data, 
            type: result.success ? "success": "error", 
            timer: 2000,
            buttonsStyling: false, 
            confirmButtonClass: "btn btn-success"
          });
        }
      });
    }

    function editContender(el) {
      var row = el.closest("tr");
      var id = row.children[1].textContent;

      $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>contenders/view",
        data: {
          id: id
        },
        dataType: "json",
        success: function(result, status, xhr) {
          var data = result.data[0];

          $("#id").val(data.id);
          $("#firstname").val(data.firstname);
          $("#middlename").val(data.middlename);
          $("#lastname").val(data.lastname);
          $("#suffix").val(data.suffix);
          // for Applicant Type Radio button
          if(data.applicanttype == "Internal") $("#internal").prop("checked", true);
          else $("#external").prop("checked", true);
          shrinkExtendForm();

          $("#emp_no").val(data.emp_no);
          $("#empstatus").selectpicker('val', data.empstatus);

          $("#poscode").val(data.poscode);
          $("#add_contender_modal").modal("show");
          crudType = "Edit";
        }
      });
    }

    function deleteContender(el) {
      var row = el.closest("tr");
      var id = row.children[1].textContent;

      Swal.fire({
        title: 'Are you sure you want to delete this contender?',
        text: "You won't be able to revert this action.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
      }).then((result) => {
        if (result.value == true) {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>contenders/crud",
            data: {
              type: "Delete",
              id: id
            },
            dataType: "json",
            success: function(result, status, xhr) {
              Swal.fire(
                'Deleted!',
                'Contender successfully deleted.',
                'success'
              );
              $("#contenders_table").DataTable().ajax.reload();
            }
          });
        }
      });
    }
    function shrinkExtendForm() {
      if($('#internal')[0].checked) {
        $('#extendedForm')[0].style.display = 'block';
      }
      else
        $('#extendedForm')[0].style.display = 'none';
    }
  </script>