(function(){var b=window.AmCharts;b.AmGanttChart=b.Class({inherits:b.AmSerialChart,construct:function(a){this.type="gantt";b.AmGanttChart.base.construct.call(this,a);this.cname="AmGanttChart";this.period="ss"},initChart:function(){this.processGanttData();this.dataChanged=!0;b.AmGanttChart.base.initChart.call(this)},parseData:function(){b.AmSerialChart.base.parseData.call(this);this.parseSerialData(this.ganttDataProvider)},processGanttData:function(){var a;this.graphs=[];var t=this.dataProvider;this.ganttDataProvider=
[];var u=this.categoryField,z=this.startField,A=this.endField,B=this.durationField,C=this.startDateField,D=this.endDateField,p=this.colorField,f=this.period,m=b.getDate(this.startDate,this.dataDateFormat,"fff");this.categoryAxis.gridPosition="start";a=this.valueAxis;this.valueAxes=[a];var v;"date"==a.type&&(v=!0);a.minimumDate&&(a.minimumDate=b.getDate(a.minimumDate,n,f));a.maximumDate&&(a.maximumDate=b.getDate(a.maximumDate,n,f));isNaN(a.minimum)||(a.minimumDate=b.changeDate(new Date(m),f,a.minimum,
!0,!0));isNaN(a.maximum)||(a.maximumDate=b.changeDate(new Date(m),f,a.maximum,!0,!0));var n=this.dataDateFormat;for(a=0;a<t.length;a++){var d=t[a],h={};h[u]=d[u];var q=d[this.segmentsField],w;this.ganttDataProvider.push(h);d=d[p];if(q)for(var k=0;k<q.length;k++){var e=q[k],c=e[z],g=e[A],l=e[B];isNaN(c)&&(c=w);isNaN(l)||(g=c+l);var l="start_"+a+"_"+k,r="end_"+a+"_"+k;h[l]=c;w=h[r]=g;if(v){var x=b.getDate(e[C],n,f),y=b.getDate(e[D],n,f);m&&(isNaN(c)||(x=b.changeDate(new Date(m),f,c,!0,!0)),isNaN(g)||
(y=b.changeDate(new Date(m),f,g,!0,!0)));h[l]=x.getTime();h[r]=y.getTime()}g={};b.copyProperties(e,g);c={};b.copyProperties(this.graph,c,!0);c.customData=g;c.labelFunction=this.graph.labelFunction;c.balloonFunction=this.graph.balloonFunction;c.customBullet=this.graph.customBullet;c.type="column";c.openField=l;c.valueField=r;c.clustered=!1;e[p]&&(d=e[p]);void 0===d&&(d=this.colors[a]);(e=this.brightnessStep)&&(d=b.adjustLuminosity(d,k*e/100));c.lineColor=d;this.graphs.push(c)}}}})})();