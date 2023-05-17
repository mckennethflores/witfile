// Ejemplo implementando el metodo POST:

$('#mEscritorio').addClass("active");

async function postData(url = '', data = {}) {
  // Opciones por defecto estan marcadas con un *
  const response = await fetch(url, {
    method: 'POST', // *GET, POST, PUT, DELETE, etc.
    mode: 'cors', // no-cors, *cors, same-origin
    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
    credentials: 'same-origin', // include, *same-origin, omit
    headers: {
      'Content-Type': 'application/json'
      // 'Content-Type': 'application/x-www-form-urlencoded',
    },
    redirect: 'follow', // manual, *follow, error
    referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    body: JSON.stringify(data) // body data type must match "Content-Type" header
  });
  return response.json(); // parses JSON response into native JavaScript objects
};

postData("../ajax/reportes.php?op=datosCerrados")
  .then(result => {
    $(function () {
	    var areaChartData = {
	      labels  : ['Cerrados en Primera Cita', 'Cerrados en Segunda Cita+', 'En Prospección'],
	      datasets: [
	        {
	          label               : 'Cantidad de Clientes',
	          backgroundColor: [
			      'rgba(255, 99, 132, 0.2)',
			      'rgba(255, 159, 64, 0.2)',
			      'rgba(255, 205, 86, 0.2)',
			      'rgba(75, 192, 192, 0.2)',
			      'rgba(54, 162, 235, 0.2)',
			      'rgba(153, 102, 255, 0.2)',
			      'rgba(201, 203, 207, 0.2)'
			    ],
			          borderColor: [
			      'rgb(255, 99, 132)',
			      'rgb(255, 159, 64)',
			      'rgb(255, 205, 86)',
			      'rgb(75, 192, 192)',
			      'rgb(54, 162, 235)',
			      'rgb(153, 102, 255)',
			      'rgb(201, 203, 207)'
			    ],
			    borderWidth: 1,
	          pointRadius          : false,
	          pointColor          : '#3b8bba',
	          pointStrokeColor    : 'rgba(60,141,188,1)',
	          pointHighlightFill  : '#fff',
	          pointHighlightStroke: 'rgba(60,141,188,1)',
	          data                : [result.primera_cita,result.segunda_cita,result.prospeccion]
	        },
	      ]
	    }

	    var barChartCanvas = $('#barChart').get(0).getContext('2d')
	    var barChartData = $.extend(true, {}, areaChartData)
	    var temp0 = areaChartData.datasets[0]
	    barChartData.datasets[0] = temp0

	    const config = {
		  type: 'bar',
		  data: barChartData,
		  options: {
		  	responsive              : true,
		      maintainAspectRatio     : false,
		      datasetFill             : false,
		    scales: {
		      yAxes: [{
		            ticks: {
		                beginAtZero: true
		            }
		        }]
		    }
		  },
		};

	    new Chart(barChartCanvas, config);

	  });

		$(function () {
	    var areaChartData2 = {
	      labels  : ['Cerrados', 'Cerrados en el mes'],
	      datasets: [
	        {
	          label               : 'Cantidad',
	          backgroundColor: [
			      'rgba(75, 192, 192, 0.2)',
			      'rgba(153, 102, 255, 0.2)',
			      'rgba(201, 203, 207, 0.2)'
			    ],
			          borderColor: [
			      'rgb(75, 192, 192)',
			      'rgb(153, 102, 255)',
			      'rgb(201, 203, 207)'
			    ],
			    borderWidth: 1,
	          pointRadius          : false,
	          pointColor          : '#3b8bba',
	          pointStrokeColor    : 'rgba(60,141,188,1)',
	          pointHighlightFill  : '#fff',
	          pointHighlightStroke: 'rgba(60,141,188,1)',
	          data                : [result.cerrados, result.cerrados_mes]
	        },
	      ]
	    }

	    var barChartCanvas2 = $('#barChart2').get(0).getContext('2d')
	    var barChartData2 = $.extend(true, {}, areaChartData2)
	    var temp0 = areaChartData2.datasets[0]
	    barChartData2.datasets[0] = temp0

	    const config = {
		  type: 'bar',
		  data: barChartData2,
		  options: {
		  	responsive              : true,
		      maintainAspectRatio     : false,
		      datasetFill             : false,
		    scales: {
		      yAxes: [{
		            ticks: {
		                beginAtZero: true
		            }
		        }]
		    }
		  },
		};

	    new Chart(barChartCanvas2, config);

	  });

		let labels = Object.keys(result.monto_mes);
		let data = [];
		let colors = [];
		let borders = [];
		for (var i = 0; i < result.monto_mes.length; i++) {
			data.push(result.monto_mes[i]);
		}
		colors.push('rgba(255, 99, 132,1)');
		borders.push('rgba(255, 99, 132,1)');
		for (let key in result.monto_mes) {
			data.push(result.monto_mes[key]);
			let red = Math.floor(Math.random() * (255 - 0)) + 0;
			let green = Math.floor(Math.random() * (255 - 0)) + 0;
			let blue = Math.floor(Math.random() * (255 - 0)) + 0;
			let color = 'rgba('+red+','+green+','+blue+', 1)';
			let border = 'rgba('+red+','+green+','+blue+',1)';
			colors.push(color);
			borders.push(border);
		}
		$(function () {
	    var areaChartData3 = {
	      labels  : labels,
	      datasets: [
	        {
	        	fill: false,
	          label               : 'Cantidad',
	          backgroundColor: colors,
			          borderColor: borders,
			    borderWidth: 2,
	          pointColor          : 'rgba(255, 99, 132,1)',
	          pointStrokeColor    : 'rgb(75, 192, 192)',
	          pointHighlightFill  : '#fff',
	          pointHighlightStroke: 'rgb(75, 192, 192)',
	          data                : data,
	          tension: 0.1
	        },
	      ]
	    }

	    var barChartCanvas3 = $('#barChart3').get(0).getContext('2d')
	    var barChartData3 = $.extend(true, {}, areaChartData3)
	    var temp0 = areaChartData3.datasets[0]
	    barChartData3.datasets[0] = temp0

	    const config = {
		  type: 'line',
		  data: barChartData3,
		  options: {
		  	responsive              : true,
		      maintainAspectRatio     : false,
		      datasetFill             : false,
		    scales: {
		      yAxes: [{
		            ticks: {
		                beginAtZero: true
		            }
		        }]
		    }
		  },
		};

	    new Chart(barChartCanvas3, config);

	  });
  });