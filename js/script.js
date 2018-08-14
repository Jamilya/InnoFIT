//var bardata = [12, 78, 45, 15, 66, 10, 35];


//get the data with json
d3.json('js/data/forecast.json', function(d){
	
	var data = [];
	for (var i=0; i<100; i++){
		bardata.push(Math.random()*30);
	}


var height = 400,
	width = 600,
	barWidth = 50,
	barOffset = 5,
	tempColor;
	
	
var yScale = d3.scaleLinear()
		.domain([0,d3.max(bardata)])
		.range([0, height])  // according to the range of the container, max value
	
var xScale = d3.scaleBand()
	.domain(bardata)
	.paddingInner(.3)
	.paddingOuter(.1)
	.range([0, width])   //width of the container, the max width

var colors = d3.scaleLinear()
	.domain([0, d3.max(bardata.length *.33, 
			           bardata.length *.66,
					   bardata.length
					   ])
	.range(['#B58929', '#C61C6F', '#85992C', '#268BD2']) 
	
var tooltip = d3.select('body')
				.append('div')
				.style('position', 'absolute')
				.style('padding', '0 10px')
				.style('background', 'white')
				.style('opacity', 0);
	
	
	
	var myChart = 
	d3.select('#viz').append(.svg) //d3 element
	.attr('width', width)
	.attr('height', height)
	.style('background', '#C9D7D6')
  .selectAll('rect').data(bardata)
	.enter().append('rect')
	.attr('fill', function(d, i){
		return colors(i)
		
	})
	.attr('width', function(d){
		return xScale.bandwidth();
	})
	
	
	.attr('height', function(d){
		return yScale(d);
	})
	.attr('x', function(d){
		return xScale(d);
	})
	.attr('y', function (d){
		return height - yScale(d);
	})
	.on('mouseOver', function(d){              //rollover, what happens when we navigate the mouse to individual bars
	
        
		tooltip.transition().duration(200)
		.style('opacity', .9)
		
		tooltip.html(d)
		.style('left', (d3.event.pageX - 35) + 'px')     //we're using CSS style, and having 'left' requires to set px as pixels as a property
		.style('top', (d3.event.pageY - 30) + 'px')
		
		tempColor = this.style.fill;
		d3.select(this)
		.transition()
		.duration(1000)
		.delay(400)
		.style('fill', 'yellow')
	})
	
	.on('mouseOut', function(d){
		d3.select(this)
		.transition()
		//.style('opacity', 1)
		.style('fill', tempColor)
	})
	
	
	;
})
 
	
}); //json import



// get the data
/*d3.csv("data.csv", function(error, data) {
  if (error) throw error;
      console.log(data);
      //format data if required...
      //draw chart
}*/
	
	
	
	