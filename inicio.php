<?php  

Include("bd/database_connection.php");

$query = "SELECT SUBSTRING(qna_pago,1,4) AS 'year' FROM indicador GROUP BY year DESC";
$queryC = "SELECT cve_cpto, concepto AS 'concepto' FROM `cat_conceptos`";
//$query = "SELECT SUBSTRING(qna_pago,1,4) AS 'year' FROM indicador GROUP BY year DESC";
$queryM = "SELECT mes,id_mes,nombre FROM `cat_mes` JOIN meses ON cat_mes.mes = meses.id_mes GROUP BY mes ORDER BY id_quin";

$statement = $connect->prepare($query);
$statementC = $connect->prepare($queryC);
$statementM = $connect->prepare($queryM);

$statement->execute();
$statementC->execute();
$statementM->execute();

$result = $statement->fetchAll();
$resultC = $statementC->fetchAll();
$resultM = $statementM->fetchAll();

?>  

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>INDICADORES</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
  </head>

  <body>
    
    <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar">
      <center><a class="navbar-brand">INICIO</a></center>  
        <div class="p-4 pt-5">
          <a href="inicio.php" class="img logo thumbnailmb-5" style="background-image: url(images/zac.png);"></a>
          <br>
          <br>
          <ul class="list-unstyled components mb-5">
            <li class="active">
              <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Ver gráficas</a>
              <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="inicio.php" >Global</a>
                </li>
                <li>
                    <a href="grafica_concepto.php">Por concepto</a>
                </li>
                <li>
                    <a href="#">Por banco</a> 
                </li>
                <li>
                    <a href="#">Por genero</a>
                </li>
              </ul>
            </li>


            
            <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Por Subistema</a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li>
                    <a href="#">Page 1</a>
                </li>
                <li>
                    <a href="#">Page 2</a>
                </li>
                <li>
                    <a href="#">Page 3</a>
                </li>
              </ul>
            </li>
           </ul>
        </div>
      </nav>
      

      

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <!-- Modal -->
   <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <!-- <h5 class="modal-title w-100 text-center" id="exampleModalLabel">Modal title</h5> -->
          <h4 class="modal-title w-100 text-center" class="modal-title">INFORMACIÓN</h4>
        </div>
        <div class="modal-body" id="body">
        </div>
         <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Cerrar</button>
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar sesión</a>
                </li>
               </ul>
            </div>
          </div>
        </nav>
        <div id="general" class="w3-container menu">
          <center><h1>INDICADORES</h1></center>
          <div>
                    
                <select name="id" class="form-control" id="id" style="width: 300px; height: 35px;">
                            <option value="">Selecciona un año</option>
                            <?php
                            foreach($result as $row)
                            {
                                echo '<option value="'.$row["year"].'">'.$row["year"].'</option>';
                            }
                            ?>
                </select>
          </div>
          <br>
          <br>
          <div class="panel-body">
          <table class="table table-hover">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Mes</th>
                  <th scope="col">Importe</th>
                </tr>
              </thead>
              <tbody  id="col1">

              </tbody>
            </table>
             <div style="width: 200px; height: 10px;"></div>
          </div>
          <div class="panel-body">
            <div id="chart_area" style="width: 1200px; height: 500px;"></div>
          </div>
          <div class="panel-body">
          <table class="table table-hover">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Quincenas</th>
                  <th scope="col">Importe</th>
                </tr>
              </thead>
              <tbody  id="col2">

              </tbody>
            </table>
            <div id="chart_area2" style="width: 1200px; height: 500px;"></div>  
          </div>
        </div>


          <div id="conceptos" class="w3-container menu" style="display:none">
            <center><h1>INDICADORES POR CONCEPTO</h1></center>
          <div>            
                <select name="idc" class="form-control" id="idc"style="width: 300px; height: 35px;">
                            <option value="">Seleccionar Concepto</option>
                            <?php
                            foreach($resultC as $row)
                            {
                                echo '<option value="'.$row["cve_cpto"].'">'.''.$row["cve_cpto"] . ' ' .''.$row["concepto"].'</option>';
                            }
                            ?>
                </select>

                <select name="idm" class="form-control" id="idm" style="width: 300px; height: 35px;">
                            <option value="">Seleccionar Mes</option>
                            <?php
                            foreach($resultM as $row)
                            {
                                echo '<option value="'.$row["mes"].'">'.$row["nombre"].'</option>';
                            }
                            ?>
                </select>
          </div>
          <div class="panel-body">
            <div style="width: 200px; height: 10px;"></div>  
          </div>
          <div class="panel-body">
          <div class="table-bordered table-responsive text-center">
<table class="table table-hover table-bordered" style="border: 1px solid #ddd !important;">
    <tbody>
      <thead class="thead-dark">
                <tr>
                  <th scope="col">Meses</th>
                </tr>
        </thead>
        <tr id="col1">
          
        </tr>
        <thead class="thead-dark">
                <tr>
                  <th scope="col">Importe</th>
                </tr>
        </thead>
        <tr id="col2">
            
        </tr>
        <tr id="col2_1">
            
        </tr>
     
    </tbody>
</table>
</div>


 <!--<table class="table table-hover">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Meses</th>
@ -195,24 +222,38 @@ $resultM = $statementM->fetchAll();
              <tbody  id="col1">

              </tbody>
            </table>
            </table>-->

            <div id="chart_area3" style="width: 1200px; height: 500px;"></div>
          </div>
          </div>
 <div class="table-bordered table-responsive text-center">
<table class="table table-hover table-bordered" style="border: 1px solid #ddd !important;">
    <tbody>
      <thead class="thead-dark">
          <script>
            function openMenu(menuName) {
              var i;
              var x = document.getElementsByClassName("menu");
              for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";  
                  }
              document.getElementById(menuName).style.display = "block";  
            }
            function show(){
              //document.getElementById('chart_area').visibility = "visible";
              var x = document.getElementById('chart_area');
              if (x.style.display === 'none') {
                  x.style.display = 'initial';
              } else {
                  x.style.display = 'none';
                  //x.style.visibility = 'hidden';

              }
               
            }
            function show2(){
              //document.getElementById('chart_area').visibility = "visible";
              var x = document.getElementById('chart_area2');
              if (x.style.display === 'none') {
                  x.style.display = 'initial';
              } else {
                  x.style.display = 'none';
                 // x.style.visibility = 'hidden';

              }
            }
          </script>
          
          
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>   
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>

<!-- libreria de google con internet <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<!-- libreria de google sin internet-->
<script type="text/javascript" src="./charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.load('current', {'packages':['table']});

google.charts.setOnLoadCallback();


// peticion a la base para la gráfica global
function load_conceptowise_data(id, title)
{
    var temp_title = title + ' '+id+'';
    $.ajax({
        url:"bd/fetch.php",
        method:"POST",
        data:{id:id},
        dataType:"JSON",
        success:function(data)
        {
            drawMonthwiseChart(data, temp_title);
        }
    });
}

// peticion a la base de datos para la grafica por quincenas
function load_conceptowise2_data(id, title)
{
    var temp_title = title + ' '+id+'';
    $.ajax({
        url:"bd/nuevo_fetch.php",
        method:"POST",
        data:{id:id},
        dataType:"JSON",
        success:function(data)
        {
            drawMonthwiseChart2(data, temp_title);
        }
    });
}
//peticion para la grafica por conceptos
function load_conceptowise3_data(idc, idm, title)
{
    var temp_title = title + ' '+idc+''+''+idm+'';
    $.ajax({
        url:"bd/fetch_concepto.php",
        method:"POST",
        data:{idc:idc, idm:idm},
        dataType:"JSON",
        success:function(data)
        {
            drawMonthwiseChart3(data, temp_title);
        }
    });
}

// dibujar grafica 1 global
function drawMonthwiseChart(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var tablaData ='';

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Quincenas');
    data.addColumn('float', 'Importe $');
    data.addColumn({
               type: 'string',
               role: 'style'
           });

           $('#col1').empty();

    $.each(jsonData, function(i, jsonData){
        var concepto = jsonData.concepto;
        var importe = parseFloat($.trim(jsonData.importe));
        var style = jsonData.style;
        data.addRows([[concepto, importe, style]]);
        tablaData += '<tr>';
        tablaData += '<td>'+jsonData.concepto+'</td>';
//        tablaData += '<td>'+jsonData.importe+'</td>';
        tablaData += '<td>'+'$'+jsonData.importe+'</td>';
        tablaData += '</tr>';
    });
    tablaData += '<td> <input type="button" class="btn btn-success" value="Ocultar/Mostrar Grafica" onclick="show()"> </td>';

    $("#col1").append(tablaData);
    var axis = data.getNumberOfRows();
   //alert('max data table value: ' + axis);
   for(var x=0;x<axis;x++){
    data.setValue(x, 2, '#'+Math.floor(Math.random()*16777215).toString(16));
   }
    var options = {
        title:chart_main_title,
        legend: 'none',
        hAxis: {
            title: "Mensual"
        },
        vAxis: {
            title: 'Importe',
            format: 'currency'
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));
    chart.draw(data, options);
    google.visualization.events.addListener(chart, 'select', selectHandler);
    function selectHandler() {
      var selection = chart.getSelection()[0];
      var selectedValue = data.getValue(selection.row, 0);
      var selectedImporte = data.getValue(selection.row, 1);
    //alert('Seleccionaste el Mes:' + ' ' + selectedValue + ' ' +'con un Importe de:'+ ' ' + selectedImporte);
   // $("#body").html('Seleccionaste el mes:' + ' ' + selectedValue + ' ' +'con un importe de $:'+ ' ' + selectedImporte);
    //$("#myModal").modal();
    //cambiamos MODAL 
    $("#myModal").modal();
    $("#body").html('Fuente: <strong>U080</strong>, importe total:'+ ' ' +'$'+ selectedImporte/4+'<br>'+
      'Fuente: <strong>Estatal</strong>, importe total:'+ ' ' +'$'+ selectedImporte/4+'<br>'+
      'Fuente: <strong>Propios</strong>, importe total:'+ ' ' + '$'+selectedImporte/4+'<br>'+
      'Fuente: <strong>Fone Otros</strong>, importe total:'+ ' ' +'$'+ selectedImporte/4+'<br>');
    $("#myModal").modal();
}
}
// dibujar grafica 2 por mes 
function drawMonthwiseChart2(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var tablaData ='';

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Quincenas');
    data.addColumn('number', 'Importe $');
    data.addColumn({
               type: 'string',
               role: 'style'
           });

           
           $('#col2').empty();

    $.each(jsonData, function(i, jsonData){
        var concepto = jsonData.concepto;
        var importe = parseFloat($.trim(jsonData.importe));
        var style = jsonData.style;
        data.addRows([[concepto, importe, style]]);
        tablaData += '<tr>';
        tablaData += '<td>'+jsonData.concepto+'</td>';
        tablaData += '<td>'+'$'+jsonData.importe+'</td>';
        tablaData += '</tr>';


    });
    tablaData += '<td> <input type="button" class="btn btn-success" value="Ocultar/Mostrar Grafica" onclick="show2()"> </td>';
  //colores aleatorios 
    var axis = data.getNumberOfRows();
   //alert('max data table value: ' + axis);
   for(var x=0;x<axis;x++){
    data.setValue(x, 2, '#'+Math.floor(Math.random()*16777215).toString(16));
   }
   $("#col2").append(tablaData);

    var options = {
        title:chart_main_title,
        legend: 'none',
        hAxis: {
            title: "Quincenal"
        },
        vAxis: {
            title: 'Importe',
            format: 'currency'
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area2'));
    chart.draw(data, options);

    google.visualization.events.addListener(chart, 'select', selectHandler);
    function selectHandler() {
      var selection = chart.getSelection()[0];
      var selectedValue = data.getValue(selection.row, 0);
      var selectedImporte = data.getValue(selection.row, 1);
  //  alert('Seleccionaste el Mes:' + ' ' + selectedValue + ' ' +'con un importe de:'+ ' ' + selectedImporte);
   // $("#body").html('Seleccionaste el Mes:' + ' ' + selectedValue + ' ' +'con un importe de $:'+ ' ' + selectedImporte);
   $("#myModal").modal();
    $("#body").html('Fuente: <strong>U080</strong>, importe total:'+ ' ' +'$'+ selectedImporte/4+'<br>'+
      'Fuente: <strong>Estatal</strong>, importe total:'+ ' ' +'$'+ selectedImporte/4+'<br>'+
      'Fuente: <strong>Propios</strong>, importe total:'+ ' ' + '$'+selectedImporte/4+'<br>'+
      'Fuente: <strong>Fone Otros</strong>, importe total:'+ ' ' +'$'+ selectedImporte/4+'<br>');
    $("#myModal").modal();
}
}


//dibujar grafica por conceptos
function drawMonthwiseChart3(chart_data, chart_main_title)
{
    var jsonData = chart_data;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Quincenas');
    data.addColumn('number', 'Importe $');
    data.addColumn({
               type: 'string',
               role: 'style'
           });
    $.each(jsonData, function(i, jsonData){
        var concepto = jsonData.concepto;
        var importe = parseFloat($.trim(jsonData.importe));
        var style = jsonData.style;
        data.addRows([[concepto, importe, style]]);


    });

    
    var axis = data.getNumberOfRows();
   //alert('max data table value: ' + axis);
   for(var x=0;x<axis;x++){
    data.setValue(x, 2, '#'+Math.floor(Math.random()*16777215).toString(16));
   }

    var options = {
        title:chart_main_title,
        legend: 'none',
        hAxis: {
            title: "Quincenas"
        },
        vAxis: {
            title: 'Importe',
            format: 'currency'
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_area3'));
    chart.draw(data, options);
    google.visualization.events.addListener(chart, 'select', selectHandler);
    function selectHandler() {
      var selection = chart.getSelection()[0];
      var selectedValue = data.getValue(selection.row, 0);
      var selectedImporte = data.getValue(selection.row, 1);
  //  alert('Seleccionaste el Mes:' + ' ' + selectedValue + ' ' +'con un importe de:'+ ' ' + selectedImporte);
    $("#body").html('Seleccionaste el año:' + ' ' + selectedValue + ' ' +'con un importe de $:'+ ' ' + selectedImporte);
    $("#myModal").modal();
}
}
</script>


<script>
    // Detectar seleccion del select option
$(document).ready(function(){

    $('#id').change(function(){
        var id = $(this).val();
        if(id != '')
        {
            //alert("The text has been changed.");
            load_conceptowise_data(id, 'Importe por cada mes, quincenas correspondientes al año:');
            load_conceptowise2_data(id, 'Importe por cada quincena, quincenas correspondientes al año:');
        }
    });

});

</script>

<script>
    // Detectar seleccion del select option
$(document).ready(function(){

    $('#idc, #idm').change(function(){
        var idc = $('#idc').val();
        var idm = $('#idm').val();
        if(idc != '' && idm != '')
        {
            alert("La gráfica seleccionada cambiará.");
            
            load_conceptowise3_data(idc, idm, 'Importe anual, concepto:  ');
        }
    });

});

</script>

