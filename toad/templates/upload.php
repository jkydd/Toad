
<?php
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
}
// Allow certain file formats
if($imageFileType != "csv"  ) {
    //echo "Sorry, only xml and csv files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $ufile = basename( $_FILES["fileToUpload"]["name"]);
        //echo "The fname is: ". $ufile;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
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
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown printer
                                took a galley of type and scrambled it to make a type specimen book. It has survived
                                not only five centuries, but also the leap into electronic typesetting, remaining
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
                                    <input type="submit" value="Upload" name="submit">
                                </form></div>
                            <div class="col-lg-4 col-xl-4 col-md-4">
                                <label class="checkbox-inline"><input type="checkbox" value="">&nbsp Kinematic</label><br>
                                <label class="checkbox-inline disabled"><input type="checkbox" value="">&nbsp Force Plate</label><br>
                                <label class="checkbox-inline disabled"><input type="checkbox" value="">&nbsp  Timing of Toad hops</label>
                            </div>
                        </div>

                        <!-- footer -->
                        <div class="modal-footer">
                            <table class="table table-bordered manage">
                                <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Delete</th>
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
<h3 id="header"> Parallel Coordinates</h3>
<div class="row graphs justify-content-center ">
</div>
<script>
    $(function () {
        let upload_status = "<?php echo $uploadOk;?>";
        console.log("this is the status of the upload: "+ upload_status);
        graph();
    });

    /***
     * This is the d3 code to draw the parallel graph.
     */
    function graph(){
        let fileName = "<?php echo $ufile;?>";
        console.log("csv filename: " + fileName);
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
                return d !== "name" && d.indexOf("pt2_X") === -1 && d.indexOf("pt2_Y") === -1  && d.indexOf("pt2_Z") === -1 &&(y[d] = d3.scale.linear()
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



