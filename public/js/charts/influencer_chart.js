let influencerValue = $('#influencer-container').data('value');
let labelsInfluencer = [] , activeInfluencer=[],inactiveInfluencer=[] ,pendingInfluencer=[],rejectedInfluencer=[];
let influencerTotalY =0;
for(let s in influencerValue){
    // console.log(s)
    labelsInfluencer.push(s);
    activeInfluencer.push(influencerValue[s]['active'])
    inactiveInfluencer.push(influencerValue[s]['inactive'])
    pendingInfluencer.push(influencerValue[s]['pending'])
    rejectedInfluencer.push(influencerValue[s]['reject'])
    influencerTotalY+=influencerValue[s]['active']+influencerValue[s]['inactive']+influencerValue[s]['pending']+influencerValue[s]['reject']
}
const influencerData = {
    labels: labelsInfluencer,
    datasets: [
        {
            label: 'active',
            backgroundColor: 'rgb(69,222,46)',
            borderColor: 'rgba(46,222,134,0.5)',
            data: activeInfluencer,
        },
        {
            label: 'inactive',
            backgroundColor: 'rgb(0,25,30)',
            borderColor: 'rgba(0,0,0,0.5)',
            data: inactiveInfluencer,
        },
        {
            label: 'pending',
            backgroundColor: 'rgb(190 53 94)',
            borderColor: 'rgb(190 53 94)',
            data: pendingInfluencer,
        },
        {
            label: 'rejected',
            backgroundColor: 'rgb(96 66 115)',
            borderColor: 'rgb(96 66 115)',
            data: rejectedInfluencer,
        },
    ]
};

const influencerConfig = {
    type: 'bar',
    data: influencerData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Influencers'
            }
        },
        // scales: {
        //     y: {
        //         beginAtZero: true,
        //         min: 0,
        //         max: influencerTotalY,
        //         ticks: {
        //             // forces step size to be 50 units
        //             stepSize: 1,
        //             stepValue: 1
        //         }
        //     }
        // },
    }
};
const influencerChart = new Chart(
    document.getElementById('influencer-chart'),
    influencerConfig
);
