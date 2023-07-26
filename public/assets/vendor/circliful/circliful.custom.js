$( document ).ready(function() {

	$("#todaysTarget").circliful({
		animation: 1,
		animationStep: 5,
		foregroundBorderWidth: 14,
		backgroundBorderWidth: 14,
		percent: 70,
		textStyle: 'font-size: 12px;',
		fontColor: '#ffffff',
		foregroundColor: '#ff3434',
		backgroundColor: '#4b546f',
	});

	$("#todaysTarget1").circliful({
		animation: 1,
		animationStep: 5,
		foregroundBorderWidth: 14,
		backgroundBorderWidth: 14,
		percent: 70,
		textStyle: 'font-size: 12px;',
		fontColor: '#ffffff',
		foregroundColor: '#008e18',
		backgroundColor: '#4b546f',
	});

	$("#newCustomers").circliful({
		animation: 1,
		animationStep: 5,
		foregroundBorderWidth: 14,
		backgroundBorderWidth: 14,
		percent: 85,
		textStyle: 'font-size: 12px;',
		fontColor: '#ffffff',
		foregroundColor: '#c0d64a',
		backgroundColor: '#4b546f',
	});	

	$("#overallSales").circliful({
		animation: 1,
		animationStep: 5,
		foregroundBorderWidth: 16,
		backgroundBorderWidth: 10,
		percent: 92,
		textStyle: 'font-size: 12px;',
		fontColor: '#ffffff',
		foregroundColor: '#ff3434',
		backgroundColor: '#4b546f',
		multiPercentage: 1,
		percentages: [10, 20, 30],
	});


	$("#overallExpenses").circliful({
		animation: 1,
		animationStep: 5,
		foregroundBorderWidth: 16,
		backgroundBorderWidth: 10,
		percent: 78,
		fontColor: '#ffffff',
		foregroundColor: '#c0d64a',
		backgroundColor: '#4b546f',
		multiPercentage: 1,
		percentages: [10, 20, 30]
	});
	$("#overallIncome").circliful({
		animation: 1,
		animationStep: 5,
		foregroundBorderWidth: 16,
		backgroundBorderWidth: 10,
		percent: 80,
		fontColor: '#ffffff',
		foregroundColor: '#f3a33c',
		backgroundColor: '#4b546f',
		multiPercentage: 1,
		percentages: [10, 20, 30]
	});





	// With Icons
	$("#overallRevenue").circliful({
		animationStep: 5,
		foregroundBorderWidth: 7,
		backgroundBorderWidth: 7,
		percent: 80,
		fontColor: '#bcd0f7',
		foregroundColor: '#ff3434',
		backgroundColor: '#4b546f',
	});


	// With Icons
	$("#overallRevenue1").circliful({
		animationStep: 5,
		foregroundBorderWidth: 10,
		backgroundBorderWidth: 10,
		percent: 80,
		fontColor: '#bcd0f7',
		foregroundColor: '#5fa22d',
		backgroundColor: '#4b546f',
	});

	// With Icons
	$("#overallRevenue2").circliful({
		animationStep: 5,
		foregroundBorderWidth: 10,
		backgroundBorderWidth: 10,
		percent: 80,
		fontColor: '#bcd0f7',
		foregroundColor: '#008e18',
		backgroundColor: '#4b546f',
	});


	$("#projectPlanning").circliful({
		animationStep: 5,
		foregroundBorderWidth: 12,
		backgroundBorderWidth: 7,
		percent: 100,
		fontColor: '#000000',
		foregroundColor: '#da9d46',
		backgroundColor: 'rgba(0, 0, 0, 0.1)',
		icon: '\ea1b',
		iconColor: '#da9d46',
		iconPosition: 'middle',
		textBelow: true,
		animation: 1,
		animationStep: 1,
		start: 2,
		showPercent: 1,		
	});
	

	$("#projectDesign").circliful({
		animationStep: 5,
		foregroundBorderWidth: 12,
		backgroundBorderWidth: 7,
		percent: 100,
		fontColor: '#000000',
		foregroundColor: '#da9d46',
		backgroundColor: 'rgba(0, 0, 0, 0.1)',
		icon: '\ea40',
		iconColor: '#da9d46',
		iconPosition: 'middle',
		textBelow: true,
		animation: 1,
		animationStep: 1,
		start: 2,
		showPercent: 1,
	});


});

