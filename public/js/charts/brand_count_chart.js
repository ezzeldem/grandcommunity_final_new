let influ_count = $('#brand-container').data('influ');
let camp_count = $('#brand-container').data('camp');
let branches_count = $('#brand-container').data('branches');
let subbrands_count = $('#brand-container').data('subbrands');


let allCounts=[];
let labels=['Influencers','Campaigns','Branches','Sub Brands'];
allCounts.push(influ_count)
allCounts.push(camp_count)
allCounts.push(branches_count)
allCounts.push(subbrands_count)

const brandData = {
    labels: labels,
    datasets: [
        {
            data: allCounts,
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)',
                'rgb(0, 128, 0)',
            ],
            hoverOffset: 4,
        }
    ]
};

const brandConfig = {
    type: 'doughnut',
    data: brandData,

};
const brandChart = new Chart(
    document.getElementById('brand-count-chart'),
    brandConfig
);
