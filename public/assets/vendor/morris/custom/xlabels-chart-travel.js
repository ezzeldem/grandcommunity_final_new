// Displaying X Labels Diagonally (Bar Chart)
var day_data = [
	{"period": "Q1", "Booked": 400, "Cancelled": 80},
	{"period": "Q2", "Booked": 540, "Cancelled": 235},
	{"period": "Q3", "Booked": 300, "Cancelled": 105},
	{"period": "Q4", "Booked": 460, "Cancelled": 175},
];
Morris.Bar({
	element: 'xlabels-chart-travel',
	data: day_data,
	xkey: 'period',
	ykeys: ['Booked', 'Cancelled'],
	labels: ['Booked', 'Cancelled'],
	gridLineColor: "#3d4767",
	resize: true,
	hideHover: "auto",
	barColors:['#f53a40', '#f3a33c', '#2fcc7e', '#2f71c1'],
});