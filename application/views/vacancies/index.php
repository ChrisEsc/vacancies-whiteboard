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
            <a class="nav-link" href="<?php echo base_url()?>contenders">
              <i class="material-icons">people</i>
              <p>Contenders/Applicants</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="<?php echo base_url()?>vacancies">
              <i class="material-icons">content_paste</i>
              <p>Vacancies</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
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
            <form class="navbar-form">
              <!-- <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div> -->
            </form>
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
                <div class="card-header card-header-info">
                  <div class="row">
                    <div class="col-md-6">
                      <h4 class="card-title">Vacancies</h4>
                    </div>
                    <div class="col-md-6">
                      <button type="button" class="btn btn-default pull-right" id="update_btn" style="background-color: #303030 !important;"><i class="material-icons">update</i> Update</button>
                      <button type="button" class="btn btn-default pull-right" id="download_btn" style="background-color: #303030 !important;"><i class="material-icons">file_download</i> Download</button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="">
                    <table class="table table-hover wrap stripe" id="vacancies_table">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>No.</th>
                          <th>Item Name</th>
                          <th>Code</th>
                          <th>Parenthetical Pos.</th>
                          <th>SG</th>
                          <th>Dept.</th>
                          <th>Remarks</th>
                          <th>Status</th>
                          <th>Posting</th>
                          <th>Action</th>
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
  <div class="modal fade" id="add_vacancy_modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Vacancy</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="vacancy_form">
            <div class="row" style="display: none;">
              <label class="col-sm-4 col-form-label align-right">ID</label>
              <div class="col-sm-8">
                <div class="form-group bmd-form-group">
                  <input type="number" class="form-control" id="id" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label align-right">Item Desc.</label>
              <div class="col-sm-9">
                <div class="form-group bmd-form-group">
                  <input type="text" class="form-control" placeholder="Administrative Officer V" id="item_desc" required>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label align-right">Item Code</label>
              <div class="col-sm-9">
                <div class="form-group bmd-form-group">
                  <input type="text" class="form-control" placeholder="AdOf5" id="item_code" required>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label align-right">Item Details</label>
              <div class="col-sm-9">
                <div class="form-group bmd-form-group">
                  <input type="text" class="form-control" placeholder="(Budget Officer III)" id="item_desc_detail">
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label align-right">Salary Grade</label>
              <div class="col-sm-9">
                <div class="form-group bmd-form-group">
                  <input type="number" class="form-control" placeholder="18" id="posgrade" required>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label align-right">Department</label>
              <div class="col-sm-9">
                <div class="form-group">
                  <select class="form-control selectpicker" data-size="10" data-live-search="true" id="depcode" data-style="btn btn-primary btn-round" required>
                    <option disabled selected>Select Department</option>
                    <option data-tokens="ACCTG" value="ACCTG">City Accounting Department</option>
                    <option data-tokens="ADMIN" value="ADMIN">City Administrator's Office</option>
                    <option data-tokens="APO" value="APO">Agricultural Productivity Operations Office</option>
                    <option data-tokens="BLDG" value="BLDG">Office of the City Building Official</option>
                    <option data-tokens="CAD" value="CAD">City Assessment Department</option>
                    <option data-tokens="CAO" value="CAO">Community Affairs Office</option>
                    <option data-tokens="CBO" value="CBO">City Budget Office</option>
                    <option data-tokens="CCR" value="CCR">City Civil Registry Office</option>
                    <option data-tokens="CDO-TVI" value="CDO-TVI">Technical Vocational Institute</option>
                    <option data-tokens="CDRRMO" value="CDRRMO">City Disaster Risk Reduction Management Office</option>
                    <option data-tokens="CEED-CARMN" value="CEED-CARMN">City Economic Enterprises Department (Carmen Div.)</option>
                    <option data-tokens="CEED-COGON" value="CEED-COGON">City Economic Enterprises Department (Cogon Div.)</option>
                    <option data-tokens="CEED-PUER2" value="CEED-PUER2">City Economic Enterprises Department (Puerto Div.)</option>
                    <option data-tokens="CEED-SLAUT" value="CEED-SLAUT">City Economic Enterprises Department (Slaughterhouse Div.)</option>
                    <option data-tokens="CFD" value="CFD">City Finance Department</option>
                    <option data-tokens="CGSD" value="CGSD">City General Services Department</option>
                    <option data-tokens="CHD" value="CHD">City Health Department</option>
                    <option data-tokens="CHIO" value="CHIO">City Health Insurance Office</option>
                    <option data-tokens="CHUDD" value="CHUDD">City Housing and Urban Development Department</option>
                    <option data-tokens="CINFO" value="CINFO">City Information Office</option>
                    <option data-tokens="CIO" value="CIO">Community Improvement Office</option>
                    <option data-tokens="CLENRO" value="CLENRO">City Local Environment & Natural Resources Office</option>
                    <option data-tokens="CLO" value="CLO">City Legal Office</option>
                    <option data-tokens="CMISO" value="CMISO">City Management Information System Office</option>
                    <option data-tokens="CMO" value="CMO">Chief Executive Department</option>
                    <option data-tokens="CPDO" value="CPDO">City Planning and Development Office</option>
                    <option data-tokens="CPL" value="CPL">Cagayan de Oro City Public Library</option>
                    <option data-tokens="CPO" value="CPO">City Prosecutor's Office</option>
                    <option data-tokens="CPSD" value="CPSD">City Public Services Office</option>
                    <option data-tokens="CROD" value="CROD">City Register of Deeds</option>
                    <option data-tokens="CSCHOLAR" value="CSCHOLAR">City Scholarship Office</option>
                    <option data-tokens="CSWD" value="CSWD">City Social Welfare and Development Office</option>
                    <option data-tokens="CTCA" value="CTCA">Tourism and Cultural Affairs Office</option>
                    <option data-tokens="CVO" value="CVO">City Veterinary Office</option>
                    <option data-tokens="DEPOT" value="DEPOT">Office of the City Equipment Depot</option>
                    <option data-tokens="DEPW" value="DEPW">City Engineer's Office</option>
                    <option data-tokens="EBTPM" value="EBTPM">East-Bound Terminals and Public Market</option>
                    <option data-tokens="HOSP-LUMB" value="HOSP-LUMB">Cagayan de Oro City Hospital - Lumbia</option>
                    <option data-tokens="HOSP-TABLN" value="HOSP-TABLN">Cagayan de Oro City Hospital - Tablon</option>
                    <option data-tokens="HRMO" value="HRMO">Human Resource Management Office</option>
                    <option data-tokens="IASO" value="IASO">Internal Audit Service Office</option>
                    <option data-tokens="JRBH" value="JRBH">J.R. Borja General Hospital</option>
                    <option data-tokens="LSB-NTEE" value="LSB-NTEE">Div. of City Schools (Local School Board NT-EE)</option>
                    <option data-tokens="LSB-NTNF" value="LSB-NTNF">Div. of City Schools (Local School Board NT-NF)</option>
                    <option data-tokens="LSB-NTSE" value="LSB-NTSE">Div. of City Schools (Local School Board NT-SE)</option>
                    <option data-tokens="LSB-TEE" value="LSB-TEE">Div. of City Schools (Local School Board T-EE)</option>
                    <option data-tokens="LSB-TSE" value="LSB-TSE">Div. of City Schools (Local School Board T-SE)</option>
                    <option data-tokens="MTCC" value="MTCC">Municipal Trial Court in Cities</option>
                    <option data-tokens="ORO-YOUTH" value="ORO-YOUTH">Oro Youth Development Office</option>
                    <option data-tokens="OTIPC" value="OTIPC">Oro Trade & Investment Promotions Center</option>
                    <option data-tokens="PLEB" value="PLEB">Non-Office (People's Law Enforcement Board)</option>
                    <option data-tokens="RTA" value="RTA">Roads and Traffic Administration</option>
                    <option data-tokens="SK" value="SK">Non-Office (Aide to SK Federation)</option>
                    <option data-tokens="SP" value="SP">Office of the Sangguniang Panlungsod - Secretary</option>
                    <option data-tokens="SPM" value="SPM">Office of the Sangguniang Panlungsod - Kagawads</option>
                    <option data-tokens="VMO" value="VMO">Office of the Vice Mayor</option>
                    <option data-tokens="WBTPM" value="WBTPM">West-Bound Terminals and Public Market</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <label class="col-sm-3 col-form-label align-right">Remarks</label>
              <div class="col-sm-9">
                <div class="form-group bmd-form-group">
                  <textarea class="form-control" rows="2" id="remarks"></textarea>
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
    $(document).ready(function(){
      $("#update_btn").click(function(){
        Swal.fire({
          title: 'Are you sure you want to update vacancies from Plantilla?',
          text: "",
          type: 'question',
          showCancelButton: true,
          confirmButtonText: 'Update'
        }).then((result) => {
          if(result.value == true) {
            Swal.fire({
              title: 'Updating vacancies from Plantilla',
              text: "",
              type: 'info',
              showCancelButton: false,
              allowOutsideClick: false
            })
            Swal.showLoading();
            $.ajax({
              type: "POST",
              url: "<?php echo base_url()?>vacancies/update_from_plantilla",
              dataType: "json",
              timeout: 60000, // 1 min timeout
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
                $("#vacancies_table").DataTable().ajax.reload();
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
                $("#vacancies_table").DataTable().ajax.reload();
              }
            });
          }
        });
      });

      $("#download_btn").click(function(){
        $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>vacancies/exportdocument",
          data: {
            filetype: "Excel"
          },
          dataType: "json",
          timeout: 60000, // 1 min timeout
          success: function(result, status, xhr) {
            if (result.success == true) window.location = "<?php echo base_url(); ?>"+result.filename;
            Swal.fire({
              title: result.success ? "Success": "Failure", 
              text: result.data, 
              type: result.success ? "success": "error", 
              timer: 2000,
              buttonsStyling: false, 
              confirmButtonClass: "btn btn-success"
            });
            $("#vacancies_table").DataTable().ajax.reload();
          },
          error: function(xhr, status, errorThrown) {
            $("#vacancies_table").DataTable().ajax.reload();
          }
        });
      });

      var vacancies_table = $("#vacancies_table").DataTable({
        scrollY         : '60vh',
        autoWidth       : false,
        info            : false,
        deferRender     : true,
        scrollCollapse  : true,
        scroller        : true, // scroller extension used for faster rendering of data
        order           : [[5, 'asc']],
        ordering        : false,
        ajax: {
          url   : '<?php echo base_url()?>vacancies/vacancies_list',
          dataSrc: 'data'
        },
        initComplete: function(settings) {
          $('.dataTables_scrollBody table thead tr').css({visibility:'collapse'}); // fix another thead showing inside table body
          $('.dataTables_scrollBody').perfectScrollbar();
        },
        drawCallback: function(settings) {
          $('.dataTables_scrollBody table thead tr').css({visibility:'collapse'}); // fix another thead showing inside table body
        },
        columns: [
          {data: 'id', width: '3%', visible: false, bSortable: false},
          {data: 'plantilla_item_no', width: '5%', bSortable: false},
          {data: 'item_desc', width: '20%', bSortable: false, render: function(data, type, row) {return renderer(data, type, row, 30);}, createdCell: function(td, cellData, rowData, row, col) {$(td).attr({title: cellData});}},
          {data: 'item_code', width: '5%', bSortable: false},
          {data: 'item_desc_detail', width: '13%', bSortable: false, render: function(data, type, row) {return renderer(data, type, row, 20);}, createdCell: function(td, cellData, rowData, row, col) {$(td).attr({title: cellData});}},
          {data: 'posgrade', width: '5%', bSortable: false},
          {data: 'depcode', width: '9%', bSortable: false},
          {data: 'remarks', width: '16%', bSortable: false, render: function(data, type, row) {return renderer(data, type, row, 20);}, createdCell: function(td, cellData, rowData, row, col) {$(td).attr({title: cellData});}
          },
          {data: 'status', width: '8%', bSortable: true},
          {data: 'latest_posting', width: '10%', bSortable: false},
          {className: 'td-actions text-right', data: 'actions', width: '6%', bSortable: false}
        ]
      });

      $("#add_vacancy_modal").submit(function(e) {
        e.preventDefault(); // prevent auto-closing of form when Submitted, also triggers form validation
      });

      $("#add_vacancy_modal").on("submit", function(){
        var id = $("#id").val();
        var item_desc = $("#item_desc").val();
        var item_code = $("#item_code").val();
        var item_desc_detail = $("#item_desc_detail").val();
        var posgrade = $("#posgrade").val();
        var depcode = $("#depcode").val();
        var remarks = $("#remarks").val();

        $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>vacancies/crud",
          data: {
            type: crudType,
            id: id,
            item_desc: item_desc,
            item_code: item_code,
            item_desc_detail: item_desc_detail,
            posgrade: posgrade,
            depcode: depcode,
            remarks: remarks
          },
          dataType: "json",
          success: function(result, status, xhr) {
            $("#add_vacancy_modal").modal("hide"); // close the modal
            Swal.fire({ 
              title: result.success ? "Success": "Failure", 
              text: result.data, 
              type: result.success ? "success": "error", 
              timer: 2000,
              buttonsStyling: false, 
              confirmButtonClass: "btn btn-success"
            });
            vacancies_table.ajax.reload();
          }
        });
      });

      $("#add_vacancy_modal").on("hidden.bs.modal", function(){
        $("#vacancy_form").trigger("reset"); // reset the form
        $("#department").selectpicker('refresh');
      });
    });

    function editVacancy(el) {
      var row = el.closest("tr");
      var id = row.children[0].textContent; // id

      $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>vacancies/view",
        data: {
          id: id
        },
        dataType: "json",
        success: function(result, status, xhr) {
          var data = result.data[0];

          $("#id").val(data.id);
          $("#item_desc").val(data.item_desc);
          $("#item_code").val(data.item_code);
          $("#item_desc_detail").val(data.item_desc_detail);
          $("#posgrade").val(data.posgrade);
          $("#depcode").selectpicker('val', data.depcode);
          $("#remarks").val(data.remarks);
          $("#add_vacancy_modal").modal("show");
          crudType = "Edit";
        }
      });
    }

    function deleteVacancy(el) {
      var row = el.closest("tr");
      var id = row.children[0].textContent; // id

      Swal.fire({
        title: 'Are you sure you want to delete this item?',
        text: "You won't be able to revert this action.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete'
      }).then((result) => {
        if (result.value == true) {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url()?>vacancies/crud",
            data: {
              type: "Delete",
              id: id
            },
            dataType: "json",
            success: function(result, status, xhr) {
              Swal.fire(
                'Deleted!',
                'Item successfully deleted.',
                'success'
              );
              $("#vacancies_table").DataTable().ajax.reload();
            }
          });
        }
      });
    }

    function renderer(data, type, row, limit) {
      var string = "";

      if (data == null) return string;
      else if (data.length > limit) {
        string = data.substr(0, limit) + "...";
      }
      else return data;

      return string;
    }
  </script>