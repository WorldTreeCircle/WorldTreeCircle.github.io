<!DOCTYPE html>
<html>
<head>
    <title>Ex 7 - Javascript - Hello World Again</title>
    <script type="text/javascript">
        
        //Setup event handlers
        window.addEventListener("load", setupEventHandlers, false);

        //-------------------------------
        // name: setupEventHandlers()
        //-------------------------------
        function setupEventHandlers()
        {

            console.log("Inside setupEventHandlers function that is fired on the window load event");

            //Event handlers
            var HelloWorldButtonReference = document.getElementById("butHelloWorld");
            HelloWorldButtonReference.addEventListener("click", displayHelloWorld, false);


            


            var HelloWorldAgainButtonReference = document.getElementById("butHelloWorldAgain");
            HelloWorldAgainButtonReference.addEventListener("click", displayHelloWorldAgain, false);
        }
        
        
        //------------------------------------------------------
        // name: displayHelloWorld()
        // description: Function called when button is clicked
        //------------------------------------------------------
           function displayHelloWorld()
        {
            console.log("Inside displayHelloWorld function");

            document.getElementById('divDisplay1').innerHTML = "<h1>Hello World!</h1>";
        }

       
           
        
        function displayHelloWorldAgain()
        {
            console.log("Inside displayHelloWorldAgain function");

            document.getElementById('divDisplay2').innerHTML = "<h2>Hello World Again!</h2>";
        }

    </script>
</head>
<body>
    <h1><i>Hello World Again!</i></h1>

    <input type="button" id="butHelloWorld" value="Show Hello World" />
    <input type="button" id="butHelloWorldAgain" value="Show Hello World Again" />
    <br />
    <div id="divDisplay1"></div>
    <div id="divDisplay2"></div>
</body>
</html>
