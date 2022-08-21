<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX Form</title>
    <style>
        #result {
            display: none;
        }
        .error {
            border: 1px solid red;
        }
        #spinner {
            display: none;
        }
    </style>
</head>
<body>
    <div id="measurements">
        <p>Enter measurements to determine total volume</p>
        <form action="process_measurements.php" method="POST" id="measurement-form">
            Length: <input type="text" name="length" /><br/>
            Width: <input type="text" name="width" /><br/>
            Height: <input type="text" name="height" /><br/>
            <input id="html-submit" type="submit" value="Submit" />
        </form>
    </div>

    <div id="spinner">
        <img src="spinner.gif" alt="Loading" width="50" height="50" />
    </div>

    <div id="result">
        <p>The total volume is: <span id="volume"></span></p>
    </div>

    <script>
        var result_div = document.getElementById("result");
        var volume = document.getElementById("volume");
        var button = document.getElementById("html-submit");

        function showSpinner() {
            var spinner = document.getElementById("spinner");
            spinner.style.display = 'block';
        }

        function hideSpinner() {
            var spinner = document.getElementById("spinner");
            spinner.style.display = 'none';
        }

        function disableSubmitButton() {
            button.disabled = true;
            button.value = "Loading...";
        }

        function enableSubmitButton() {
            button.disabled = false;
            button.value = "Ajax Submit";
        }

        function displayErrors(errors) {
            var inputs = document.getElementsByTagName('input');
            for(let i = 0; i < inputs.length; i++) {
                var input = inputs[i];
                if(errors.indexOf(input.name) >= 0) {
                    input.classList.add('error');
                }
            }
        }

        function clearErrors() {
            var inputs = document.getElementsByTagName('input');
            for(let i = 0; i < inputs.length; i++) {
                inputs[i].classList.remove('error');
            }
        }

        function postResult(value) {
            volume.innerHTML = value;
            result_div.style.display = 'block';
        }

        function clearResult() {
            volume.innerHTML = '';
            result_div.style.display = 'none';
        }

        function gatherFormData(form) {
            var inputs = form.getElementsByTagName('input');
            var array = [];
            for(let i = 0; i < inputs.length; i++) {
                var inputNameValue = inputs[i].name + '=' + inputs[i].value;
                array.push(inputNameValue);
            }
            return array.join('&');
        }

        function calculateMeasurements() {
            clearResult();
            clearErrors();
            showSpinner();
            disableSubmitButton();

            var form = document.getElementById("measurement-form");
            var action = form.getAttribute("action");

            //var form_data = gatherFormData(form);
            var form_data = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', action, true);
            //Not set when using FormData
            //xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function() {
                if(xhr.readyState == 4 && xhr.status == 200) {
                    var result = xhr.responseText;
                    console.log('Result: ' + result);
                    hideSpinner();
                    enableSubmitButton();
                    var json = JSON.parse(result);
                    if(json.hasOwnProperty('errors') && json.errors.length > 0) {
                        displayErrors(json.errors);
                    } else {
                        postResult(json.volume);
                    }
                }
            };
            xhr.send(form_data);
        }

        button.addEventListener("click", function(event) {
            event.preventDefault();
            calculateMeasurements();
        });
    </script>
</body>
</html>