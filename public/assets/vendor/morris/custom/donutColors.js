// Morris Donut
Morris.Donut({
	element: 'donutColors',
	data: [
		{value: 30, label: 'foo'},
		{value: 15, label: 'bar'},
		{value: 10, label: 'baz'},
		{value: 5, label: 'A really really long label'}
	],
	backgroundColor: '#ffffff',
	labelColor: '#bcd0f7',
	colors:['#2f71c1', '#f53a40', '#f3a33c', '#2fcc7e'],
	resize: true,
	hideHover: "auto",
	gridLineColor: "#3d4767",
	formatter: function (x) { return x + "%"}
});