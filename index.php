<?php include("inc/header.php");?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked admin-menu ">
            <li><a><b>Suggestion Extraction Techniques</a></b>
            </li>
            <li class = "active"> <a href="#" data-target-id="NN">Deep Learning</a></li>
            <li><a href="svm.php" data-target-id="SVM">Support Vector Machines</a></li>
            <li><a href="RuleBased.php" data-target-id="RB">Rule Based</a></li>
        </ul>
    </div>
    <!-- Support Vector Machines-->
    <div class="col-md-9 well admin-content" id="SVM">
        <p>
            Enter text. An example text is already provided:
        </p>
        <div class="row">

            <form id="theForm" enctype='application/json' onsubmit="event.preventDefault();">
                <div class="col-sm-9">
                    <textarea class="form-control" rows="5" id="mainText1" value name="text" type="text">This is a fabulous hotel. The breakfasts are great - fresh fruit bagels, muffins, hot eggs and sausage etc. Note, the room can only accommodate two people who are close. Do not expect your family of four to be comfortable in one room. I highly recommend the fabulous little Italian restaurant just around the corner from the hotel, Bon Amici. I will stay at this hotel everytime I come to New York. </textarea>
                    <!--<input id="mainText1" name="text" type="text" class="form-control" value="This is a fabulous hotel.The breakfasts are great - fresh fruit  bagels, muffins, hot eggs and sausage etc.Just around the corner from the hotel is a fabulous little Italian restaurant - Bon Amici.I highly recommend it.">
                    <input id="mainText2" name="text" type="hidden" class="form-control" placeholder="Select the Language and Text Source for Suggestion Extraction" autofocus="autofocus">-->
                </div>
                <div class="row">
                    <div class="col-sm-1">
                        <select class="language-select" name="language" label="Language">
                            <option value="en" selected>English</option>
                            <!--<option value="es">Spanish</option>
                            <option value="fr">French</option>
                            <option value="it">Italian</option>-->
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <select class="language-select" name="textSource">
                            <option value="ge" selected>General</option>
                            <option value="tw">Twitter</option>
                        </select>
                    </div>
                </div>

        </div>

            
        <!--<div class="text-center"> <span>
		<input type="radio" name="textSource" value="twitter" id="tw"> Twitter 
		<input type="radio" name="textSource" value="general" id="ge"> General 
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="language" value="en" id="en"> English 
		<input type="radio" name="language" value="es" id="es"> Spanish  

	</div>
	<br>-->
        <br>
        <div class="text-center">
            <button type="submit" id="sendJson" class="btn btn-primary btn-md pull-left">Extract</button>
            <img src="images/Spinner.svg" id="image" hidden>
            <br>
            <br>
        </div>
        <pre id="result" hidden></pre>
    </div>
    <!-- jQuery Version 1.11.1 -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <script language="javascript" type="text/javascript">
        // This function will convert the form to JSON

        $.fn.serializeObject = function () {
            var o = {};
            o['text'] = [];
            var a = this.serializeArray();
            //alert(a);
            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            //alert(o);
            return o;
        };

        // Here you send & receive the data
        $(function () {

            $('#theForm').submit(function () {
                // First we get the JSON collected from the form
                $("#result").hide();
                var z = $('#theForm').serializeObject();
                    //alert(z)
                var jsonValue = JSON.stringify(z);
                $("#image").show();
                $("#sendJson").hide();
                console.log(jsonValue);
                // We form the request ()
                //alert
                var jsonUrl = "http://140.203.155.226:8080/miso/rest/suggest/getSuggestions?json=" + escape(jsonValue);
                // send the request
                $.ajax({
                    type: 'POST',
                    url: "inc/get.php",
                    datatype:'JSON',
                    data: {
                        "url": jsonUrl
                    },
                    success: function (response) {
                        console.log(response);
                        // Showing the result after using REGEX to clean it
                        $("#image").hide();
                        if (response.replace(/[^\w\s]/gi, '') == "") {
                            $('#result').text("No Suggestions found !");
                        } else {
                            //$('#result').text(response.replace(/[^\w\s\',']/gi, '').replace(/[',']/g,'.\n'));

                            $('#result').text(response.replace(/[^\w\s\'.']/gi, '').replace(/['.']/gi, '.\n'));
                        }
                        $('#result').show();
                        $('#sendJson').show();
                        //document.getElementById("mainText1").value = '';


                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        // Showing an error message if an error occured
                        $('#result').text(errorThrown);
                    }
                });

                // please don't remove the return false
                return false;
            });
        });
    </script>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="row">
    <?php include("inc/footer.php");?>