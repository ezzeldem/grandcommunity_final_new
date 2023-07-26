let brandValue = $('#brand-container').data('value');
let labelsBrand = [] , activeBrand=[],inactiveBrand=[],paendingBrand=[],rejectBrand=[] ;
let brandTotalY =0;

for(let s in brandValue){
    labelsBrand.push(s);
    activeBrand.push(brandValue[s]['active'])
    inactiveBrand.push(brandValue[s]['inactive'])
    paendingBrand.push(brandValue[s]['pending'])
    rejectBrand.push(brandValue[s]['reject'])
    brandTotalY+=brandValue[s]['active']+brandValue[s]['inactive']+brandValue[s]['pending']+brandValue[s]['reject'];
}
const brandData = {
    labels: labelsBrand,
    datasets: [
        {
            label: 'active',
            backgroundColor: 'rgba(46, 134, 222,1.0)',
            borderColor: 'rgba(46, 134, 222,0.5)',
            data: activeBrand,
        },
        {
            label: 'inactive',
            backgroundColor: 'rgb(190,53,94)',
            borderColor: 'rgba(227,10,35,0.38)',
            data: inactiveBrand,
        },
        {
            label: 'pending',
            backgroundColor: 'rgb(69 222 46)',
            borderColor: 'rgb(69 222 46)',
            data: paendingBrand,
        },
        {
            label: 'rejected',
            backgroundColor: 'rgb(96 66 115)',
            borderColor: 'rgb(96 66 115)',
            data: rejectBrand,
        },
    ]
};

const brandConfig = {
    type: 'bar',
    data: brandData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Brands'
            }
        },
    }
};
const brandChart = new Chart(
    document.getElementById('brand-chart'),
    brandConfig
);
