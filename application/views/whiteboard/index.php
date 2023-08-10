<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-background-color="black" >
      <div class="logo"><img src="images/lgu.png" class="img-logo"></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link active" href="<?php echo base_url()?>whiteboard">
              <i class="material-icons">dashboard</i>
              <p>Whiteboard</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url()?>contenders">
              <i class="material-icons">people</i>
              <p>Contenders/Applicants</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?php echo base_url()?>vacancies">
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
      <div class="content" style="overflow-y: hidden;">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-3" style="background-color: rgba(0, 0, 0, 0.0)">
              <header class="row header-style">
                <div class="col-sm-4 my-auto">Contenders</div>
                <div class="col-sm-8 my-auto">
                  <div class="justify-content-end">
                    <form class="my-auto" id="contender_search_form">
                      <div class="input-group no-border">
                        <input type="text" id="contender_search_input" class="form-control" placeholder="Search...">
                      </div>
                    </form>
                  </div>
                </div>
              </header>
              <div class="container scroll scrollbar" id="contenders" style="min-height: 20px;"></div>
            </div>
            <div class="col-sm-9" style="background-color: rgba(255, 255, 255, 1.0)">
              <header class="row header-style-alt">
                <div class="col-sm-8 my-auto">Vacancies</div>
                <div class="col-sm-4 my-auto">
                  <div class="justify-content-end">
                    <form class="my-auto" id="vacancy_search_form">
                      <div class="input-group no-border">
                        <input type="text" id="vacancy_search_input" class="form-control" placeholder="Search..." value="">
                      </div>
                    </form>
                  </div>
                </div>
              </header>
              <div class="scroll scrollbar" id="vacancies"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var contenders_data_json = [];
    var vacancies_data_json = [];
    var whiteboard_data_json = [];

    $(document).ready(function() {
      ajaxVacancies();

      //contender search function
      //prevent page refresh (submit) on enter key
      $("#contender_search_form").submit(function(e) {e.preventDefault();});
      $("#contender_search_input").on("keyup", function() {
        var value = $(this).val().toLowerCase();

        $("#contenders .contender-style").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      });

      //vacancy search function
      //prevent page refresh (submit) on enter key
      $("#vacancy_search_form").submit(function(e) {e.preventDefault();});
      $("#vacancy_search_input").on("keyup", function(event) {
        var value = $(this).val().toLowerCase();
        if(event.keyCode === 13) { //ajax on enter key
          $(this).val(""); //clear search term
          ajaxVacancies(value);
        }
      });
    }); //end of document onReady() function

    function ajaxVacancies(query = null) {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>vacancies/vacancies_list_groupby_department",
        data: {
          query: query
        },
        dataType: "json",
        success: function(result, status, xhr) {
          vacancies_data_json = result.data;
          if(vacancies_data_json != null) displayVacancies(vacancies_data_json);
          ajaxContenders();
        }
      });
    }

    function ajaxContenders(query = null) {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>whiteboard/contenders_list",
        dataType: "json",
        data: {
          query: query
        },
        success: function(result, status, xhr) {
          contenders_data_json = result.data;
          if(contenders_data_json != null) displayContenders(contenders_data_json);
          ajaxWhiteboard();
        }
      });
    }

    function ajaxWhiteboard() {
      $.ajax({
        type: "POST",
        url: "<?php echo base_url()?>whiteboard/wlist",
        data: {},
        dataType: "json",
        success: function(result, status, xhr) {
          whiteboard_data_json = result.data;
          initDragula();
        }
      });
    }

    function displayVacancies(data) {
      var vacancies_div = document.getElementById("vacancies");
      vacancies_div.innerHTML = '';

      for(vacancy of data) {
        var div = document.createElement("div");
        var html = '', tooltipData = '';

        div.id = vacancy.depcode;
        div.classList.add("department-style");
        html += '<div class="header-style" style="padding-left:20px !important;">' + vacancy.depdesc + '</div>' +
          '<div id="table">' +
          '<div class="th">' +
          '<div class="header-cell item-col">Items</div>' +
          '<div class="header-cell endorsed-col">Endorsed by Department/Applicants</div>' +
          '<div class="header-cell recommended-col">Recommended by HRM-PSB</div>' +
          '</div>';

        for(item of vacancy.vacant_items) {
          tooltipData = "<table id=\'table_info\' class=\'table borderless\'><thead style=\'visibility: collapse;\'><tr><td class=\'text-right no-border\' style=\'width: 35%;\'></td><td class=\'text-right no-border\' style=\'width: 65%;\'></td></tr></thead>" + 
          "<tbody>" + 
            "<tr><td class=\'text-right no-border\'><b>Item No.</b></td><td class=\'text-left no-border\'>" + item.plantilla_item_no + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\'><b>SG</b></td><td class=\'text-left no-border\'>" + item.posgrade + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\'><b>Date Vacated</b></td><td class=\'text-left no-border\'>" + item.date_vacated + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\'><b>Status</b></td><td class=\'text-left no-border\'>" + item.status_style + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\'><b>Latest Posting</b></td><td class=\'text-left no-border\'>" + item.latest_posting + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\' style=\'padding-bottom: 8px;\'><b>Remarks</b></td><td class=\'text-left no-border\' style=\'padding-bottom: 8px;\'>" + item.remarks + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\' style=\'padding-bottom: 0px;\'><b></td><td class=\'text-left no-border\' style=\'padding-bottom: 0px;\'></td></tr>" + 
            "<tr><td class=\'text-right\' style=\'padding-top: 8px; border-color: #808080\'><b>Education</b></td><td class=\'text-left\' style=\'padding-top: 8px; border-color: #808080\'>" + item.education + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\'><b>Experience</b></td><td class=\'text-left no-border\'>" + item.experience + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\'><b>Training</b></td><td class=\'text-left no-border\'>" + item.training + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\'><b>Eligibility</b></td><td class=\'text-left no-border\'>" + item.eligibility + "</td></tr>" + 
            "<tr><td class=\'text-right no-border\'><b>Competency</b></td><td class=\'text-left no-border\'>" + item.competency + "</td></tr>" +
          "</tbody></table>";

          html += '<div class="tr">' +
            '<div class="td item-col" style="width: 30%;">' +
            '<div class="row item-style"><div class="col-sm-8 my-auto"><h5 style="margin-bottom: 0px;"><b>' + item.item_desc + '</b></h5><div class="poscode">' + item.item_code + ' ' + (item.item_desc_detail != null ? item.item_desc_detail: '') + '</div></div>' + 
            '<div class="col-sm-4 my-auto">' + (item.remarks == "None" ? '<i class="material-icons md-24">lock_open</i>': '<i class="material-icons md-24" data-toggle="tooltip" data-placement="right" data-html="true" title="<font color=red><b>Item Filled</b></font>">lock</i>') + '<i class="material-icons md-24" data-toggle="tooltip" data-placement="right" data-html="true" title="' + tooltipData + '">info</i></div>' +
            '</div>' +
            '</div>' +
            '<div class="td endorsed-col container ' + (item.remarks == "None" ? 'enabled': '') + '" style="width: 35%;" id="endorsed_' + item.id + '"></div>' +
            '<div class="td recommended-col container ' + (item.remarks == "None" ? 'enabled': '') + '" style="width: 35%;" id="recommended_' + item.id + '"></div>' +
            '</div>';
        }
        html += '</div>';
        div.innerHTML = html;
        vacancies_div.appendChild(div);
      }
    }

    function displayContenders(data) {
      var contenders_div = document.getElementById("contenders");
      contenders_div.innerHTML = '';

      for(contender of data) {
        var div = document.createElement("div");
        div.id = contender.id;
        div.classList.add("row", "contender-style");
        div.setAttribute("data-name", contender.name);
        div.innerHTML += '<div class="col-sm-3 my-auto"><img class="avatar-img" src="' + contender.img + '" onError="imgError(this);" data-toggle="tooltip" data-placement="right" title="Priority"/></div><div class="col-sm-7 my-auto" style="padding-right: 0px;"><h5 style="margin-bottom: 0px;"><b>' + contender.name + '</b></h5><div class="poscode">' + contender.current_pos + '</div></div><div class="col-sm-2 my-auto"><img src="images/arrow_icon.png" style="width:20px;"/></div>';
        contenders_div.appendChild(div);
      }
      $("[data-toggle='tooltip']").tooltip({
        sanitize: false
      }); // initialize material dashboard tooltips every refresh of contenders
      // applyColorsToContenders();
    }

    function applyColorsToContenders() {
      var contenders_el = document.getElementsByClassName("row contender-style");
      var color_accents = [
        "firebrick", "floralwhite", "forestgreen",
        "fuchsia", "gainsboro", "ghostwhite",
        "gold", "goldenrod", "green",
        "honeydrew", "hotpink", "indianred",
        "powderblue", "purple", "rebeccapurple",
        "red", "rosybrown", "royalblue",
        "saddlebrown", "salmon", "sandybrown",
        "seagreen", "sienna",
        "silver", "skyblue", "slateblue"
      ];

      for(element of contenders_el) {
        var i = Math.floor((Math.random() * color_accents.length) + 1);
        element.setAttribute("style", "border-left-color: " + color_accents[i] + ";");
      }
    }

    function imgError(image) {
      image.onerror = "";
      image.src = "images/person.png";
      return true;
    }
  </script>
  <!-- Dragula -->
  <script src="assets/js/dragula.js"></script>
  <script type="text/javascript"> 
    <?php include_once("dragula.js") ?>
  </script>