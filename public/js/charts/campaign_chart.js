function initChart (campaignValue,campaignType,campaignStatus){
    // let campaignValue = $('#campaign-container').data('value');
    // let campaignType = $('#campaign-container').data('type');
    // let campaignStatus = $('#campaign-container').data('status');

    let labelsCampaign = [] ,
        data=[]
    console.log(campaignValue)
    console.log(campaignType)
    console.log(campaignStatus)
    for(let s in campaignValue) {
        labelsCampaign.push(s);
        if(campaignType == 'visit' && campaignStatus == 0){
            data.push(campaignValue[s]['Active_visit'])
        }else if(campaignType == 'onhold' && campaignStatus == 5){
            data.push(campaignValue[s]['Active_onhold'])
        }else if(campaignType == 'completed' && campaignStatus == 2){
            data.push(campaignValue[s]['Active_completed'])
        }

    }
    const campaignData = {
        labels: labelsCampaign,
        datasets: [
            {
                label: campaignStatus + ' ' + campaignType,
                backgroundColor: 'rgba(46, 134, 222,1.0)',
                borderColor: 'rgba(46, 134, 222,0.5)',
                data: data,
            }
        ]
    };

    const campaignConfig = {
        type: 'bar',
        data: campaignData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Campaigns'
                }
            }

        }
    };
    const campaignChart = new Chart(
        document.getElementById('campaign-chart'),
        campaignConfig
    );

}

export {initChart}
