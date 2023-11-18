var pieCtx = document.getElementById('myChart1').getContext('2d');
var myPieChart = new Chart(pieCtx, pieConfig);
// <block:data:3>
const data = {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1,
      backgroundColor: ['#CB4335', '#1F618D', '#F1C40F', '#27AE60', '#884EA0', '#D35400'],
    }]
  };
  // </block:data>
  
  // <block:handleHover:1>
  // Append '4d' to the colors (alpha channel), except for the hovered index
  function handleHover(evt, item, legend) {
    legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
      colors[index] = index === item.index || color.length === 9 ? color : color + '4D';
    });
    legend.chart.update();
  }
  // </block:handleHover>
  
  // <block:handleLeave:2>
  // Removes the alpha channel from background colors
  function handleLeave(evt, item, legend) {
    legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
      colors[index] = color.length === 9 ? color.slice(0, -2) : color;
    });
    legend.chart.update();
  }
  // </block:handleLeave>
  
  // <block:config:0>
  const config = {
    type: 'pie',
    data: data,
    options: {
      plugins: {
        legend: {
          onHover: handleHover,
          onLeave: handleLeave
        }
      }
    }
  };
  // </block:config>
  
  module.exports = {
    config
  };