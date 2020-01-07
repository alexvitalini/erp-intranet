<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Cefa</title>

  </head>

  <body class="nav-md">
    <div class="container body" style="background-color: #fff">
      <div class="main_container">
        <!-- Contenido de la página  -->
        <div class="col_der" role="main">
          <div class="">
            <div class="titulo_pagina">
              <div class="titulo_izq">
                <h3>Echarts <small>Gráficas de Ejemplo</small></h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
             
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_titulo">
                    <h2>Ejemplo gráfica de barras</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_contenido">
                   <p>Para poder realizar esta gráfica en la parte del codigo <code>series</code> del javascript es necesario poner el <code>type</code> como <code>bar</code> para realizar esta gráfica de barras</p>
                    <div id="gra_bar" style="height:350px;"></div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_titulo">
                    <h2>Gráfica de barras radiales </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_contenido">
                   <p>Para poder realizar esta gráfica en la parte del codigo <code>series</code> del javascript es necesario poner el <code>type</code> como <code>pie</code>, <code>radius</code> a <code>[105,103]</code> y <code>clockWise</code> con el valor de <code>!1</code> en cada una de las series  para realizar esta gráfica de barras radiales</p>
                    <div id="gra_pas" style="height:350px;"></div>
                  </div>
                </div>
              </div>


              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_titulo">
                    <h2>Gráfica circular</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_contenido">
                    <p>Para poder realizar esta gráfica en la parte del codigo <code>series</code> del javascript es necesario poner el <code>type</code> como <code>pie</code> , <code>radius</code> al <code>55%</code> y <code>center</code> con los valores de <code>["50%,48%"]</code> para realizar esta gráfica circular</p>
                    <div id="gra_cir" style="height:350px;"></div>

                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_titulo">
                    <h2>Gráfica circular de área polar</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_contenido">
                    <p>Para poder realizar esta gráfica en la parte del codigo <code>series</code> del javascript es necesario poner el <code>type</code> como <code>pie</code> poner <code>roseType</code> como <code>area</code>, <code>radius</code> a <code>[25,90]</code> y <code>center</code> con los valores de <code>["50%",170]</code>tambien se debe colorcar un <code>sort</code> con valor de <code>ascending</code> para realizar esta gráfica circular de área polar</p>
                    <div id="gra_cir_ar" style="height:350px;"></div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_titulo">
                    <h2>Gráfica de anillo</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_contenido">
                   <p>Para poder realizar esta gráfica en la parte del codigo <code>series</code> del javascript es necesario poner el <code>type</code> como <code>pie</code> poner un <code>radius</code> a <code>[35%,55%]</code>para realizar esta gráfica circular de anillo</p>
                    <div id="gra_don" style="height:350px;"></div>

                  </div>
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_titulo">
                    <h2>Gráfica de linea</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_contenido">
                    <p>Para poder realizar esta gráfica en la parte del codigo <code>series</code> del javascript es necesario poner el <code>type</code> como <code>line</code> agregar <code>smooth</code> a <code>!0</code>para realizar esta gráfica linear, agregamos un <code>toolbox</code> para Para añadir herramientas adicionales</p>
                    <div id="gra_lin" style="height:350px;"></div>

                  </div>
                </div>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_titulo">
                    <h2>Gráfica de barras horizontales</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_contenido">
                   <p>Para poder realizar esta gráfica en la parte del codigo <code>series</code> del javascript es necesario poner el <code>type</code> como <code>bar</code> pero en esta ocasión <code>xAxis</code> contendrá los valores y <code>yAxis</code> contendrá la categoria y los valores de esta categoría para realizar esta gráfica de barras horizontales.</p>
                    <div id="gra_bar_hor" style="height:370px;"></div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_titulo">
                    <h2>Uso de gráficas</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_contenido">
                  <p>Para iniciar las gráficas es necesario crear un <code>div</code> con un identificador que se usara para  iniciar la gráfica con JavaScript a través de DOM, también se le debe definir un alto con algún estilo a dicho div. <br>
                  Las gráficas utilizan echarts de librería, hay que declarar una función que inicie las gráficas, dentro de esta función  pondremos una variable en este caso es  “a” que contiene los elementos que se utilizaran para las gráficas como: colores, tooltips, líneas de identificación, títulos, tipo de fuente espacios, etc.  <br>
                  A continuación se nombran las opciones y su uso <br></p>
                 <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>opción</th>
                          <th>Descripción</th>
                          <th>valores</th>
                        </tr>
                      </thead>
                      <tbody>
                       <tr>
                          <td>series</td>
                          <td>Dentro de este arreglo se definen los datos de la gráfica como: nombre de la serie, tipo de gráfica datos las marcas de máximo o mínimo</td>
                          <td>name, type, data</td>
                       </tr>
                       <tr>
                          <td>Atributo type  dentro de series</td>
                          <td>cambia el tipo de gráfica a utilizar</td>
                          <td>bar, line, pie. por default:line</td>
                       </tr>
                       <tr>
                          <td>xAxis</td>
                          <td>Aquí se define qué tipo de serie que será en coordenadas tipo "x" y el tipo de datos ejemplo meses  </td>
                          <td>data, type</td>
                       </tr>
                         <tr>
                          <td>yAxis</td>
                          <td>Aquí se define qué tipo de serie que será en coordenadas tipo "y" y el tipo de datos ejemplo meses  </td>
                          <td>data, type</td>
                       </tr>
                       <tr>
                          <td>title</td>
                          <td>Dentro de este se pueden definir color de letra, tamaño de fuente, espacio entre elementos de los titulos y subtitulos del elemento.</td>
                          <td>text, color,</td>
                       </tr>
                        <tr>
                          <td>itemgap</td>
                          <td>Define el la distancia entre elementos. </td>
                          <td>Default:10 </td>
                        </tr>
                       <tr>
                          <td>tooltip</td>
                          <td>Dentro de este se pueden definir color de letra, tamaño de fuente, espacio entre elementos de los titulos y subtitulos del elemento.</td>
                          <td>text, color, show</td>
                       </tr>
                       <tr>
                          <td>toolbox</td>
                          <td>Un grupo de herramientas de utilidad, que incluye exportación, vista de datos, cambio de tipo dinámico, zoom de área de datos y reinicio.</td>
                          <td>default show:true</td>
                        </tr>
                         <tr>
                          <td>radius</td>
                          <td>Radio del gráfico circular, el primero de los cuales es el radio interior, y el segundo es el radio exterior.</td>
                          <td> default: [0, '75%']</td>
                        </tr>
                         <tr>
                          <td>clockWise</td>
                          <td>define sii el diseño de los sectores del gráfico circular es en sentido de las agujas del reloj.</td>
                          <td>default: true</td>
                        </tr>
                         <tr>
                          <td>roseType</td>
                          <td>Ya sea para mostrar como tabla Nightingale, que distingue datos por radio. Hay 2 modos opcionales: <br>
                          'radius' Use el ángulo central para mostrar el porcentaje de datos y el radio para mostrar el tamaño de los datos. <br>
                          'area' Todos los sectores compartirán el mismo ángulo central, el tamaño de los datos solo se muestra a través de los radios.</td>
                          <td>default:false</td>
                        </tr>
                         <tr>
                          <td>center</td>
                          <td>Posición central del gráfico circular, el primero de los cuales es la posición horizontal, y el segundo es la posición vertical. <br>
                          Cuando se establece en porcentaje, el objeto es relativo al ancho del contenedor y el segundo elemento a la altura.</td>
                          <td> default: ['50%', '50%'] </td>
                        </tr>
                         <tr>
                          <td>sort</td>
                          <td>Clasificación de datos, que puede ser ya sea 'ascendente', 'descendente', 'ninguno' (en orden de datos).</td>
                          <td>default: 'descending'</td>
                        </tr>
                        <tr>
                          <td>smooth</td>
                            <td>Para mostrar una lijera curva en grafica de lineas</td>
                          <td> default: false </td>
                        </tr>


                      </tbody>
                    </table>
                    ejemplo de gráfica simple
                     <pre>
                                  //inizializar la gráfica 
                                   var myChart = echarts.init(document.getElementById('gráfica'));

                                   // definir opciones y datos de la gráfica
                                   var option = {
            
                                       backgroundColor: '#f0f0f0',
                                       title: {
                                           text: 'Cursos por mes'
                                       },
                                       tooltip: {},
                                       legend: {
                                           data:['Inscritos'],
                                       },
                                       xAxis: {
                                           data: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"]
                                       },
                                       itemStyle: {
                                           normal: {
                                               color: '#c49e33',
                                               shadowBlur: 200,
                                               shadowColor: '0x000000'
                                           }
                                       },
                                       yAxis: {},
                                       series: [{
                                           name: 'Inscritos',
                                           type: 'bar',
                                           data: [5, 50, 36, 10, 10, 20,5,8,10,30,15,18],
                                       }]
                                   };

                                   //agregar las opciones a la gráfica
                                   myChart.setOption(option);
                            </pre>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Contenido de la página  -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="muestras/plugins/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="muestras/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="muestras/plugins/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="muestras/plugins/nprogress/nprogress.js"></script>
    <!-- ECharts -->
    <script src="muestras/plugins/echarts/dist/echarts.min.js"></script>

    <!-- Scripts -->
    <script src="muestras/js/javascript.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
  </body>
</html>
