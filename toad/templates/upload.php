<?php
//===================================================================================
// This is necessary so that the system deletes all the files that previously exist.
$folder = 'uploads';
//Get a list of all of the file names in the folder.
$files = glob($folder . '/*');

//Loop through the file list.
foreach($files as $file){
    //Make sure that this is a file and not a directory.
    if(is_file($file)){
        //Use the unlink function to delete the file.
        unlink($file);
    }
}
//=====================================================================================
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 1;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $uploadOk = 0;
    echo "<script type='text/javascript'>alert('File already exist!');</script>";
}
// Allow certain file formats
if($imageFileType != "csv"  ) {
    //echo "Sorry, only xml and csv files are allowed.";
    $uploadOk = 0;
    echo "<script type='text/javascript'>alert('File is not a csv');</script>";
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "<script type='text/javascript'>alert('File not uploaded');</script>";
}
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $ufile = basename( $_FILES["fileToUpload"]["name"]);
    }
    else {
        echo "<script type='text/javascript'>alert('File not uploaded');</script>";
    }
}
?>
<!--===============================================================================-->
<!DOCTYPE html>
<html>
<body>
<link href="https://fonts.googleapis.com/css?family=Monoton|ZCOOL+KuaiLe|Major+Mono+Display|Slabo+27px|Staatliches|Patrick+Hand" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
<script src="https://d3js.org/d3.v3.min.js"></script>
<link rel="stylesheet" href="static/css/index.css">

<nav class="navbar navbar-expand-lg bg-primary">
    <a class="navbar-brand" href="#">TOAD++</a>
    <button id="open" class="navbar-toggler bg-light" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fas fa-bars"></i></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item about"><button data-toggle="modal" data-target="#about" class="nav-link">About</button></li>
            <div class="modal " id="about">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">About</h4>
                            <button type="button" class="close" style="color:black" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="row modal-row">
                            <div class="col-lg-12 col-xl-12 col-md-12">
                                <br>
                                <h5><b>Summary:</b></h5>
                                <p>The following plot is a parallel graph consisting of six variables: X position,
                                    Y position, Z position, Elbow Angle, Humeral Protraction/Retraction, Humeral
                                    Elevation/Depression. The data was provided by professor Ekstrom, a Wheaton College
                                    Biology Professor from an experiment testing the differences between a frogs&apos;
                                    sighted and blinded hops.</p>
                                <h5><b>File Format:</b></h5>
                                <p>The uploaded file must be kinematic data provided by Professor Ekstrom, uploaded as a
                                    CSV file. To create a file from source data, upload a kinematic data file from any of
                                    the frog&apos;s hops. The file can be of any size and the application will automatically
                                    clean (scrub) the file to filter any unaccepted data while reading the accepted variables
                                    for plotting.</p>
                                <h5><b>Interaction:</b></h5>
                                <p>Users may select a section of variables by hovering over a variable&apos;s axis, wait for
                                    the + symbol to show up, then click and drag the section the user wants to select.
                                    By selecting a section of a variable&apos;s axis, lines that are not selected will turn
                                    gray while the selected lines will remain green. Selecting multiple variables will
                                    filter the data so that only hops that satisfy all the selected filters are shown.<br>
                                    &nbsp; To reset a variable&apos;s selected sections, hover either above or below the selected section,
                                    wait for the + symbol to show and click. In the case that there is no space on the axis
                                    to click since the selected section is the entire axis, users will have to reduce
                                    the size of the selected section size so the cursor may have space to hover over the
                                    axis directly. This application also supports the option to rearrange the order of the
                                    axis variables. By hovering over the axis name, such as Z position, users may click and
                                    drag to rearrange the order of the axes.
                                <p/>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

            <!--================================= U P L O A D   M O D A L  ======================================-->
            <button type="button" class="btn btn-primary upload" data-toggle="modal" data-target="#myModal">Upload</button>
            <div class="modal " id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Upload / Manage</h4>
                            <button type="button" class="close" style="color:black" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="row modal-row">
                            <div class="modal-body col-lg-8 col-xl-8 col-md-8" id="upload-btn">
                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                    <input type="submit" value="Generate" name="submit">
                                </form></div>
                            <div class="col-lg-4 col-xl-4 col-md-4">
                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp Kinematic</label><br>
                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp Force Plate</label><br>
                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp  Timing of Toad hops</label>
                            </div>
                        </div>

                        <!-- footer -->
                        <div class="modal-footer">
                            <table class="table table-bordered manageTable">
                                <thead>
                                <tr>
                                    <th>Current File Name</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=================================================================================================-->
        </ul>
    </div>
</nav>
<h3 id="header"></h3>
<div class="row graphs justify-content-center "></div>
<br>
<h2 class="construction" style="color:#116dd2; font-family:Monoton,sans-serif;margin-top:30px; text-align: center"> More Visualization Coming soon!</h2>
<script>
    $(function () {
        let upload_status = "<?php echo $uploadOk;?>";
        console.log("1:uploaded 0:not uploaded---> "+ upload_status);
        let fileName = "<?php echo $ufile;?>";
        console.log("csv filename: " + fileName);
        if (upload_status === 0){
            alert("file upload failed")
        }
        else{
            graph(fileName);
            tableInfo(fileName);
        }
        $("#header").html("Parallel Coordinates for " + fileName)

    });



    /***
     * display the file name and the delete option for the file.
     */
    function tableInfo(name){
        let tBody = $(".manageTable > tbody")[0];

        //Add Row.
        let row = tBody.insertRow(-1);

        //Add Name cell.
        let cell = $(row.insertCell(-1));
        cell.html(name);
    }
    /***
     * This is the d3 code to draw the parallel graph.
     */
    function graph(fileName){
        let margin = {top: 30, right: 10, bottom: 10, left: 10},
            width = 1000 - margin.left - margin.right,
            height = 600 - margin.top - margin.bottom;

        let x = d3.scale.ordinal().rangePoints([0, width], 1),
            y = {},
            dragging = {};

        let line = d3.svg.line(),
            axis = d3.svg.axis().orient("left"),
            background,
            foreground;

        let svg = d3.select(".graphs").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
        let home = "uploads/" + fileName;
        console.log("d3 file name: " + home);
        d3.csv(home, function(error, frogs) {

            // Extract the list of dimensions and create a scale for each.
            x.domain(dimensions = d3.keys(frogs[0]).filter(function(d) {
                return d !== "name" && d.indexOf("pt2_X") === -1 && d.indexOf("pt2_Y") === -1  && d.indexOf("pt2_Z") === -1 && d.indexOf("pt3_X") === -1 && d.indexOf("pt3_Y") === -1 && d.indexOf("pt3_Z") === -1 && d.indexOf("pt4_X") === -1 && d.indexOf("pt4_Y") === -1 && d.indexOf("pt4_Z") === -1 && d.indexOf("pt5_X") === -1&& d.indexOf("pt5_Y") === -1 && d.indexOf("pt5_Z") === -1 && d.indexOf("pt6_X") === -1 && d.indexOf("pt6_Y") === -1 && d.indexOf("pt6_Z") === -1 && d.indexOf("ElbowLa") === -1 && d.indexOf("ElbowLb") === -1 && d.indexOf("Midline (1-2)") === -1 && d.indexOf("Pt5 - Pt1") === -1 && d.indexOf("Pt3 - Pt5") === -1 && d.indexOf("Pt2 - Pt3") === -1 && d.indexOf("Pt5 - Pt2") === -1 &&d.indexOf("ElbowLc") === -1 && d.indexOf("ElbowAng") === -1 && d.indexOf("Pt5 - Pt2 (x,z)") === -1 && d.indexOf("Pt1 - Pt2 (x,z)") === -1 && d.indexOf("Pt5 - Pt1 (x,z)") === -1 && d.indexOf("HPR Comp Ang") && d.indexOf("Pt3 - Pt5 (y,z)")&& d.indexOf("Pt2 - Pt3 (y,z)")&& d.indexOf("Pt5 - Pt2 (y,z)")=== -1 &&(y[d] = d3.scale.linear()
                    .domain(d3.extent(frogs, function(p) { return +p[d]; }))
                    .range([height, 0]));
            }));

            // Add grey background lines for context.
            background = svg.append("g")
                .attr("class", "background")
                .selectAll("path")
                .data(frogs)
                .enter().append("path")
                .attr("d", path);

            // Add blue foreground lines for focus.
            foreground = svg.append("g")
                .attr("class", "foreground")
                .selectAll("path")
                .data(frogs)
                .enter().append("path")
                .attr("d", path);

            // Add a group element for each dimension.
            let g = svg.selectAll(".dimension")
                .data(dimensions)
                .enter().append("g")
                .attr("class", "dimension")
                .attr("transform", function(d) { return "translate(" + x(d) + ")"; })
                .call(d3.behavior.drag()
                    .origin(function(d) { return {x: x(d)}; })
                    .on("dragstart", function(d) {
                        dragging[d] = x(d);
                        background.attr("visibility", "hidden");
                    })
                    .on("drag", function(d) {
                        dragging[d] = Math.min(width, Math.max(0, d3.event.x));
                        foreground.attr("d", path);
                        dimensions.sort(function(a, b) { return position(a) - position(b); });
                        x.domain(dimensions);
                        g.attr("transform", function(d) { return "translate(" + position(d) + ")"; })
                    })
                    .on("dragend", function(d) {
                        delete dragging[d];
                        transition(d3.select(this)).attr("transform", "translate(" + x(d) + ")");
                        transition(foreground).attr("d", path);
                        background
                            .attr("d", path)
                            .transition()
                            .delay(500)
                            .duration(0)
                            .attr("visibility", null);
                    }));

            // Add an axis and title.
            g.append("g")
                .attr("class", "axis")
                .each(function(d) { d3.select(this).call(axis.scale(y[d])); })
                .append("text")
                .style("text-anchor", "middle")
                .attr("y", -9)
                .text(function(d) { return d; });

            // Add and store a brush for each axis.
            g.append("g")
                .attr("class", "brush")
                .each(function(d) {
                    d3.select(this).call(y[d].brush = d3.svg.brush().y(y[d]).on("brushstart", brushstart).on("brush", brush));
                })
                .selectAll("rect")
                .attr("x", -8)
                .attr("width", 16);
        });
        function position(d) {
            let v = dragging[d];
            return v == null ? x(d) : v;
        }
        function transition(g) {
            return g.transition().duration(500);
        }

// Returns the path for a given data point.
        function path(d) {
            return line(dimensions.map(function(p) { return [position(p), y[p](d[p])]; }));
        }

        function brushstart() {
            d3.event.sourceEvent.stopPropagation();
        }

// Handles a brush event, toggling the display of foreground lines.
        function brush() {
            let actives = dimensions.filter(function(p) { return !y[p].brush.empty(); }),
                extents = actives.map(function(p) { return y[p].brush.extent(); });
            foreground.style("display", function(d) {
                return actives.every(function(p, i) {
                    return extents[i][0] <= d[p] && d[p] <= extents[i][1];
                }) ? null : "none";
            });
        }
    }
</script>

</body>
</html>



