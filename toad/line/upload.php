<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="http://d3js.org/d3.v3.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Monoton|ZCOOL+KuaiLe|Major+Mono+Display|Slabo+27px|Staatliches|Patrick+Hand" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
                                <h5><b>Line Graph:kinematic data</b></h5>
                                <p>The software allows users to upload their own data. When the user generates the
                                    visualization for the data, there are different graphs displayed. The first graph
                                    is the jump of the frog using 3D movement data. This allows the user to see the position of the frog in the air over time. The user can also hover on the graph to see the exact X and Y position of the frog at a particular time.</p>
                                <h5><b>Radar Graph: XYZ points</b></h5>
                                <p>TThe second graph on the page is a radar chart. This radar chart shows the Elbow Flexion/Extension Angle, Humeral Elevation/Depression Angle, and Humeral Protraction Angle. The radar chart will match the timestamp of the first graph, meaning the radar chart will reflect whichever phase of the jump the frog is on. The change in angle during the jump is shown through the animation of the radar graph as the frog progresses through its jumping phase.</p>
                                <h5><b>Line Graph: Force plate Data</b></h5>
                                <p>The third graph is a line graph of the force plate data. The force plate data displays the force exerted when the frog initially jumps and the force exerted when the frog lands. This force plate data is matched and adjusted accordingly to the first graph of the frog jump.

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
<div class="row justify-content-center" style="margin: 30px 5px 0 5px;">
    <div class="chart-wrapper col-md-5 col-lg-5" style="margin-right: 5px">
        <h5 style="color:cornflowerblue; text-align:center; margin: 20px 0 "> Line Graph of Kinematic Data</h5>
        <div id="chart-line1"></div>
    </div>
    <div class="chart-wrapper col-md-5 col-lg-5" style="margin-left: 5px">
        <h5 style="color:cornflowerblue; text-align:center; margin: 20px 0"> Line Graph of Force Plate Data</h5>
        <div id="chart-line2"></div>
    </div>
</div>
    <?php
        //===================================================================================
        // This is necessary so that the system deletes all the files that previously exist.
        $folder = 'uploads/';
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
<script type="text/javascript">
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

    //============================================================================
    function graph (filename){
        d3.csv(filename, function (error, data) {
            data.forEach(function (d) {
                d.Year = +d.Year;
                d.Atlas_1 = +d.Atlas_1;
                d.Atlas_2 = +d.Atlas_2;
                d.Atlas_3 = +d.Atlas_3;
                d.Atlas_4 = +d.Atlas_4;
                d.Atlas_5 = +d.Atlas_5;
                d.Atlas_6 = +d.Atlas_6;
                d.Atlas_7 = +d.Atlas_7;
                d.Atlas_8 = +d.Atlas_8;
                d.Atlas_9 = +d.Atlas_9;
            });
            let chart = makeLineChart(data, 'Year', {
                'Atlas 1': {column: 'Atlas_1'},
                'Atlas 2': {column: 'Atlas_2'},
                'Atlas 3': {column: 'Atlas_3'},
                'Atlas 4': {column: 'Atlas_4'},
                'Atlas 5': {column: 'Atlas_5'},
                'Atlas 6': {column: 'Atlas_6'},
                'Atlas 7': {column: 'Atlas_7'},
                'Atlas 8': {column: 'Atlas_8'},
                'Atlas 9': {column: 'Atlas_9'},
            }, {xAxis: 'Time in Millisecond', yAxis: 'Distance in Millimeters'});
            chart.bind("#chart-line1");
            chart.render();
        });
        d3.csv('fortuna_fp.csv', function(error, data) {
            data.forEach(function (d) {
                d.timing = +d.timing;
                d.foreaft = +d.foreaft;
                d.lateral = +d.lateral;
                d.normal = +d.normal;
            });
            console.log(data);
            let chart = makeLineChart(data, 'timing', {
                'Fore-aft': {column: 'foreaft'},
                'Lateral': {column: 'lateral'},
                'Normal': {column: 'normal'},
            }, {xAxis: 'Time in Milliseconds', yAxis: 'Newtons'});
            chart.bind("#chart-line2");
            chart.render();
        });
    }
</script>
<script src="multiline.js" charset="utf-8"></script>
</body>
</html>