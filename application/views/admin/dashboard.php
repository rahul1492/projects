
 <!-- BEGIN Content -->
            <div id="main-content">			

                <!-- BEGIN Page Title -->
                <div class="page-title">
                    <div>
                        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
                        <h4>Overview, stats, chart and more</h4>
                    </div>
                </div>
                <!-- END Page Title -->

                <!-- BEGIN Breadcrumb -->
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li class="active"><i class="fa fa-home"></i> Home</li>
                    </ul>
                </div>
                <!-- END Breadcrumb -->

                <!-- BEGIN Tiles -->
               <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                  
                             <div class="col-md-2">
                                <a class="tile tile-magenta shadows" href="<?php echo base_url('admin/user/manage');?>">
                                    <div class="img img-center">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <p class="title text-center">User</p>
                                </a>
                             </div>

                             <div class="col-md-2">
                                <a class="tile tile-orange" href="<?php echo base_url('admin/doctor/manage');?>"">
                                    <div class="img img-center">
                                        <i class="fa fa-user-md"></i>
                                    </div>
                                    <p class="title text-center">Doctor</p>
                                </a>
                             </div>

                             <div class="col-md-2">
                                <a class="tile tile-red" href="<?php echo base_url('admin/category');?>"">
                                    <div class="img img-center">
                                        <i class="fa fa-sitemap"></i>
                                    </div>
                                    <p class="title text-center">Category</p>
                                </a>
                             </div>

                        </div>
                    </div>
                </div>

<script type="text/javascript">

    //---------------------------- Dashboard Visitors Chart -------------------------//
$(function() {    
    if (jQuery.plot) {
        //define placeholder class
        var placeholder = $("#visitors-chart");

        if ($(placeholder).size() == 0) {
            return;
        }
        //some data
        var d1 = [
                  
        ];
      

        var d2 = [  
         
        ];
        var chartColours = ['#88bbc8', '#9FC569', '#ed7a53', '#bbdce3', '#9a3b1b', '#5a8022', '#2c7282'];
        //graph options
        var options = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f" ,
                    labelMargin: 5,
                    axisMargin: 0, 
                    borderWidth: 0,
                    borderColor:null,
                    minBorderMargin: 5 ,
                    clickable: true, 
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 20
                },
                series: {
                    grow: {
                        active: false,
                        stepMode: "linear",
                        steps: 50,
                        stepDelay: true
                    },
                    lines: {
                        show: true,
                        fill: true,
                        lineWidth: 3,
                        steps: false
                        },
                    points: {
                        show:true,
                        radius: 4,
                        symbol: "circle",
                        fill: true,
                        borderColor: "#fff"
                    }
                },
                legend: { 
                    position: "ne", 
                    margin: [0,-25], 
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function(label, series) {
                        // just add some space to labes
                        return label+'&nbsp;&nbsp;';
                     }
                },
                yaxis: { min: 0 },
                xaxis: {ticks:11, tickDecimals: 0},
                colors: chartColours,
                shadowSize:1,
                tooltip: true, //activate tooltip
                tooltipOpts: {
                    content: "%s : %y.0",
                    defaultTheme: false,
                    shifts: {
                        x: -30,
                        y: -50
                    }
                }
            };
            $.plot(placeholder, [
            {
                label: "&nbsp; <b></b> Car Registration", 
                data: d1,
                //lines: {fillColor: "#f2f7f9"},
                points: {fillColor: "#88bbc8"}
            }, 
            {
                label: "&nbsp; <b></b> User Registeration", 
               
                data: d2,
               // lines: {fillColor: "#fff8f2"},
                points: {fillColor: "#9FC569"}
            } 

        ], options);
    }
})


/*yearly chart*/

</script>
                

               
                <!-- END Main Content -->
                
               

                
                <!-- END Main Content -->
                